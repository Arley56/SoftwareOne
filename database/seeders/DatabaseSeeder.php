<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Nivel 0 (Tablas Maestras)
            RoleSeeder::class,
            SubjectSeeder::class,
            
            // Nivel 1 (Dependen de Roles)
            UserSeeder::class,
            
            // Nivel 2 (Intersecciones/Relaciones)
            UserRequestSeeder::class,
            MonitorSeeder::class,
            
            // Nivel 3 (Dependen de Monitor)
            ScheduleSeeder::class,
            
            // Nivel 4 (Dependen de Schedule)
            MonitorSessionSeeder::class,
            SessionEnrollmentSeeder::class,
            SessionCommentSeeder::class,
            SessionAnnouncementSeeder::class,
            
            // Nivel 5 (Dependen de Session)
            AttendanceSeeder::class,
            FeedbackSeeder::class,
        ]);
    }
}
