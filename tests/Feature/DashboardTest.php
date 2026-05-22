<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_sees_admin_dashboard(): void
    {
        $adminRole = Role::query()->firstOrCreate(['name' => 'Administrador']);
        $user = User::factory()->create(['role_id' => $adminRole->id]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertViewIs('dashboard1');
    }

    public function test_non_administrator_sees_default_dashboard(): void
    {
        $studentRole = Role::query()->firstOrCreate(['name' => 'Estudiante']);
        $user = User::factory()->create(['role_id' => $studentRole->id]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertViewIs('dashboard');
    }
}