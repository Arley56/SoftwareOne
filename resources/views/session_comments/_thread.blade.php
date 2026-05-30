@php
    $comments = $comments ?? collect();
    $canComment = $canComment ?? false;
@endphp

@push('styles')
    <style>
        .session-comments-shell {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.96), rgba(2, 6, 23, 0.98));
            border: 1px solid rgba(148, 163, 184, 0.28);
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.35);
            border-radius: 1.1rem;
            overflow: hidden;
        }

        .session-comments-feed {
            display: grid;
            gap: 0.8rem;
        }

        .session-comment-card {
            background: rgba(15, 23, 42, 0.88);
            border: 1px solid rgba(148, 163, 184, 0.26);
            border-radius: 0.95rem;
            overflow: hidden;
        }

        .session-comment-card .card-body {
            padding: 0.85rem 0.95rem;
        }

        .session-comment-avatar {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
            background: linear-gradient(135deg, #2563eb, #14b8a6);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,.12);
            flex: 0 0 auto;
        }

        .session-comment-message {
            background: rgba(2, 6, 23, 0.5);
            border: 1px solid rgba(148, 163, 184, 0.24);
            border-radius: 0.8rem;
            padding: 0.75rem 0.85rem;
            white-space: pre-wrap;
            color: #e2e8f0;
            font-size: 0.95rem;
        }

        .session-comment-replies {
            margin-top: 0.85rem;
            padding-left: 0.85rem;
            border-left: 2px solid rgba(96, 165, 250, 0.55);
            display: grid;
            gap: 0.7rem;
        }

        .session-comment-composer {
            background: rgba(2, 6, 23, 0.6);
            border: 1px solid rgba(148, 163, 184, 0.26);
            border-radius: 0.95rem;
            padding: 0.9rem;
        }
    </style>
@endpush

<div class="card session-comments-shell border border-secondary text-light mb-4" id="session-comments-card">
    <div class="card-header border-secondary border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
        <div>
            <h5 class="mb-0">Comentarios</h5>
            <small class="text-secondary">Hilo compartido entre estudiantes inscritos y el monitor.</small>
        </div>
        <span class="badge text-bg-info text-dark">{{ $comments->count() }} hilos</span>
    </div>

    <div class="card-body pt-3">
        <div id="session-comments-feedback"></div>

        @if ($canComment)
            <div class="session-comment-composer border border-secondary mb-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="session-comment-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                    <div>
                        <div class="fw-semibold">{{ auth()->user()->name ?? 'Usuario' }}</div>
                        <small class="text-secondary">Publica un comentario para abrir la conversación.</small>
                    </div>
                </div>

                <form
                    action="{{ route('monitor-sessions.comments.store', $monitorSession->id) }}"
                    method="POST"
                    class="js-session-comment-form"
                >
                    @csrf

                    <input type="hidden" name="parent_id" value="">

                    <div class="mb-3">
                        <label class="form-label">Escribe un comentario</label>
                        <textarea
                            name="message"
                            class="form-control"
                            rows="3"
                            maxlength="2000"
                            placeholder="Comparte una duda, avance o respuesta..."
                            required
                        ></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-info text-dark fw-semibold rounded-pill px-4">Publicar comentario</button>
                    </div>
                </form>
            </div>
        @endif

        <div class="session-comments-feed" id="session-comments-wrapper">
            @include('session_comments._list', [
                'comments' => $comments,
                'canComment' => $canComment,
            ])
        </div>
    </div>
</div>
