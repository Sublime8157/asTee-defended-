<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

// make sure to use authenticatableTrait so the model can register to the auth() has a default authentication for logging in 
class adminLogin extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

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
