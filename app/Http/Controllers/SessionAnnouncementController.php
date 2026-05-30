<?php

namespace App\Http\Controllers;

use App\Models\MonitorSession;
use App\Models\SessionAnnouncement;
use Illuminate\Http\Request;

class SessionAnnouncementController extends Controller
{
    public function store(Request $request, MonitorSession $monitorSession)
    {
        $user = $request->user();
        $userRoleId = (int) $user->role_id;
        $isAjaxRequest = $request->expectsJson() || $request->ajax();

        $monitorSession->loadMissing('schedule.monitor.user');

        $isOwnerMonitor = $userRoleId === 2
            && (int) ($monitorSession->schedule->monitor->user_id ?? 0) === (int) $user->id;

        if (! $isOwnerMonitor) {
            if ($isAjaxRequest) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Solo el monitor responsable puede publicar anuncios.',
                ], 403);
            }

            abort(403, 'Solo el monitor responsable puede publicar anuncios.');
        }

        $validated = $request->validate([
            'title' => 'nullable|string|max:120',
            'message' => 'required|string|max:2000',
        ]);

        SessionAnnouncement::create([
            'monitor_session_id' => $monitorSession->id,
            'user_id' => $user->id,
            'title' => $validated['title'] ?? null,
            'message' => $validated['message'],
        ]);

        $monitorSession->load([
            'sessionAnnouncements.user.roles',
        ]);

        $announcements = $monitorSession->sessionAnnouncements;

        if ($isAjaxRequest) {
            return response()->json([
                'ok' => true,
                'message' => 'Anuncio publicado correctamente.',
                'html' => view('session_announcements._list', [
                    'announcements' => $announcements,
                    'canAnnounce' => true,
                ])->render(),
            ]);
        }

        return back()->with('success', 'Anuncio publicado correctamente.');
    }
}