<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
        ['name' => 'Cálculo I', 'code' => 'MAT011', 'credits' => 4],
        ['name' => 'Programación I', 'code' => 'PRG012', 'credits' => 3],
        ['name' => 'Física Mecánica', 'code' => 'FIS011', 'credits' => 4],
        ['name' => 'Bases de Datos', 'code' => 'DBD001', 'credits' => 3],
        ['name' => 'Estructuras de Datos', 'code' => 'EST012', 'credits' => 4],
        ['name' => 'Álgebra Lineal', 'code' => 'MAT023', 'credits' => 4],
        ['name' => 'Ingeniería de Software', 'code' => 'SOFT013', 'credits' => 3],
        ['name' => 'Redes de Datos', 'code' => 'RED014', 'credits' => 3],
        ['name' => 'Sistemas Operativos', 'code' => 'SIO001', 'credits' => 4],
        ['name' => 'Ética Profesional', 'code' => 'HUM013', 'credits' => 2],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}