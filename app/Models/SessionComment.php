<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'monitor_session_id',
        'user_id',
        'parent_id',
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

    public function parent()
    {
        return $this->belongsTo(SessionComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(SessionComment::class, 'parent_id')->oldest();
    }
}
