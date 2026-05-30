<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        @include('layouts._dark-theme-styles')
        @stack('styles')
    </head>
    <body class="app-theme">
        <div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
        <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="card shadow-sm border w-100" style="max-width: 560px;">
                <div class="card-body p-4 p-md-5">
                    <x-flash-alerts />

                    <div class="text-center mb-4">
                        <a href="/" class="text-decoration-none text-light fw-bold fs-4">
                            Sistema de Monitorias
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        @include('layouts._flash-alerts-script')
        @stack('scripts')
    </body>
</html>
