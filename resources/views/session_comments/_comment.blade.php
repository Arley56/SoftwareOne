@php
    $level = $level ?? 0;
    $roleName = $comment->user->roles->name ?? 'Usuario';
    $replyCount = $comment->replies->count();
    $initial = strtoupper(substr($comment->user->name ?? 'U', 0, 1));
@endphp

<div class="session-comment-card {{ $level > 0 ? 'ms-md-5' : '' }}">
    <div class="card-body">
        <div class="d-flex align-items-start gap-3">
            <div class="session-comment-avatar">{{ $initial }}</div>

            <div class="flex-grow-1">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="fw-semibold">{{ $comment->user->name ?? 'Usuario' }}</span>
                        <span class="badge {{ $roleName === 'Monitor' ? 'text-bg-info text-dark' : 'text-bg-warning text-dark' }}">
                            {{ $roleName }}
                        </span>
                        <small class="text-secondary">{{ $comment->created_at?->format('d/m/Y H:i') }}</small>
                    </div>

                    @if ($replyCount > 0)
                        <button
                            type="button"
                            class="btn btn-outline-secondary btn-sm rounded-pill px-3"
                            data-bs-toggle="collapse"
                            data-bs-target="#commentReplies{{ $comment->id }}"
                            aria-expanded="false"
                            aria-controls="commentReplies{{ $comment->id }}"
                        >
                            Respuestas ({{ $replyCount }})
                        </button>
                    @endif
                </div>

                <div class="session-comment-message mt-3">
                    {{ $comment->message }}
                </div>

                @if ($canComment && $level === 0)
                    <div class="mt-3 d-flex justify-content-end">
                        <button
                            type="button"
                            class="btn btn-outline-light btn-sm rounded-pill px-3"
                            data-bs-toggle="collapse"
                            data-bs-target="#replyForm{{ $comment->id }}"
                            aria-expanded="false"
                            aria-controls="replyForm{{ $comment->id }}"
                        >
                            Responder
                        </button>
                    </div>

                    <div class="collapse mt-3" id="replyForm{{ $comment->id }}">
                        <div class="session-comment-composer">
                            <form
                                action="{{ route('monitor-sessions.comments.store', $comment->monitor_session_id) }}"
                                method="POST"
                                class="js-session-comment-form"
                            >
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                                <div class="mb-3">
                                    <textarea
                                        name="message"
                                        class="form-control"
                                        rows="2"
                                        maxlength="2000"
                                        placeholder="Escribe tu respuesta..."
                                        required
                                    ></textarea>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-info text-dark btn-sm rounded-pill px-4">Responder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                @if ($replyCount > 0)
                    <div class="collapse mt-3" id="commentReplies{{ $comment->id }}">
                        <div class="session-comment-replies">
                            @foreach ($comment->replies as $reply)
                                @include('session_comments._comment', [
                                    'comment' => $reply,
                                    'canComment' => $canComment,
                                    'level' => $level + 1,
                                ])
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
