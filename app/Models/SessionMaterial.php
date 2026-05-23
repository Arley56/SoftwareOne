<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'monitor_session_id',
        'uploaded_by_user_id',
        'original_name',
        'file_path',
        'mime_type',
        'size',
    ];

    public function monitorSession()
    {
        return $this->belongsTo(MonitorSession::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }
}