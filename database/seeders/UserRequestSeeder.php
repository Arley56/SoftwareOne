<?php

namespace Database\Seeders;

use App\Models\UserRequest;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class UserRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requests = [];
        $motivos = [
            'Tengo dudas con el último taller.',
            'No entiendo el concepto de recursividad.',
            'Necesito refuerzo para el parcial del viernes.',
            '¿Podrían explicar de nuevo la normalización?',
            'Solicito apoyo con ejercicios de integrales.'
        ];

        for ($i = 1; $i <= 30; $i++) {
            $requests[] = [
                'user_id'     => rand(6, 10), // IDs de estudiantes
                'subject_id'  => rand(1, 10), // IDs de materias
                'descripcion' => $motivos[array_rand($motivos)] . " (Petición #$i)",
                'created_at'  => now(),
            ];
}
        foreach ($requests as $item) {
            UserRequest::create($item);
        }

    }
}