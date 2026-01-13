<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    @vite('resources/css/style.css')
</head>
<body>

@include('includes.loginTopNav')

<section class="dashboard-section-content">

    <h2>Welcome, {{ Auth::user()->name }} 👋</h2>
    <p>Manage your profile and campus events here</p>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h3>👤 Profile</h3>
            <div class="details">
                @if(Auth::user()->profile_image)
                    <div class="profile-image-container">
                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" class="profile-image">
                    </div>
                @else
                    <div class="profile-image-placeholder">
                        <p>No Profile Image</p>
                    </div>
                @endif
                <p>Name: {{ Auth::user()->name }}</p>
                <p>Email: {{ Auth::user()->email }}</p>
                <p>Phone: {{ Auth::user()->phone }}</p>
                <p>Category: {{ Auth::user()->category }}</p>
                <a href="{{ route('profile.edit') }}" class="btn">Edit Profile</a>
            </div>
        </div>

        <div class="dashboard-card">
            <h3>📅 My Events</h3>
            <p>Create, edit, or delete events you organize.</p>
            <p>
                <strong>{{ Auth::user()->organizedEvents()->count() }}</strong> event(s)
            </p>
            
            @if(Auth::user()->organizedEvents()->count() > 0)
                <div class="events-images-container">
                    @foreach(Auth::user()->organizedEvents()->take(3)->get() as $event)
                        <div class="event-image-item">
                            @if($event->posters && count($event->posters) > 0)
                                <img src="{{ asset('storage/' . $event->posters[0]) }}" alt="{{ $event->name }}" class="event-poster">
                            @else
                                <div class="event-image-placeholder">
                                    <p>{{ $event->name }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
            
            <a href="{{ route('events.create') }}" class="btn">Create New Event</a>
            <a href="{{ route('events.my') }}" class="btn">My Events</a>
        </div>

        <div class="dashboard-card">
            <h3>📝 Event Registrations</h3>
            <p>View events you have registered for.</p>
            
            @php
                $registeredEvents = Auth::user()->eventRegistrations()->with('event')->take(3)->get() ?? collect();
            @endphp
            
            @if($registeredEvents->count() > 0)
                <div class="events-images-container">
                    @foreach($registeredEvents as $registration)
                        @if($registration->event)
                            <div class="event-image-item">
                                @if($registration->event->posters && count($registration->event->posters) > 0)
                                    <img src="{{ asset('storage/' . $registration->event->posters[0]) }}" alt="{{ $registration->event->name }}" class="event-poster">
                                @else
                                    <div class="event-image-placeholder">
                                        <p>{{ $registration->event->name }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
            
            <a href="{{ route('registrations.my') }}" class="btn">My Registrations</a>
        </div>

    </div>

</section>

</body>
</html>
