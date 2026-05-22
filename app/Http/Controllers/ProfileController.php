<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Arr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $monitor = $request->user()->monitorProfile()->with('subject')->first();

        return view('profile.edit', [
            'user' => $request->user(),
            'monitor' => $monitor,
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->user()->fill(Arr::only($validated, ['name', 'email']));

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $monitor = $request->user()->monitorProfile()->first();

        if ($monitor !== null) {
            $monitor->fill(Arr::only($validated, ['subject_id', 'description']));
            $monitor->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
