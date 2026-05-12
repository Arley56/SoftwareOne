<?php

namespace App\Http\Controllers;
use App\Models\Subject;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
   
    public function index()
    {
        $subjects = Subject::all();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:subjects,code',
            'credits' => 'required|integer',
        ], [
            'code.unique' => 'Ya existe una materia con ese código.',
            'code.required' => 'El código es obligatorio.',
        ]);

        $subject = new Subject();
        $subject->name = $request->name;
        $subject->code = $request->code;
        $subject->credits = $request->credits;
        $subject->description = $request->description;
        $subject->save();

        return redirect()->route('subjects.index');
    }

    public function show(string $id)
    {
        $subject = Subject::findOrFail($id);
        return view('subjects.show', compact('subject'));
    }


    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        return view('subjects.edit', compact('subject'));
    }

  
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'name' => 'required',
            // Aquí está la magia: le concatenamos el ID actual para que lo ignore
            'code' => 'required|unique:subjects,code,' . $id,
            'credits' => 'required|integer',
        ], [
            'code.unique' => 'Ya existe una materia con ese código.',
            'code.required' => 'El código es obligatorio.',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->name = $request->name;
        $subject->code = $request->code;
        $subject->credits = $request->credits;
        $subject->description = $request->description;
        $subject->save();
        
        return redirect()->route('subjects.index');
    }

  
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect()->route('subjects.index');
    }
}
