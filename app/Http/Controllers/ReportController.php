<?php

namespace App\Http\Controllers;

use App\Exports\MonitoriasPorMateriaExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function export()
    {
        return Excel::download(
            new MonitoriasPorMateriaExport(),
            'reporte_monitorias.xlsx'
        );
    }
}