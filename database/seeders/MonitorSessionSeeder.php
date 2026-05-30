<?php

namespace Database\Seeders;

use App\Models\MonitorSession;
use App\Models\Schedule;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class MonitorSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = Schedule::orderBy('id')->get();

        if ($schedules->isEmpty()) {
            $this->command->error('No hay horarios disponibles. Corre primero ScheduleSeeder.');
            return;
        }

        $dateBuckets = [
            Carbon::today()->toDateString(),
            Carbon::tomorrow()->toDateString(),
            Carbon::today()->addWeek()->toDateString(),
        ];

        foreach ($schedules as $index => $schedule) {
            MonitorSession::create([
                'schedule_id' => $schedule->id,
                'fecha' => $dateBuckets[$index % count($dateBuckets)],
            ]);
        }

        $this->command->info('Se han creado monitorías de prueba para hoy, mañana y la próxima semana.');
    }
}