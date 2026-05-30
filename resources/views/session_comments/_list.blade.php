@php
    $comments = $comments ?? collect();
    $canComment = $canComment ?? false;
@endphp

@forelse ($comments as $comment)
    @include('session_comments._comment', [
        'comment' => $comment,
        'canComment' => $canComment,
        'level' => 0,
    ])
@empty
    <div class="text-center text-secondary py-4">
        Todavía no hay comentarios en esta monitoría.
    </div>
@endforelse