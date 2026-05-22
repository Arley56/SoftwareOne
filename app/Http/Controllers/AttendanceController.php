<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\User;
use App\Models\MonitorSession;
use App\Models\Subject;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function index()
    {
        $attendances = Attendance::with(['MonitorSession'])->paginate(10);
        return view('attendances.index', compact('attendances'));
    }


    public function create()
    {
        $users = User::all();
        $sessions = MonitorSession::all();

        return view('attendances.create', compact('users', 'sessions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'monitor_session_id' => 'required',
            'user_id' => 'required',
            'asistio' => 'required'
        ]);

        $data = $request->only(['monitor_session_id', 'user_id', 'asistio']);

        Attendance::updateOrCreate(
            ['monitor_session_id' => $data['monitor_session_id'], 'user_id' => $data['user_id']],
            ['asistio' => $data['asistio']]
        );

        return redirect()->route('attendances.index')->with('status', 'Asistencia registrada o actualizada.');
    }


    public function show(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        return view('attendances.show', compact('attendance'));
    }


    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $users = User::all();
        $sessions = MonitorSession::all();

        return view('attendances.edit', compact('attendance', 'users', 'sessions'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'monitor_session_id' => 'required',
            'user_id' => 'required',
            'asistio' => 'required'
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->all());

        return redirect()->route('attendances.index');
    }

    public function destroy(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return redirect()->route('attendances.index');
    }
}
