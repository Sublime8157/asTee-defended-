<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminLogin extends Model
{

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
    use HasFactory;
}
