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
        'user_id',
    ];

    // Hide password in JSON responses
    protected $hidden = [
        'password',
    ];

    /**
     * Get the user associated with this admin.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
