<section class="space-y-6">
    <header>
        <h2 class="h4 mb-2">
            {{ __('Eliminar cuenta') }}
        </h2>

        <p class="text-secondary mb-0">
            {{ __('Cuando elimines tu cuenta, todos sus recursos y datos se borrarán de forma permanente. Antes de hacerlo, descarga cualquier información que desees conservar.') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
        {{ __('Eliminar cuenta') }}
    </button>

    <div class="modal fade {{ $errors->userDeletion->isNotEmpty() ? 'show' : '' }}" id="confirm-user-deletion"
        tabindex="-1" aria-hidden="{{ $errors->userDeletion->isNotEmpty() ? 'false' : 'true' }}"
        @if($errors->userDeletion->isNotEmpty()) style="display:block;" @endif>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                        </button>
                    </div>

                    <div class="modal-body">

                        <p class="text-secondary">
                            {{ __('Una vez eliminada, tu cuenta y todos sus datos se borrarán de forma permanente. Ingresa tu contraseña para confirmar la eliminación.') }}
                        </p>

                        <div class="mb-3">

                            <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />

                            <x-text-input id="password" name="password" type="password" class="mt-1"
                                placeholder="{{ __('Contraseña') }}" />

                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Cancelar') }}
                        </button>

                        <x-danger-button>
                            {{ __('Eliminar cuenta') }}
                        </x-danger-button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    @if ($errors->userDeletion->isNotEmpty())
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const modalElement = document.getElementById('confirm-user-deletion');

                    if (modalElement && window.bootstrap) {
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    }
                });
            </script>
        @endpush
    @endif

</section>