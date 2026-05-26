<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionExercise extends Model
{
    protected $fillable = [
        'session_enrollment_id',
        'uploaded_by_user_id',
        'original_name',
        'file_path',
        'mime_type',
        'size',
    ];

    public function sessionEnrollment()
    {
        return $this->belongsTo(SessionEnrollment::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }
}