<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Schedule;
use App\Models\Feedback;
use App\Models\Attendance;
use App\Models\SessionEnrollment;
use App\Models\SessionMaterial;
use App\Models\SessionComment;

class MonitorSession extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['schedule_id','fecha'];
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function sessionEnrollments()
    {
        return $this->hasMany(SessionEnrollment::class);
    }

    public function sessionMaterials()
    {
        return $this->hasMany(SessionMaterial::class);
    }

    public function sessionComments()
    {
        return $this->hasMany(SessionComment::class)
            ->whereNull('parent_id')
            ->latest();
    }

}
