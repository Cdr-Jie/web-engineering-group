<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Show all events (e.g. event listing)
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Event::latest();
        
        // Filter by visibility: public events always shown, private events only to staff/student
        if (!Auth::check()) {
            // Non-authenticated users: only see public events
            $query->where('visibility', 'public');
        } else {
            // Authenticated users
            $user = Auth::user();
            if ($user->category === 'public') {
                // Public category users: only see public events
                $query->where('visibility', 'public');
            } else {
                // Staff and student users: see both public and private events
                // (no visibility filter needed)
            }
        }
        
        if($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('venue', 'like', '%' . $search . '%');
        }
        
        $events = $query->paginate(12);
        return view('events.index', compact('events', 'search'));
    }

    // Show create event form
    public function create()
    {
        return view('events.create');
    }

    // Show event details
    public function show(Event $event)
    {
        // Check visibility: private events only for staff/student, not public category
        if ($event->visibility === 'private') {
            if (!Auth::check()) {
                return redirect()->route('events.index')->with('error', 'This event is only available to university members.');
            }
            
            $user = Auth::user();
            if ($user->category === 'public') {
                return redirect()->route('events.index')->with('error', 'This event is only available to staff and students.');
            }
        }
        
        return view('events.show', compact('event'));
    }

    // Store new event
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'organizer' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:20',
            'type' => 'required|in:Workshop,Seminar,Competition,Festival,Sport,Course',
            'venue' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'mode' => 'required|in:Physical,Online,Hybrid',
            'registration_close' => 'required|date|before_or_equal:date',
            'max_participants' => 'nullable|integer|min:1',
            'fee' => 'required|string',
            'remarks' => 'nullable|string',
            'visibility' => 'required|in:public,private',
            'posters' => 'required|array|min:1|max:4',
            'posters.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle poster uploads
        $posterPaths = [];

        if ($request->hasFile('posters')) {
            foreach ($request->file('posters') as $file) {
                $posterPaths[] = $file->store('events', 'public');
            }
        }


        // Save event
        Event::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'organizer' => $data['organizer'],
            'contact_person' => $data['contact_person'] ?? null,
            'contact_no' => $data['contact_no'] ?? null,
            'type' => $data['type'],
            'venue' => $data['venue'],
            'date' => $data['date'],
            'time' => $data['time'],
            'mode' => $data['mode'],
            'registration_close' => $data['registration_close'],
            'max_participants' => $data['max_participants'] ?? null,
            'fee' => $data['fee'],
            'remarks' => $data['remarks'] ?? null,
            'posters' => $posterPaths,
            'user_id' => Auth::id(), // ⭐ IMPORTANT
        ]);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully!');
    }

    // Show edit form
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    // Update event
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'organizer' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:20',
            'type' => 'required|in:Workshop,Seminar,Competition,Festival,Sport,Course',
            'venue' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'mode' => 'required|in:Physical,Online,Hybrid',
            'registration_close' => 'required|date|before_or_equal:date',
            'max_participants' => 'nullable|integer|min:1',
            'fee' => 'required|string',
            'remarks' => 'nullable|string',
            'posters' => 'nullable|array|max:4',
            'posters.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'deleted_poster_indices' => 'nullable|string',
        ]);

        // Handle deleted posters
        $currentPosters = $event->posters ?? [];
        if (!empty($data['deleted_poster_indices'])) {
            $deletedIndices = array_map('intval', explode(',', $data['deleted_poster_indices']));
            
            // Delete files from storage
            foreach ($deletedIndices as $index) {
                if (isset($currentPosters[$index])) {
                    Storage::disk('public')->delete($currentPosters[$index]);
                    unset($currentPosters[$index]);
                }
            }
            
            // Re-index the array
            $currentPosters = array_values($currentPosters);
        }

        // Handle new poster uploads (if any)
        if ($request->hasFile('posters')) {
            $posterPaths = [];

            foreach ($request->file('posters') as $file) {
                $posterPaths[] = $file->store('events', 'public');
            }

            // Merge remaining current posters with new ones
            $data['posters'] = array_merge($currentPosters, $posterPaths);
        } else {
            // Keep remaining current posters
            $data['posters'] = $currentPosters;
        }

        $event->update($data);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully!');
    }

    // Delete event
    public function destroy(Event $event)
    {
        foreach ($event->posters ?? [] as $poster) {
            Storage::disk('public')->delete($poster);
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }

    public function myEvents(Request $request)
    {
        $search = $request->input('search');
        $query = Auth::user()->organizedEvents()->latest();
        
        if($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('venue', 'like', '%' . $search . '%');
        }
        
        $events = $query->get();
        return view('events.myEvents', compact('events', 'search'));
    }

    public function register(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'payment' => 'required|numeric|min:0',
        ]);

        // Get event and check visibility
        $event = Event::find($data['event_id']);
        
        if ($event->visibility === 'private') {
            $user = Auth::user();
            if ($user->category === 'public') {
                return redirect()->back()->with('error', 'This event is only available to staff and students.');
            }
        }

        // Prevent duplicate registration
        $alreadyRegistered = EventRegistration::where('event_id', $data['event_id'])
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->back()->with('error', 'You are already registered for this event.');
        }

        // Save registration
        EventRegistration::create([
            'event_id' => $data['event_id'],
            'user_id' => Auth::id(),
            'name' => $data['name'],
            'email' => $data['email'],
            'payment' => $data['payment'],
        ]);

        return redirect()->back()->with('success', 'Registered successfully!');
    }

    public function unregister($eventId)
    {
        $registration = EventRegistration::where('event_id', $eventId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$registration) {
            return redirect()->back()->with('error', 'You are not registered for this event.');
        }

        $registration->delete();

        return redirect()->back()->with('success', 'Successfully unregistered from the event.');
    }

    public function myRegistrations()
    {
        $registrations = EventRegistration::where('user_id', Auth::id())
            ->with('event')
            ->latest()
            ->get();
        
        return view('registrations.my', compact('registrations'));
    }

    // View event participants
    public function participants(Event $event)
    {
        // Check if user is the event organizer
        if ($event->user_id !== Auth::id()) {
            return redirect()->route('events.index')->with('error', 'You do not have permission to view this event\'s participants.');
        }

        // Get all registrations for this event
        $registrations = $event->registrations()->latest()->paginate(perPage: 10);
        
        return view('events.participants', compact('event', 'registrations'));
    }

    // Mark participant attendance
    public function markAttendance(Event $event, EventRegistration $registration)
    {
        // Check if user is the event organizer
        if ($event->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Verify the registration belongs to this event
        if ($registration->event_id !== $event->id) {
            return response()->json(['error' => 'Registration does not belong to this event'], 422);
        }

        // Toggle attendance status
        $newStatus = $registration->status === 'attended' ? 'registered' : 'attended';
        $registration->update(['status' => $newStatus]);

        return response()->json(['status' => $newStatus, 'message' => 'Attendance updated successfully']);
    }
}
