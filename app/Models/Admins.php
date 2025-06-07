<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admins extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';

    protected $fillable = ['name','email', 'password','status'];

    protected $hidden = ['password'];

}
