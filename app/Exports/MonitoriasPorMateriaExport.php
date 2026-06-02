<?php

namespace App\Exports;

use App\Models\MonitorSession;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MonitoriasPorMateriaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return MonitorSession::query()
            ->join('schedules', 'monitor_sessions.schedule_id', '=', 'schedules.id')
            ->join('monitors', 'schedules.monitor_id', '=', 'monitors.id')
            ->join('subjects', 'monitors.subject_id', '=', 'subjects.id')
            ->select(
                'subjects.name as materia',
                DB::raw('COUNT(monitor_sessions.id) as cantidad_monitorias')
            )
            ->whereMonth('monitor_sessions.fecha', now()->month)
            ->whereYear('monitor_sessions.fecha', now()->year)
            ->groupBy('subjects.id', 'subjects.name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Materia',
            'Cantidad de Monitorías'
        ];
    }
}