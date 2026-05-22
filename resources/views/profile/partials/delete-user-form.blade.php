<section class="space-y-6">
    <header>
        <h2 class="h4 mb-2">
            {{ __('Delete Account') }}
        </h2>

        <p class="text-secondary mb-0">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
        {{ __('Delete Account') }}
    </button>

    <div class="modal fade {{ $errors->userDeletion->isNotEmpty() ? 'show' : '' }}" id="confirm-user-deletion" tabindex="-1" aria-hidden="{{ $errors->userDeletion->isNotEmpty() ? 'false' : 'true' }}" @if($errors->userDeletion->isNotEmpty()) style="display:block;" @endif>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Are you sure you want to delete your account?') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-secondary">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <div class="mb-3">
                            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                class="mt-1"
                                placeholder="{{ __('Password') }}"
                            />
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>
                        <x-danger-button>
                            {{ __('Delete Account') }}
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
</section>
