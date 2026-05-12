<?php

namespace Database\Seeders;

use App\Models\Monitor;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class MonitorSeeder extends Seeder
{
    public function run(): void
    {
        // Lista de correos de los monitores creados en UserSeeder
        $emails = [
            'juan@unal.edu.co',
            'maria@unal.edu.co',
            'pedro@unal.edu.co',
            'ana@unal.edu.co',
            'luis@unal.edu.co'
        ];

        // Obtenemos algunas materias para vincularlas (asumiendo que ya corriste SubjectSeeder)
        $subjects = Subject::take(5)->get();

        foreach ($emails as $index => $email) {
            $user = User::where('email', $email)->first();
            
            // Verificamos que el usuario y la materia existan para evitar errores
            if ($user && isset($subjects[$index])) {
                Monitor::create([
                    'user_id'    => $user->id,
                    'subject_id' => $subjects[$index]->id,
                    'semestre'   => '8',
                ]);
            }
        }
        
        $this->command->info('Se han vinculado 5 monitores exitosamente.');
    }
}