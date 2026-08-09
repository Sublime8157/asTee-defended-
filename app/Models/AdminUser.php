<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Replaces the adminLogin model, which hand-assembled the Authenticatable
 * contract on a plain Model and carried `age`, `mname` and a misspelt `profie`
 * column that nothing read.
 */
class AdminUser extends Authenticatable implements CanResetPasswordContract
{
    use CanResetPassword, HasFactory, Notifiable;

    protected $table = 'admin_users';

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'username',
        'password',
        'role',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
