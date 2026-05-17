<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $users = User::all();
        $subjects = Subject::all();
        $roles = Role::all();
        return view('users.create', compact('users', 'subjects', 'roles'));
    }

    public function store(Request $request)
    {
        $user = new User();
        $request->validate([
        'role_id' => 'required|exists:roles,id',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->estado = $request->estado;
        $user->role_id = $request->role_id;
        if ($request->hasFile('photo')) {

            $path = $request->file('photo')->store('profiles', 'public');

            $user->photo = $path;
        }

        $user->save();
        return redirect()->route('users.index');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

     public function update(Request $request, string $id)
    {

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->estado = $request->estado;
        if ($request->hasFile('photo')) {

            $path = $request->file('photo')->store('profiles', 'public');

            $user->photo = $path;
        }
        $request->validate([
        'estado' => 'required|in:activo,inactivo',

        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $user->save();
        return redirect()->route('users.index');
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index');
    }
}
