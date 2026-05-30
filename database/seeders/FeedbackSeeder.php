<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\MonitorSession;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comentarios = [
            'Excelente monitoría, muy clara.',
            'El monitor domina mucho el tema.',
            'Me gustaría que fuera más práctico.',
            'Puntual y muy amable.',
            'Resolvió todas mis dudas con paciencia.'
        ];

        $sessions = MonitorSession::with(['sessionEnrollments' => function ($query) {
            $query->where('status', 'activa')->orderBy('user_id');
        }])->orderBy('id')->get();

        if ($sessions->isEmpty()) {
            $this->command->error('No hay monitorías para generar feedback.');
            return;
        }

        foreach ($sessions as $sessionIndex => $session) {
            $enrollment = $session->sessionEnrollments->first();

            if (! $enrollment) {
                continue;
            }

            Feedback::create([
                'monitor_session_id' => $session->id,
                'user_id' => $enrollment->user_id,
                'calificacion' => rand(4, 5),
                'comentario' => $comentarios[$sessionIndex % count($comentarios)],
                'created_at' => now(),
            ]);
        }

        $this->command->info('Se generaron feedbacks de prueba usando inscripciones activas.');
    }
}