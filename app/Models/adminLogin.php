<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;


class adminLogin extends Model implements  AuthenticatableContract,
AuthorizableContract,
CanResetPasswordContract
{
    use HasFactory, AuthenticatableTrait, Authorizable, CanResetPassword, MustVerifyEmail, Notifiable;

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

    public function sendPasswordResetNotification($token)
        {
            $this->notify(new ResetPassword($token));
        }


}