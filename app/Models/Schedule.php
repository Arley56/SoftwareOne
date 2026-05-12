<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Monitor;
use App\Models\MonitorSession;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['monitor_id','dia_semana','hora_inicio','hora_fin','modalidad'];
    public function monitor()
    {
        return $this->belongsTo(Monitor::class, 'monitor_id');
    }

    public function monitorSessions()
    {
        return $this->hasMany(MonitorSession::class);
    }
}
