@php
    $announcements = $announcements ?? collect();
    $canAnnounce = $canAnnounce ?? false;
    $compact = $compact ?? false;
@endphp

@push('styles')
    <style>
        .session-announcements-shell {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.96), rgba(2, 6, 23, 0.98));
            border: 1px solid rgba(245, 158, 11, 0.28);
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.35);
            border-radius: 1.1rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .session-announcements-panel {
            position: sticky;
            top: 1rem;
            width: 100%;
        }

        .session-announcements-panel--compact .card-header {
            padding-top: 0.7rem;
            padding-bottom: 0.7rem;
        }

        .session-announcements-panel--compact .card-header h5 {
            font-size: 1.05rem;
        }

        .session-announcements-panel--compact .card-header small {
            font-size: 0.76rem;
        }

        .session-announcements-panel--compact .badge {
            font-size: 0.72rem;
        }

        .session-announcements-panel--compact .card-body {
            padding-top: 0.7rem !important;
        }

        .session-announcements-panel--compact .session-announcement-composer {
            padding: 0.7rem;
            margin-bottom: 0.75rem !important;
        }

        .session-announcements-panel--compact .session-announcement-composer .d-flex.align-items-center {
            gap: 0.65rem !important;
            margin-bottom: 0.6rem !important;
        }

        .session-announcements-panel--compact .session-announcement-avatar {
            width: 28px;
            height: 28px;
            font-size: 0.78rem;
        }

        .session-announcements-panel--compact .session-announcement-composer .form-label {
            margin-bottom: 0.3rem;
            font-size: 0.86rem;
        }

        .session-announcements-panel--compact .session-announcement-composer .form-control {
            font-size: 0.88rem;
            padding-top: 0.45rem;
            padding-bottom: 0.45rem;
        }

        .session-announcements-panel--compact .session-announcement-composer textarea.form-control {
            min-height: 78px;
        }

        .session-announcements-panel--compact .session-announcement-composer .btn {
            padding-top: 0.45rem;
            padding-bottom: 0.45rem;
            font-size: 0.88rem;
        }

        .session-announcements-panel--compact .session-announcement-card .card-body {
            padding: 0.55rem 0.65rem;
        }

        .session-announcements-panel--compact .session-announcement-message {
            padding: 0.55rem 0.6rem;
            font-size: 0.84rem;
        }

        @media (max-width: 991.98px) {
            .session-announcements-panel {
                position: static;
            }
        }

        .session-announcements-feed {
            display: grid;
            gap: 0.65rem;
            padding-right: 0.35rem;
        }

        .session-announcement-card {
            background: rgba(15, 23, 42, 0.88);
            border: 1px solid rgba(245, 158, 11, 0.22);
            border-radius: 0.95rem;
            overflow: hidden;
        }

        .session-announcement-card .card-body {
            padding: 0.7rem 0.8rem;
        }

        .session-announcement-avatar {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            color: #fff;
            background: linear-gradient(135deg, #f59e0b, #0ea5e9);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.12);
            flex: 0 0 auto;
        }

        .session-announcement-message {
            background: rgba(2, 6, 23, 0.5);
            border: 1px solid rgba(245, 158, 11, 0.18);
            border-radius: 0.8rem;
            padding: 0.65rem 0.75rem;
            white-space: pre-wrap;
            color: #e2e8f0;
            font-size: 0.9rem;
        }

        .session-announcement-composer {
            background: rgba(2, 6, 23, 0.6);
            border: 1px solid rgba(245, 158, 11, 0.22);
            border-radius: 0.95rem;
            padding: 0.9rem;
        }

        .session-announcements-scroll {
            min-height: 0;
            height: {{ $compact ? '190px' : '250px' }};
            overflow-y: scroll;
            scrollbar-gutter: stable;
            padding-right: 0.1rem;
        }
    </style>
@endpush

<div class="card session-announcements-shell border border-secondary text-light mb-4 session-announcements-panel {{ $compact ? 'session-announcements-panel--compact' : '' }}">
    <div class="card-header border-secondary border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="mb-0">Anuncios</h5>
            <small class="text-secondary">Mensajes oficiales para esta monitoría.</small>
        </div>
        <span class="badge text-bg-warning text-dark">{{ $announcements->count() }} avisos</span>
    </div>

    <div class="card-body pt-3 d-flex flex-column" style="min-height: 0; flex: 1;">
        <div id="session-announcements-feedback"></div>

        @if ($canAnnounce)
            <div class="session-announcement-composer border border-secondary mb-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="session-announcement-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                    <div>
                        <div class="fw-semibold">{{ auth()->user()->name ?? 'Monitor' }}</div>
                        <small class="text-secondary">Publica un aviso visible para los inscritos.</small>
                    </div>
                </div>

                <form
                    action="{{ route('monitor-sessions.announcements.store', $monitorSession->id) }}"
                    method="POST"
                    class="js-session-announcement-form"
                >
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Título opcional</label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            maxlength="120"
                            placeholder="Ej: Cambio de horario, material nuevo..."
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mensaje</label>
                        <textarea
                            name="message"
                            class="form-control"
                            rows="{{ $compact ? 2 : 3 }}"
                            maxlength="2000"
                            placeholder="Escribe el anuncio para los estudiantes..."
                            required
                        ></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning text-dark fw-semibold rounded-pill px-4">Publicar anuncio</button>
                    </div>
                </form>
            </div>
        @endif

        <div class="session-announcements-scroll">
            <div class="session-announcements-feed" id="session-announcements-wrapper">
                @include('session_announcements._list', [
                    'announcements' => $announcements,
                ])
            </div>
        </div>
    </div>
</div>

@include('session_announcements._script')