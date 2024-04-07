<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'profile',
        'fname',
        'mname',
        'lname',
        'age',
        'email',
        'userStatus',
        'username',
        'password',
        'created_at'
    ];
    
    use HasFactory;
}
