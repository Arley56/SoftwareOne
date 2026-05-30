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
        $monitors = User::where('role_id', 2)->orderBy('id')->get();
        $subjects = Subject::orderBy('id')->get();

        if ($monitors->isEmpty() || $subjects->isEmpty()) {
            $this->command->error('No hay monitores o materias registradas.');
            return;
        }
        
        foreach ($monitors as $index => $user) {
            $subject = $subjects[$index % $subjects->count()];

            Monitor::create([
                'user_id' => $user->id,
                'subject_id' => $subject->id,
                'semestre' => (string) (6 + ($index % 5)),
                'description' => 'Monitoría de prueba para ' . $subject->name,
            ]);
        }

        $this->command->info('Se han vinculado monitores de prueba exitosamente.');
    }
}