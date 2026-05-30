@php
    $initial = strtoupper(substr($announcement->user->name ?? 'U', 0, 1));
    $roleName = $announcement->user->roles->name ?? 'Monitor';
@endphp

<div class="session-announcement-card">
    <div class="card-body">
        <div class="d-flex align-items-start gap-3">
            <div class="session-announcement-avatar">{{ $initial }}</div>

            <div class="flex-grow-1">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="fw-semibold">{{ $announcement->user->name ?? 'Monitor' }}</span>
                        <span class="badge text-bg-warning text-dark">{{ $roleName }}</span>
                        <small class="text-secondary">{{ $announcement->created_at?->format('d/m/Y H:i') }}</small>
                    </div>
                </div>

                @if ($announcement->title)
                    <div class="fw-semibold mt-3">{{ $announcement->title }}</div>
                @endif

                <div class="session-announcement-message mt-3">
                    {{ $announcement->message }}
                </div>
            </div>
        </div>
    </div>
</div>