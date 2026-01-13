<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventRegistration;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',                  // Event Name
        'description',           // Description
        'organizer',             // Organizer
        'contact_person',        // Contact Person (optional)
        'contact_no',            // Contact Number (optional)
        'type',                  // Event Type
        'venue',                 // Venue
        'date',                  // Event Date
        'time',                  // Event Time
        'mode',                  // Mode: physical/online/hybrid
        'registration_close',    // Registration close date
        'max_participants',      // Max participants (optional)
        'fee',                   // Fee
        'remarks',               // Remarks/notes (optional)
        'posters',               // JSON array for 1–4 images
        'user_id',
    ];

    // Cast posters to array automatically
    protected $casts = [
        'posters' => 'array',
        'date' => 'date',
        'registration_close' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
}


