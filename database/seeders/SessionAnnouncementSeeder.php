<?php

namespace Database\Seeders;

use App\Models\MonitorSession;
use App\Models\SessionAnnouncement;
use Illuminate\Database\Seeder;

class SessionAnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sessions = MonitorSession::with([
            'schedule.monitor.user',
            'schedule.monitor.subject',
        ])->orderBy('id')->get();

        if ($sessions->isEmpty()) {
            $this->command->error('No hay monitorias para generar anuncios.');

            return;
        }

        $created = 0;

        foreach ($sessions as $session) {
            $monitorUser = $session->schedule?->monitor?->user;

            if (! $monitorUser) {
                continue;
            }

            $subjectName = $session->schedule?->monitor?->subject?->name ?? 'la monitoria';

            $session->sessionAnnouncements()->delete();

            SessionAnnouncement::create([
                'monitor_session_id' => $session->id,
                'user_id' => $monitorUser->id,
                'title' => 'Aviso oficial monitoria',
                'message' => 'Revisa material y trae tus dudas para la sesión.',
            ]);

            $created++;
        }

        $this->command->info("Se generaron {$created} anuncios de prueba, uno por cada monitoria existente.");
    }
}