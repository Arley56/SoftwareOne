<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Monitor;
use App\Models\UserRequest;
use App\Models\Attendance;
use App\Models\Feedback;
use App\Models\Role;
use App\Models\SessionEnrollment;
#[Fillable(['name', 'email', 'password', 'estado', 'photo', 'role_id', 'phone'])]
#[Hidden(['password', 'remember_token'])]


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function monitors()
    {
        return $this->hasMany(Monitor::class);
    }

    public function monitorProfile()
    {
        return $this->hasOne(Monitor::class);
    }


    public function userRequests()
    {
        return $this->hasMany(UserRequest::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function sessionEnrollments()
    {
        return $this->hasMany(SessionEnrollment::class);
    }


    public function roles()
        {
            // Le indicamos de nuevo a Laravel el nombre de tu llave foránea
            return $this->belongsTo(Role::class, 'role_id');
        }
}
