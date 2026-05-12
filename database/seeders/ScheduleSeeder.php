<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Monitor;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos los IDs de los monitores reales creados en el MonitorSeeder
        $monitorIds = Monitor::pluck('id')->toArray();
        
        if (empty($monitorIds)) {
            $this->command->error('No hay monitores registrados. Corre primero MonitorSeeder.');
            return;
        }

        $schedules = [];
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        $horas = ['08:00:00', '10:00:00', '14:00:00', '16:00:00'];

        // Generamos 30 registros repartidos entre los monitores existentes
        for ($i = 0; $i < 30; $i++) {
            $schedules[] = [
                // Usamos el operador módulo (%) para rotar entre los 5 monitores
                'monitor_id' => $monitorIds[$i % count($monitorIds)],
                'dia_semana' => $dias[$i % 5],
                'hora_inicio' => $horas[$i % 4],
                'hora_fin'    => date('H:i:s', strtotime($horas[$i % 4] . ' + 2 hours')),
                'modalidad'   => ($i % 2 == 0) ? 'Presencial' : 'Virtual',
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        foreach ($schedules as $item) {
            Schedule::create($item);
        }

        $this->command->info('Se han creado 30 horarios repartidos entre los monitores.');
    }
}