@php
    $announcements = $announcements ?? collect();
@endphp

@forelse ($announcements as $announcement)
    @include('session_announcements._announcement', [
        'announcement' => $announcement,
    ])
@empty
    <div class="text-center text-secondary py-4">
        Aun no hay avisos publicados para esta monitoría.
    </div>
@endforelse