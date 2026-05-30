<?php

namespace App\Http\Controllers;

use App\Models\MonitorSession;
use App\Models\SessionComment;
use App\Models\SessionEnrollment;
use Illuminate\Http\Request;

class SessionCommentController extends Controller
{
    public function store(Request $request, MonitorSession $monitorSession)
    {
        $user = $request->user();
        $userRoleId = (int) $user->role_id;
        $isAjaxRequest = $request->expectsJson() || $request->ajax();

        $monitorSession->loadMissing('schedule.monitor.user');

        $isOwnerMonitor = $userRoleId === 2
            && (int) ($monitorSession->schedule->monitor->user_id ?? 0) === (int) $user->id;

        $isActiveStudent = $userRoleId === 3
            && SessionEnrollment::where('monitor_session_id', $monitorSession->id)
                ->where('user_id', $user->id)
                ->where('status', 'activa')
                ->exists();

        if (! $isOwnerMonitor && ! $isActiveStudent) {
            if ($isAjaxRequest) {
                return response()->json([
                    'ok' => false,
                    'message' => 'No tienes permiso para comentar en esta monitoría.',
                ], 403);
            }

            abort(403, 'No tienes permiso para comentar en esta monitoría.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
            'parent_id' => 'nullable|integer|exists:session_comments,id',
        ]);

        $parentId = $validated['parent_id'] ?? null;

        if ($parentId) {
            $parentComment = SessionComment::whereKey($parentId)
                ->where('monitor_session_id', $monitorSession->id)
                ->firstOrFail();

            if (! is_null($parentComment->parent_id)) {
                if ($isAjaxRequest) {
                    return response()->json([
                        'ok' => false,
                        'message' => 'Solo puedes responder comentarios principales.',
                    ], 422);
                }

                abort(422, 'Solo puedes responder comentarios principales.');
            }
        }

        SessionComment::create([
            'monitor_session_id' => $monitorSession->id,
            'user_id' => $user->id,
            'parent_id' => $parentId,
            'message' => $validated['message'],
        ]);

        $monitorSession->load([
            'sessionComments.user.roles',
            'sessionComments.replies.user.roles',
        ]);

        $canComment = $isOwnerMonitor || $isActiveStudent;
        $comments = $monitorSession->sessionComments;

        if ($isAjaxRequest) {
            return response()->json([
                'ok' => true,
                'message' => 'Comentario publicado correctamente.',
                'html' => view('session_comments._list', [
                    'monitorSession' => $monitorSession,
                    'comments' => $comments,
                    'canComment' => $canComment,
                ])->render(),
            ]);
        }

        return back()->with('success', 'Comentario publicado correctamente.');
    }
}
