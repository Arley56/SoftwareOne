<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\MonitorSession;
use App\Models\User;
use App\Models\SessionEnrollment;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enrollments = SessionEnrollment::with('monitorSession')
            ->where('status', 'activa')
            ->orderBy('monitor_session_id')
            ->get();

        if ($enrollments->isEmpty()) {
            $students = User::where('role_id', 3)->orderBy('id')->get();
            $sessions = MonitorSession::orderBy('id')->get();

            if ($students->isEmpty() || $sessions->isEmpty()) {
                $this->command->error('No hay datos suficientes para generar asistencias.');
                return;
            }

            foreach ($sessions as $index => $session) {
                Attendance::create([
                    'monitor_session_id' => $session->id,
                    'user_id' => $students[$index % $students->count()]->id,
                    'asistio' => ($index % 3 === 0) ? 'No' : 'Sí',
                ]);
            }

            $this->command->info('Se generaron asistencias de prueba con estudiantes rotativos.');
            return;
        }

        foreach ($enrollments as $index => $enrollment) {
            Attendance::create([
                'monitor_session_id' => $enrollment->monitor_session_id,
                'user_id' => $enrollment->user_id,
                'asistio' => ($index % 4 === 0) ? 'No' : 'Sí',
            ]);
        }

        $this->command->info('Se generaron asistencias de prueba basadas en inscripciones activas.');
    }
}