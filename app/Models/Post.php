<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;


    public function user(){
        $this->belongsTo(User::class);
    }
    public function comment(){
        $this->hasMany(Comment::class);
    }
}