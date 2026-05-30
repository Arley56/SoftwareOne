<div class="d-flex gap-2 flex-wrap align-items-center">
    <span class="badge text-bg-success">Inscrito</span>
    @if (!empty($enrollmentId))
        <a href="{{ route('session-enrollments.show', $enrollmentId) }}" class="btn btn-outline-info btn-sm">Ver inscripción</a>
    @endif
</div>