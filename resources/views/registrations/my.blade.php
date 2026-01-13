@extends('layouts.app')

@section('content')
<h2>🎫 My Registrations</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($registrations->isEmpty())
    <p>You haven't registered for any events yet.</p>
    <a href="{{ route('events.index') }}" class="btn">Browse Events</a>
@else
    <div class="dashboard-grid">
        @foreach($registrations as $registration)
            <div class="dashboard-card">
                <h3>{{ $registration->event->name }}</h3>

                {{-- Event poster preview --}}
                @if(!empty($registration->event->posters) && count($registration->event->posters) > 0)
                    <img src="{{ asset('storage/' . $registration->event->posters[0]) }}" 
                        alt="{{ $registration->event->name }} Poster" 
                        style="width:100%; max-height:200px; object-fit:cover; margin-bottom:10px;">
                @endif

                <p><strong>Date:</strong> {{ $registration->event->date->format('d M Y') }}</p>
                <p><strong>Time:</strong> {{ $registration->event->time }}</p>
                <p><strong>Venue:</strong> {{ $registration->event->venue }}</p>
                <p><strong>Mode:</strong> {{ $registration->event->mode }}</p>
                <p><strong>Type:</strong> {{ $registration->event->type }}</p>
                <p><strong>Fee Paid:</strong> RM {{ number_format($registration->payment, 2) }}</p>
                <p><strong>Registered on:</strong> {{ $registration->created_at->format('d M Y') }}</p>

                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <a href="{{ route('events.show', $registration->event) }}" class="btn">View Details</a>
                    
                    <form action="{{ route('events.unregister', $registration->event) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to unregister from this event?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn danger">Unregister</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
