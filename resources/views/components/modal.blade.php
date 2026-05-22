@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

<div class="modal fade" id="{{ $name }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-{{ $maxWidth }}">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>
