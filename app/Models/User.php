<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'category',
        'events',
        'profile_image',
    ];

    // Hide password in JSON responses
    protected $hidden = [
        'password',
    ];

    // Cast events to array automatically
    protected $casts = [
        'events' => 'array',
    ];

    public function organizedEvents()
    {
        return $this->hasMany(Event::class);
    }

    public function eventRegistrations()
    {
        return $this->hasMany(\App\Models\EventRegistration::class);
    }
}