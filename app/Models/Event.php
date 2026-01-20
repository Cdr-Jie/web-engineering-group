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
        'visibility',            // Visibility: public or private (university only)
        'approval_status',       // Approval status: pending, approved, rejected
        'approved_by',           // Admin ID who approved
        'approval_date',         // Date of approval/rejection
        'rejection_reason',      // Reason for rejection
        'user_id',
    ];

    // Cast posters to array automatically
    protected $casts = [
        'posters' => 'array',
        'date' => 'date',
        'registration_close' => 'date',
        'approval_date' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}


