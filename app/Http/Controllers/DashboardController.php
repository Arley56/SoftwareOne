<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Monitor;
use App\Models\Schedule;
use App\Models\MonitorSession;
use App\Models\Attendance;


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

        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard._sessions', [
                    'sessions' => $sessions,
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
        ];

        if ($user?->roles?->name === 'Administrador') {
            return view('dashboard1', $dashboardData);
        }

        return view('dashboard', $dashboardData);
    }
}