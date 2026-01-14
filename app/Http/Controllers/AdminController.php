<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // Show admin login form
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Handle admin login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login with admin guard (if using separate guard)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle admin logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    // Show promote user to admin form
    public function showPromoteForm()
    {
        $users = User::where('category', '!=', 'admin')->get();
        return view('admin.promote', compact('users'));
    }

    // Handle promote user to admin
    public function promoteUserToAdmin(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,admin,moderator',
        ]);

        $user = User::find($data['user_id']);

        // Create admin with user's password (they can reset it later)
        Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $user->password, // Use existing user password
            'phone' => $data['phone'],
            'role' => $data['role'],
        ]);

        return redirect('/admin')->with('success', 'User promoted to admin successfully');
    }

    // Show admin dashboard
    public function index()
    {
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalRegistrations = EventRegistration::count();
        $adminCount = Admin::count();

        return view('admin.dashboard', compact('totalUsers', 'totalEvents', 'totalRegistrations', 'adminCount'));
    }

    // Show all admins
    public function list()
    {
        $admins = Admin::latest()->paginate(10);
        return view('admin.list', compact('admins'));
    }

    // Show create admin form
    public function create()
    {
        return view('admin.create');
    }

    // Store new admin
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,admin,moderator',
        ]);

        $data['password'] = bcrypt($data['password']);
        Admin::create($data);

        return redirect('/admin')->with('success', 'Admin created successfully');
    }

    // Show edit admin form
    public function edit(Admin $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    // Update admin
    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,admin,moderator',
        ]);

        $admin->update($data);

        return redirect('/admin')->with('success', 'Admin updated successfully');
    }

    // Delete admin
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect('/admin')->with('success', 'Admin deleted successfully');
    }

    // Show all users
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    // Show create user form
    public function createUser()
    {
        return view('admin.user-create');
    }

    // Store new user
    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'category' => 'required|in:student,staff,public',
        ]);

        $data['password'] = bcrypt($data['password']);
        User::create($data);

        return redirect('/admin/users')->with('success', 'User created successfully');
    }

    // Show edit user form
    public function editUser(User $user)
    {
        return view('admin.user-edit', compact('user'));
    }

    // Update user
    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'category' => 'required|in:student,staff,public',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Only include password if provided
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return redirect('/admin/users')->with('success', 'User updated successfully');
    }

    // Delete user
    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect('/admin/users')->with('success', 'User deleted successfully');
    }

    // Show all events
    public function events()
    {
        $events = Event::withCount('registrations')->latest()->paginate(10);
        return view('admin.events', compact('events'));
    }

    // Show create event form
    public function createEvent()
    {
        return view('admin.event-create');
    }

    // Store new event
    public function storeEvent(Request $request)
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

        return redirect()->route('admin.events')
            ->with('success', 'Event created successfully!');
    }

    // Show edit event form
    public function editEvent(Event $event)
    {
        return view('admin.event-edit', compact('event'));
    }

    // Update event
    public function updateEvent(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organizer' => 'nullable|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'venue' => 'nullable|string|max:255',
            'mode' => 'required|in:Physical,Online,Hybrid',
            'registration_close' => 'required|date|before_or_equal:date',
            'max_participants' => 'nullable|integer|min:1',
            'fee' => 'nullable|numeric|min:0',
        ]);

        $event->update($data);

        return redirect('/admin/events')->with('success', 'Event updated successfully');
    }

    // Delete event
    public function destroyEvent(Event $event)
    {
        $event->delete();
        return redirect('/admin/events')->with('success', 'Event deleted successfully');
    }

    // Show all registrations
    public function registrations(Request $request)
    {
        $eventFilter = $request->query('event_id');
        
        $query = EventRegistration::latest();
        
        if ($eventFilter) {
            $query->where('event_id', $eventFilter);
        }
        
        $registrations = $query->paginate(10);
        $events = Event::all();
        $users = User::all();
        
        return view('admin.registrations', compact('registrations', 'events', 'eventFilter', 'users'));
    }

    // Show create registration form
    public function createRegistration()
    {
        $users = User::all();
        $events = Event::all();
        return view('admin.registration-create', compact('users', 'events'));
    }

    // Store new registration
    public function storeRegistration(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => [
                'required',
                'exists:events,id',
                Rule::unique('event_registrations')->where(function($query) use ($request) {
                    return $query->where('user_id', $request->user_id);
                })->where('event_id', $request->event_id),
            ],
        ], [
            'event_id.unique' => 'This user is already registered for this event.',
        ]);

        EventRegistration::create($data);

        return redirect('/admin/registrations')->with('success', 'Registration created successfully');
    }

      // Delete registration
    public function destroyRegistration(EventRegistration $registration)
    {
        $registration->delete();
        return redirect('/admin/registrations')->with('success', 'Registration deleted successfully');
    }
}
