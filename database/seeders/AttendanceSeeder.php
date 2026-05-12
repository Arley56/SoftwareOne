<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\MonitorSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attendances = [];
        for ($i = 1; $i <= 30; $i++) {
            $attendances[] = [
                'monitor_session_id' => $i,
                'user_id' => rand(6, 10), // IDs de los estudiantes creados en UserSeeder
                'asistio' => ($i % 3 == 0) ? 'No' : 'Sí'
            ];
        }
        foreach ($attendances as $item) {
            Attendance::create($item);
        }
    }
}