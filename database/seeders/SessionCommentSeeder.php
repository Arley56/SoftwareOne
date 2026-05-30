<?php

namespace Database\Seeders;

use App\Models\MonitorSession;
use App\Models\SessionComment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SessionCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sessions = MonitorSession::with([
            'schedule.monitor.user',
            'sessionEnrollments.user',
        ])->orderBy('id')->get();

        if ($sessions->isEmpty()) {
            $this->command->error('No hay monitorias para generar comentarios.');

            return;
        }

        $studentMessages = [
            'Profe, ya revise el material y me quedo una duda con el ejercicio final.',
            'Estoy avanzando con el taller, pero me trabe en un paso.',
            'Gracias por la explicacion, ya me quedo mas claro el tema.',
            'Voy a subir el ejercicio apenas termine de ajustarlo.',
            'Podemos repasar la parte de la demostracion una vez mas?',
        ];

        $monitorMessages = [
            'Claro, lo revisamos paso a paso en la siguiente parte.',
            'Recuerden enfocar el ejercicio en la idea principal, no solo en el resultado.',
            'Si tienen dudas, traigan su desarrollo y lo corregimos juntos.',
            'Voy a dejar una pista adicional para que avancen con mas seguridad.',
            'Perfecto, sigan con ese ritmo y luego validamos la respuesta final.',
        ];

        $replyMessages = [
            'Gracias, monitor. Ya lo estoy revisando.',
            'Listo, me sirvio mucho la aclaracion.',
            'Quedo atento a la siguiente indicacion.',
            'Ya entendi el paso que me faltaba.',
            'Perfecto, muchas gracias por la ayuda.',
        ];

        $createComment = function (array $attributes): SessionComment {
            return SessionComment::unguarded(function () use ($attributes) {
                return SessionComment::create($attributes);
            });
        };

        $seededThreads = 0;

        foreach ($sessions->take(10) as $sessionIndex => $session) {
            $monitorUser = $session->schedule?->monitor?->user;
            $activeEnrollments = $session->sessionEnrollments
                ->where('status', 'activa')
                ->values();

            if (! $monitorUser || $activeEnrollments->isEmpty()) {
                continue;
            }

            $students = $activeEnrollments->pluck('user')->filter()->values();

            if ($students->isEmpty()) {
                continue;
            }

            $baseTime = Carbon::parse($session->fecha)->setTime(15 + ($sessionIndex % 3), 0);

            $studentOne = $students->first();
            $studentTwo = $students->get(1) ?? $studentOne;
            $studentThree = $students->get(2) ?? $studentOne;

            $threadOne = $createComment([
                'monitor_session_id' => $session->id,
                'user_id' => $studentOne->id,
                'parent_id' => null,
                'message' => $studentMessages[$sessionIndex % count($studentMessages)],
                'created_at' => $baseTime->copy(),
                'updated_at' => $baseTime->copy(),
            ]);

            $createComment([
                'monitor_session_id' => $session->id,
                'user_id' => $monitorUser->id,
                'parent_id' => $threadOne->id,
                'message' => $monitorMessages[$sessionIndex % count($monitorMessages)],
                'created_at' => $baseTime->copy()->addMinutes(12),
                'updated_at' => $baseTime->copy()->addMinutes(12),
            ]);

            $threadTwo = $createComment([
                'monitor_session_id' => $session->id,
                'user_id' => $monitorUser->id,
                'parent_id' => null,
                'message' => $monitorMessages[($sessionIndex + 1) % count($monitorMessages)],
                'created_at' => $baseTime->copy()->addHour(),
                'updated_at' => $baseTime->copy()->addHour(),
            ]);

            $createComment([
                'monitor_session_id' => $session->id,
                'user_id' => $studentTwo->id,
                'parent_id' => $threadTwo->id,
                'message' => $replyMessages[$sessionIndex % count($replyMessages)],
                'created_at' => $baseTime->copy()->addHour()->addMinutes(8),
                'updated_at' => $baseTime->copy()->addHour()->addMinutes(8),
            ]);

            if ($students->count() >= 3 && $sessionIndex % 2 === 0) {
                $threadThree = $createComment([
                    'monitor_session_id' => $session->id,
                    'user_id' => $studentThree->id,
                    'parent_id' => null,
                    'message' => $studentMessages[($sessionIndex + 2) % count($studentMessages)],
                    'created_at' => $baseTime->copy()->addHours(2),
                    'updated_at' => $baseTime->copy()->addHours(2),
                ]);

                $createComment([
                    'monitor_session_id' => $session->id,
                    'user_id' => $monitorUser->id,
                    'parent_id' => $threadThree->id,
                    'message' => $replyMessages[($sessionIndex + 1) % count($replyMessages)],
                    'created_at' => $baseTime->copy()->addHours(2)->addMinutes(10),
                    'updated_at' => $baseTime->copy()->addHours(2)->addMinutes(10),
                ]);
            }

            $seededThreads += 2 + (($students->count() >= 3 && $sessionIndex % 2 === 0) ? 1 : 0);
        }

        $this->command->info("Se generaron {$seededThreads} hilos de comentarios reales en monitorias con inscritos activos.");
    }
}
