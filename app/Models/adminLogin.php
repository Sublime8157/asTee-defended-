<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\adminLogin as Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Notifications\Notifiable;

// make sure to use authenticatableTrait so the model can register to the auth() has a default authentication for logging in 
class adminLogin extends  Authenticatable
{
    use HasFactory, AuthenticatableTrait, Notifiable;

    protected $table = 'admin_login';
    protected $fillable =  [
        'profie',
        'fname',
        'mname',
        'lname',
        'age',
        'email',
        'username',
        'email_verified_at',
        'password'
    ];
}
