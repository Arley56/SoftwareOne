<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Monitor;
use App\Models\UserRequest;

class Subject extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name','code','credits','description'];


    public function monitors()
    {
        return $this->hasMany(Monitor::class);
    }

    public function userRequests()
    {
        return $this->hasMany(UserRequest::class);
    }
}
