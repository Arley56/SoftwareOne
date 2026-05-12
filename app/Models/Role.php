<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function users()
        {
            // Le indicamos a Laravel el nombre exacto de tu llave foránea
            return $this->hasMany(User::class, 'role_id');
        }
}

