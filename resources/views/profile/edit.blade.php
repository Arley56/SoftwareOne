<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            {{ __('Mi perfil') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center gy-4">
        <div class="col-12 col-xl-10">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 p-lg-5">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 p-lg-5">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-lg-5">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
