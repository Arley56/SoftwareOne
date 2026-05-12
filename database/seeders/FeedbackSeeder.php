<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\MonitorSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feedbacks = [];
        $comentarios = [
            'Excelente monitoría, muy clara.',
            'El monitor domina mucho el tema.',
            'Me gustaría que fuera más práctico.',
            'Puntual y muy amable.',
            'Resolvió todas mis dudas con paciencia.'
        ];

        for ($i = 1; $i <= 30; $i++) {
            $feedbacks[] = [
                'monitor_session_id' => $i,           // Una calificación por cada sesión
                'user_id'            => rand(6, 10),  // Calificado por un estudiante aleatorio
                'calificacion'       => rand(4, 5),   // Calificaciones positivas para el ejemplo
                'comentario'         => $comentarios[array_rand($comentarios)],
                'created_at'         => now(),
            ];
        }
        foreach ($feedbacks as $item) {
            Feedback::create($item);
        }
  
    }
}