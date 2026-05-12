<?php

namespace Database\Seeders;

use App\Models\MonitorSession;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Monitor;
use Illuminate\Database\Seeder;

class MonitorSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sessions = [];
        for ($i = 1; $i <= 30; $i++) {
            $sessions[] = [
                'schedule_id' => $i,
                'fecha' => '2026-04-' . str_pad(($i % 30) + 1, 2, '0', STR_PAD_LEFT)
            ];
        }
        foreach ($sessions as $item) {
            MonitorSession::create($item);
        }
    }
}