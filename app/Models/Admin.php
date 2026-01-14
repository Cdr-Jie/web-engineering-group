<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
    ];

    // Hide password in JSON responses
    protected $hidden = [
        'password',
    ];
}
