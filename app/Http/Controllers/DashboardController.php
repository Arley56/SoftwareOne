<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Monitor;
use App\Models\Schedule;
use App\Models\MonitorSession;
use App\Models\Attendance;
use App\Models\SessionEnrollment;


use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $sessionsQuery = MonitorSession::with(['schedule.monitor.user', 'schedule.monitor.subject'])
            ->orderByDesc('fecha')
            ->orderByDesc('id');

        if ($request->filled('subject')) {
            $subject = $request->input('subject');

            $sessionsQuery->whereHas('schedule.monitor.subject', function ($query) use ($subject) {
                $query->where('name', 'like', '%' . $subject . '%');
            });
        }

        if ($request->filled('monitor')) {
            $monitor = $request->input('monitor');

            $sessionsQuery->whereHas('schedule.monitor.user', function ($query) use ($monitor) {
                $query->where('name', 'like', '%' . $monitor . '%');
            });
        }

        if ($request->filled('fecha')) {
            $fecha = $request->input('fecha');

            $sessionsQuery->whereDate('fecha', $fecha);
        }

        $sessions = $sessionsQuery->paginate(8)->withQueryString();

        $enrolledSessionIds = [];
        $enrollmentMap = [];
        if ($user?->roles?->name !== 'Administrador') {
            $sessionPageIds = $sessions->pluck('id')->all();

            if (!empty($sessionPageIds)) {
                $activeEnrollments = SessionEnrollment::where('user_id', $user->id)
                    ->whereIn('monitor_session_id', $sessionPageIds)
                    ->where('status', 'activa')
                    ->get(['id', 'monitor_session_id']);

                $enrolledSessionIds = $activeEnrollments->pluck('monitor_session_id')->all();
                $enrollmentMap = $activeEnrollments
                    ->mapWithKeys(fn ($item) => [$item->monitor_session_id => $item->id])
                    ->all();
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard._sessions', [
                    'sessions' => $sessions,
                    'enrolledSessionIds' => $enrolledSessionIds,
                    'enrollmentMap' => $enrollmentMap,
                ])->render(),
                'url' => $request->fullUrl(),
            ]);
        }

        $dashboardData = [
            'totalUsers' => User::count(),
            'totalMonitors' => Monitor::count(),
            'totalSchedules' => Schedule::count(),
            'totalSessions' => MonitorSession::count(),
            'totalAttendances' => Attendance::count(),
            'recentAttendances' => Attendance::with('user')->latest()->take(5)->get(),
            'sessions' => $sessions,
            'enrolledSessionIds' => $enrolledSessionIds,
            'enrollmentMap' => $enrollmentMap,
        ];

        if ($user?->roles?->name === 'Administrador') {
            return view('dashboard1', $dashboardData);
        }

        return view('dashboard', $dashboardData);
    }
}