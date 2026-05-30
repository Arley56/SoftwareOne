<?php

namespace Database\Seeders;

use App\Models\MonitorSession;
use App\Models\SessionEnrollment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SessionEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::where('role_id', 3)->orderBy('id')->get();
        $sessions = MonitorSession::orderBy('id')->get();

        if ($students->isEmpty() || $sessions->isEmpty()) {
            $this->command->error('No hay estudiantes o monitorías para crear inscripciones.');
            return;
        }

        $studentCount = $students->count();

        foreach ($sessions as $sessionIndex => $session) {
            $enrollmentsPerSession = 4;

            for ($offset = 0; $offset < $enrollmentsPerSession; $offset++) {
                $student = $students[($sessionIndex + $offset) % $studentCount];

                SessionEnrollment::firstOrCreate(
                    [
                        'user_id' => $student->id,
                        'monitor_session_id' => $session->id,
                    ],
                    [
                        'status' => 'activa',
                        'enrolled_at' => Carbon::parse($session->fecha)->setTime(8 + $offset, 0),
                    ]
                );
            }
        }

        $this->command->info('Se han creado inscripciones de prueba para múltiples estudiantes por monitoría.');
    }
}
