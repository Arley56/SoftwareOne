<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;

class Monitor extends Model
{
    use HasFactory;
    protected $fillable = [
    'user_id',
    'subject_id',
    'semestre',
    'description'
];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        // El segundo parámetro es la llave foránea en tu tabla 'monitors'
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    
}
