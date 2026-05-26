<?php

namespace App\Http\Controllers;

use App\Models\MonitorSession;
use App\Models\SessionEnrollment;
use Illuminate\Http\Request;
use App\Models\SessionExercise;
use Illuminate\Support\Facades\Storage;

class SessionEnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (in_array($user->role_id, [1, 2])) {

            return redirect()
                ->route('dashboard')
                ->with('warning', 'Esta sección es para estudiantes.');
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

        if (in_array($user->role_id, [1, 2])) {

            return back()
                ->with('error', 'Solo los estudiantes pueden inscribirse.');
        }

        $enrollment = SessionEnrollment::where('user_id', $user->id)
            ->where('monitor_session_id', $monitorSession->id)
            ->first();

        if ($enrollment && $enrollment->status === 'activa') {

            return back()
                ->with('warning', 'Ya estás inscrito en esta monitoría.');
        }

        if ($enrollment && $enrollment->status === 'anulada') {

            $enrollment->update([
                'status' => 'activa',
                'enrolled_at' => now(),
                'cancelled_at' => null,
            ]);

            return back()
                ->with('success', 'Inscripción reactivada correctamente.');
        }

        SessionEnrollment::create([
            'user_id' => $user->id,
            'monitor_session_id' => $monitorSession->id,
            'status' => 'activa',
            'enrolled_at' => now(),
        ]);

        return back()
            ->with('success', 'Te has inscrito correctamente.');
    }

    public function show(Request $request, SessionEnrollment $sessionEnrollment)
    {
        $user = $request->user();

        $isAdmin = $user->role_id === 1;

        if (
            ! $isAdmin &&
            (int) $sessionEnrollment->user_id !== (int) $user->id
        ) {

            abort(403);
        }

        if (
            ! $isAdmin &&
            $sessionEnrollment->status !== 'activa'
        ) {

            abort(403, 'Solo puedes ver materiales de una inscripción activa.');
        }

        $sessionEnrollment->load([
            'monitorSession.schedule.monitor.subject',
            'monitorSession.schedule.monitor.user',
            'user',
            'monitorSession.sessionMaterials.uploader',
        ]);

        return view(
            'session_enrollments.show',
            compact('sessionEnrollment')
        );
    }
    public function exportPdf(Request $request)
    {
        $user = $request->user();

        $enrollments = SessionEnrollment::with([
            'monitorSession.schedule.monitor.subject',
            'monitorSession.schedule.monitor.user',
        ])
        ->where('user_id', $user->id)
        ->get();

        return view(
            'session_enrollments.pdf',
            compact('enrollments', 'user')
        );
    }

    public function uploadExercise(Request $request, $id)
    {
        $sessionEnrollment = SessionEnrollment::findOrFail($id);

        $request->validate([
            'exercise_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('exercise_file');

        /*
        |--------------------------------------------------------------------------
        | ELIMINAR ARCHIVO ANTERIOR
        |--------------------------------------------------------------------------
        */

        if (
            $sessionEnrollment->student_file &&
            Storage::disk('public')->exists($sessionEnrollment->student_file)
        ) {

            Storage::disk('public')->delete(
                $sessionEnrollment->student_file
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GUARDAR NUEVO ARCHIVO
        |--------------------------------------------------------------------------
        */

        $path = $file->store(
            'student-files',
            'public'
        );

        /*
        |--------------------------------------------------------------------------
        | GUARDAR EN SESSION_ENROLLMENTS
        |--------------------------------------------------------------------------
        */

        $sessionEnrollment->student_file = $path;

        $sessionEnrollment->student_file_mime =
            $file->getClientMimeType();

        $sessionEnrollment->student_file_size =
            $file->getSize();

        $sessionEnrollment->save();

        /*
        |--------------------------------------------------------------------------
        | OPCIONAL: REGISTRO HISTÓRICO
        |--------------------------------------------------------------------------
        */

        SessionExercise::create([
            'session_enrollment_id' => $sessionEnrollment->id,
            'uploaded_by_user_id' => auth()->id(),
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Archivo cargado correctamente.');
    }

    public function destroy(
        Request $request,
        SessionEnrollment $sessionEnrollment
    ) {

        $user = $request->user();

        if (
            (int) $sessionEnrollment->user_id !== (int) $user->id
        ) {

            abort(403);
        }

        if ($sessionEnrollment->status === 'anulada') {

            return back()
                ->with('info', 'La inscripción ya estaba anulada.');
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