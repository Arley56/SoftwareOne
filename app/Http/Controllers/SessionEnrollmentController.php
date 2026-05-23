<?php

namespace App\Http\Controllers;

use App\Models\MonitorSession;
use App\Models\SessionEnrollment;
use Illuminate\Http\Request;

class SessionEnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user?->roles?->name === 'Administrador') {
            return redirect()->route('dashboard')->with('warning', 'Esta sección es para estudiantes.');
        }

        $enrollments = SessionEnrollment::with([
            'monitorSession.schedule.monitor.subject',
            'monitorSession.schedule.monitor.user',
        ])
            ->where('user_id', $user->id)
            ->where('status', 'activa')
            ->latest()
            ->paginate(10);

        return view('session_enrollments.index', compact('enrollments'));
    }

    public function store(Request $request, MonitorSession $monitorSession)
    {
        $user = $request->user();

        if ($user?->roles?->name === 'Administrador') {
            return back()->with('error', 'Un administrador no puede inscribirse en monitorías.');
        }

        $enrollment = SessionEnrollment::where('user_id', $user->id)
            ->where('monitor_session_id', $monitorSession->id)
            ->first();

        if ($enrollment && $enrollment->status === 'activa') {
            return back()->with('warning', 'Ya estás inscrito en esta monitoría.');
        }

        if ($enrollment && $enrollment->status === 'anulada') {
            $enrollment->update([
                'status' => 'activa',
                'enrolled_at' => now(),
                'cancelled_at' => null,
            ]);

            return back()->with('success', 'Inscripción reactivada correctamente.');
        }

        SessionEnrollment::create([
            'user_id' => $user->id,
            'monitor_session_id' => $monitorSession->id,
            'status' => 'activa',
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'Te has inscrito correctamente en la monitoría.');
    }

    public function show(Request $request, SessionEnrollment $sessionEnrollment)
    {
        $user = $request->user();
        $isAdmin = $user?->roles?->name === 'Administrador';

        if (! $isAdmin && (int) $sessionEnrollment->user_id !== (int) $user->id) {
            abort(403);
        }

        $sessionEnrollment->load([
            'monitorSession.schedule.monitor.subject',
            'monitorSession.schedule.monitor.user',
            'user',
        ]);

        return view('session_enrollments.show', compact('sessionEnrollment'));
    }

    public function destroy(Request $request, SessionEnrollment $sessionEnrollment)
    {
        $user = $request->user();

        if ((int) $sessionEnrollment->user_id !== (int) $user->id) {
            abort(403);
        }

        if ($sessionEnrollment->status === 'anulada') {
            return back()->with('info', 'La inscripción ya estaba anulada.');
        }

        $sessionEnrollment->update([
            'status' => 'anulada',
            'cancelled_at' => now(),
        ]);

        return redirect()
            ->route('session-enrollments.index')
            ->with('success', 'Inscripción anulada correctamente.');
    }
}
