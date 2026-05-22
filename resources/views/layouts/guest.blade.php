<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light text-dark">
        <div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
            <div class="card shadow-sm border-0 w-100" style="max-width: 560px;">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <a href="/" class="text-decoration-none text-dark fw-bold fs-4">
                            Sistema de Monitorias
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
