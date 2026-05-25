<section>
    <header>
        <h2 class="h4 mb-2">
            Actualizar contraseña
        </h2>

        <p class="text-secondary mb-0">
            Asegura tu cuenta utilizando una contraseña segura y difícil de adivinar.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        {{-- Contraseña actual --}}
        <div class="mb-3">

            <x-input-label for="update_password_current_password" value="Contraseña actual" />

            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1"
                autocomplete="current-password" />

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />

        </div>

        {{-- Nueva contraseña --}}
        <div class="mb-3">

            <x-input-label for="update_password_password" value="Nueva contraseña" />

            <x-text-input id="update_password_password" name="password" type="password" class="mt-1"
                autocomplete="new-password" />

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />

        </div>

        {{-- Confirmar contraseña --}}
        <div class="mb-3">

            <x-input-label for="update_password_password_confirmation" value="Confirmar contraseña" />

            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1" autocomplete="new-password" />

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />

        </div>

        {{-- Botón guardar --}}
        <div class="d-flex align-items-center gap-3 flex-wrap">

            <x-primary-button>
                Guardar
            </x-primary-button>

            @if (session('status') === 'password-updated')

                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-muted">
                    Contraseña actualizada correctamente.
                </span>

            @endif

        </div>

    </form>
</section>