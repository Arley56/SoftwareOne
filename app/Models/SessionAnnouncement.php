<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'monitor_session_id',
        'user_id',
        'title',
        'message',
    ];

    public function monitorSession()
    {
        return $this->belongsTo(MonitorSession::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}