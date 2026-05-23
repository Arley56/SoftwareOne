<?php

namespace App\Http\Controllers;

use App\Models\MonitorSession;
use Illuminate\Http\Request;

class MonitorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user?->roles?->name !== 'Monitor') {
            return redirect()->route('dashboard')->with('warning', 'Esta sección es para monitores.');
        }

        $monitor = $user->monitorProfile()->with('subject')->first();

        $sessionsQuery = MonitorSession::with([
            'schedule.monitor.subject',
            'schedule.monitor.user',
        ])
            ->whereHas('schedule.monitor', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->withCount([
                'sessionEnrollments as active_enrollments_count' => function ($query) {
                    $query->where('status', 'activa');
                },
                'attendances',
                'feedbacks',
            ])
            ->orderByDesc('fecha')
            ->orderByDesc('id');

        $today = now()->toDateString();
        $monthStart = now()->startOfMonth()->toDateString();
        $monthEnd = now()->endOfMonth()->toDateString();

        $todaySessions = (clone $sessionsQuery)
            ->whereDate('fecha', $today)
            ->get();

        $monthSessions = (clone $sessionsQuery)
            ->whereBetween('fecha', [$monthStart, $monthEnd])
            ->get();

        $upcomingSessions = (clone $sessionsQuery)
            ->whereDate('fecha', '>=', $today)
            ->orderBy('fecha')
            ->orderBy('id')
            ->take(5)
            ->get();

        $dashboardData = [
            'monitor' => $monitor,
            'todaySessions' => $todaySessions,
            'monthSessions' => $monthSessions,
            'upcomingSessions' => $upcomingSessions,
            'todaySessionsCount' => $todaySessions->count(),
            'monthSessionsCount' => $monthSessions->count(),
            'activeEnrollmentsCount' => $monthSessions->sum('active_enrollments_count'),
            'attendancesCount' => $monthSessions->sum('attendances_count'),
            'feedbacksCount' => $monthSessions->sum('feedbacks_count'),
        ];

        return view('monitor.dashboard', $dashboardData);
    }
}