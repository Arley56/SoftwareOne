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
    public function index()
    {
        return view('dashboard', [
            'totalUsers' => User::count(),
            'totalMonitors' => Monitor::count(),
            'totalSchedules' => Schedule::count(),
            'totalSessions' => MonitorSession::count(),
            'totalAttendances' => Attendance::count(),
            'recentAttendances' => Attendance::with('user')->latest()->take(5)->get()
        ]);
    }
}