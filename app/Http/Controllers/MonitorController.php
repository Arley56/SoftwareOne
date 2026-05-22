<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitor;
use App\Models\User;
use App\Models\Subject;
use App\Models\Role;
use Illuminate\Support\Facades\Redirect;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $monitors = Monitor::with(['user', 'subject'])->paginate(15);
        $subjects = Subject::all();
        return view('monitors.index', compact('monitors', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereDoesntHave('monitors')->get();
        $subjects = Subject::all();
        return view('monitors.create', compact('users', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'semestre_monitor' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
        ]);

        Monitor::create([
            'semestre' => $request->semestre_monitor,
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
            'description' => $request->description,
        ]);

        return Redirect()->route('monitors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $monitor = Monitor::findOrFail($id);
        $subjects = Subject::all();
        $users = User::where(function ($query) {
            // Condición 1: No tener monitores Y estar Activo
            $query->whereDoesntHave('monitors')
                ->where('estado', 'Activo'); // Ajusta 'Activo' al valor exacto de tu BD
        })
            ->orWhere('id', $monitor->user_id) // Condición 2: O ser el monitor actual
            ->get();
        return view('monitors.edit', compact('monitor', 'subjects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'semestre_monitor' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000'
        ]);

        $monitor = Monitor::findOrFail($id);

        $monitor->user_id = $request->user_id;
        $monitor->subject_id = $request->subject_id;
        $monitor->semestre = $request->semestre_monitor;
        $monitor->description = $request->description;

        $monitor->save();

        return redirect()
            ->route('monitors.index')
            ->with('success', 'Monitor actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $monitor = Monitor::findOrFail($id);

        $monitor->delete();

        return redirect()->route('monitors.index')
            ->with('success', 'Monitor eliminado correctamente.');
    }
}
