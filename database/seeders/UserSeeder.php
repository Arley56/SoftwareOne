<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Juan Monitor', 'email' => 'juan@unal.edu.co', 'role_id' => 2, 'password' => Hash::make('password')],
            ['name' => 'Maria Monitora', 'email' => 'maria@unal.edu.co', 'role_id' => 2, 'password' => Hash::make('password')],
            ['name' => 'Pedro Monitor', 'email' => 'pedro@unal.edu.co', 'role_id' => 2, 'password' => Hash::make('password')],
            ['name' => 'Ana Monitora', 'email' => 'ana@unal.edu.co', 'role_id' => 2, 'password' => Hash::make('password')],
            ['name' => 'Luis Monitor', 'email' => 'luis@unal.edu.co', 'role_id' => 2, 'password' => Hash::make('password')],
            ['name' => 'Carlos Estudiante', 'email' => 'carlos@gmail.com', 'role_id' => 3, 'password' => Hash::make('password')],
            ['name' => 'Lucía Estudiante', 'email' => 'lucia@gmail.com', 'role_id' => 3, 'password' => Hash::make('password')],
            ['name' => 'Elena Estudiante', 'email' => 'elena@gmail.com', 'role_id' => 3, 'password' => Hash::make('password')],
            ['name' => 'Jose Estudiante', 'email' => 'jose@gmail.com', 'role_id' => 3, 'password' => Hash::make('password')],
            ['name' => 'Rosa Estudiante', 'email' => 'rosa@gmail.com', 'role_id' => 3, 'password' => Hash::make('password')],
        ];
        foreach ($users as $item) {
            User::create($item);
        }
    }
}