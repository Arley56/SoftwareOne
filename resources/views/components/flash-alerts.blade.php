@php
    $alerts = [
        'status' => ['type' => 'success', 'message' => session('status')],
        'success' => ['type' => 'success', 'message' => session('success')],
        'warning' => ['type' => 'warning', 'message' => session('warning')],
        'error' => ['type' => 'danger', 'message' => session('error')],
        'info' => ['type' => 'info', 'message' => session('info')],
    ];
@endphp

@foreach ($alerts as $alert)
    @if ($alert['message'])
        <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            {{ $alert['message'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
@endforeach