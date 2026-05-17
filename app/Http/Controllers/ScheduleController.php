<?php

namespace App\Http\Controllers;
use App\Models\Schedule;
use App\Models\Monitor;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    public function index()
    {
        $schedules = Schedule::with('monitor.user')->paginate(10);
        return view('schedules.index', compact('schedules'));
    }
    public function create()
    {
        $monitors = Monitor::with('user')->get();
        return view('schedules.create', compact('monitors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'monitor_id' => 'required',
            'dia_semana' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'modalidad' => 'required',
            'salon'=>'nullable|string|max:20',
        ]);

        Schedule::create($request->all());

        return redirect()->route('schedules.index');
    }


    public function show($id)
    {
        $schedule = Schedule::with('monitor.user')->findOrFail($id);

        return view('schedules.show', compact('schedule'));
    }


    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $monitors = Monitor::with('user')->get();
        return view('schedules.edit', compact('schedule', 'monitors'));
    }

    public function update(Request $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->dia_semana = $request->input('dia_semana');
        $schedule->hora_inicio = $request->input('hora_inicio');
        $schedule->hora_fin = $request->input('hora_fin');
        $schedule->modalidad = $request->input('modalidad');
        $schedule->salon = $request->input('salon');
        $schedule->save();
        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
