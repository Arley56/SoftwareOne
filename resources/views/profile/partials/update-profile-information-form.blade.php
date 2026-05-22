<section>
    <header>
        <h2 class="h4 mb-2">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-secondary mb-0">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-secondary mb-2">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link p-0 align-baseline text-decoration-underline">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success py-2 mb-0">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        @if (isset($monitor) && $monitor)
            <div class="pt-4 border-top mt-4">
                <div class="mb-3">
                    <h3 class="h5 mb-2">
                        {{ __('Monitor Information') }}
                    </h3>
                    <p class="text-secondary mb-0">
                        {{ __('Update the subject and description visible to students.') }}
                    </p>
                </div>

                <div class="mb-3">
                    <x-input-label for="subject_id" :value="__('Subject')" />
                    <select id="subject_id" name="subject_id" class="form-select mt-1" required>
                        <option value="">{{ __('Select a subject') }}</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected((string) old('subject_id', $monitor->subject_id) === (string) $subject->id)>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('subject_id')" />
                </div>

                <div class="mb-3">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" rows="4" maxlength="1000" class="form-control mt-1">{{ old('description', $monitor->description) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
            </div>
        @endif

        <div class="d-flex align-items-center gap-3 mt-4 flex-wrap">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <span
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-muted"
                >{{ __('Saved.') }}</span>
            @endif
        </div>
    </form>
</section>
