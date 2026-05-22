<?php

namespace App\Http\Controllers;
use App\Models\MonitorSession;
use App\Models\Schedule;
use Illuminate\Http\Request;

class MonitorSessionController extends Controller
{
    public function index()
    {
        $sessions = MonitorSession::with('schedule.monitor.user')->paginate(10);
        return view('monitor_sessions.index', compact('sessions'));
    }

    public function create()
    {
        $schedules = Schedule::with('monitor.user')->get();
        return view('monitor_sessions.create', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required',
            'fecha' => 'required|date'
        ]);

        MonitorSession::create($request->all());

        return redirect()->route('monitor-sessions.index');
    }

    public function show($id)
    {
        $session = MonitorSession::with('schedule')->findOrFail($id);
        return view('monitor_sessions.show', compact('session'));
    }

    public function edit($id)
    {
        $session = MonitorSession::findOrFail($id);
        $schedules = Schedule::with('monitor.user')->get();

        return view('monitor_sessions.edit', compact('session', 'schedules'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'schedule_id' => 'required',
            'fecha' => 'required|date'
        ]);

        $session = MonitorSession::findOrFail($id);
        $session->update($request->all());

        return redirect()->route('monitor-sessions.index');
    }

    public function destroy($id)
    {
        $session = MonitorSession::findOrFail($id);
        $session->delete();
        return redirect()->route('monitor-sessions.index');
    }
}
