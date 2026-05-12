<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\MonitorSession;
use Illuminate\Database\Eloquent\SoftDeletes;


class Attendance extends Model
{
    use SoftDeletes;
    use HasFactory;
        protected $fillable = [
        'user_id',
        'monitor_session_id',
        'asistio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function MonitorSession()
    {
        return $this->belongsTo(MonitorSession::class, 'monitor_session_id');
    }
}
