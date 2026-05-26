<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Historial de monitorías
    </title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #000;
        }

        h1 {
            margin-bottom: 5px;
        }

        .subtitle {
            margin-bottom: 30px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .text-center {
            text-align: center;
        }

    </style>

</head>

<body>

    <h1>
        Historial de monitorías
    </h1>

    <p class="subtitle">
        Estudiante:
        <strong>{{ $user->name }}</strong>
    </p>

    <table>

        <thead>

            <tr>

                <th>
                    Fecha
                </th>

                <th>
                    Asignatura
                </th>

                <th>
                    Monitor
                </th>

                <th>
                    Estado
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($enrollments as $enrollment)

                <tr>

                    <td>
                        {{ $enrollment->monitorSession->fecha ?? 'Sin fecha' }}
                    </td>

                    <td>
                        {{ $enrollment->monitorSession->schedule->monitor->subject->name ?? 'Sin asignatura' }}
                    </td>

                    <td>
                        {{ $enrollment->monitorSession->schedule->monitor->user->name ?? 'Sin monitor' }}
                    </td>

                    <td>
                        {{ ucfirst($enrollment->status) }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center">
                        No hay monitorías registradas.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    <script>

        window.onload = function () {

            window.print();

        }

    </script>

</body>

</html>