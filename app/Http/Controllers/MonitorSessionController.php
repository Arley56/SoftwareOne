<?php

namespace App\Http\Controllers;
use App\Models\MonitorSession;
use App\Models\Schedule;
use App\Models\SessionMaterial;
use Illuminate\Support\Facades\Storage;
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
        $user = request()->user();

        $session = MonitorSession::with([
            'schedule.monitor.user',
            'sessionEnrollments' => function ($query) {
                $query->where('status', 'activa')
                    ->with([
                        'user',
                        'sessionExercises'
                    ]);
            },
            'sessionMaterials.uploader',
            'sessionAnnouncements.user.roles',
        ])->findOrFail($id);

        $isAdmin = (int) $user->role_id === 1;
        $isOwnerMonitor = (int) $user->role_id === 2
            && (int) ($session->schedule->monitor->user_id ?? 0) === (int) $user->id;

        $canViewComments = $isAdmin || $isOwnerMonitor;
        $canViewAnnouncements = $isAdmin || $isOwnerMonitor;
        $canComment = $isOwnerMonitor;
        $canAnnounce = $isOwnerMonitor;

        if ($canViewComments) {
            $session->load([
                'sessionComments.user.roles',
                'sessionComments.replies.user.roles',
            ]);
        }

        return view('monitor_sessions.show', compact('session', 'canViewComments', 'canViewAnnouncements', 'canComment', 'canAnnounce'));
    }

    public function destroyMaterial(Request $request, MonitorSession $monitorSession, SessionMaterial $sessionMaterial)
    {
        abort_unless(
            $request->user()?->roles?->name === 'Monitor' && $sessionMaterial->monitor_session_id === $monitorSession->id,
            403
        );

        Storage::disk('public')->delete($sessionMaterial->file_path);
        $sessionMaterial->delete();

        return redirect()
            ->route('monitor-sessions.show', $monitorSession->id)
            ->with('status', 'Material eliminado correctamente.');
    }

    public function storeMaterial(Request $request, MonitorSession $monitorSession)
    {
        abort_unless($request->user()?->roles?->name === 'Monitor', 403);

        $request->validate([
            'material' => 'required|file|max:20480',
        ]);

        $file = $request->file('material');
        $originalName = $file->getClientOriginalName();
        $path = $file->storePublicly("monitor-session-materials/{$monitorSession->id}", 'public');

        SessionMaterial::create([
            'monitor_session_id' => $monitorSession->id,
            'uploaded_by_user_id' => $request->user()->id,
            'original_name' => $originalName,
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return redirect()
            ->route('monitor-sessions.show', $monitorSession->id)
            ->with('status', 'Material de apoyo cargado correctamente.');
    }
    public function storeStudentMaterial(Request $request, MonitorSession $monitorSession)
    {
        $request->validate([
            'exercise_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('exercise_file');

        $originalName = $file->getClientOriginalName();

        $path = $file->storePublicly(
            "student-materials/{$monitorSession->id}",
            'public'
        );

        SessionMaterial::create([
            'monitor_session_id' => $monitorSession->id,
            'uploaded_by_user_id' => auth()->id(),
            'original_name' => $originalName,
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Archivo cargado correctamente.');
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
