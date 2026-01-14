@extends('layouts.app')

@section('content')
<h2>📅 My Events</h2>

{{-- Search Bar --}}
<div style="max-width: 600px; margin: 0 auto 30px; display: flex; gap: 10px;">
    <form method="GET" action="{{ route('events.my') }}" style="flex: 1; display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="Search your events by name, description, or venue..." 
               value="{{ $search ?? '' }}" 
               style="flex: 1; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: border-color 0.3s ease;" 
               onfocus="this.style.borderColor='#00d9a3'" 
               onblur="this.style.borderColor='#e0e0e0'">
        <button type="submit" style="padding: 12px 24px; background: linear-gradient(135deg, #00d9a3 0%, #1aa573 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;" 
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 217, 163, 0.3)'" 
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <i class="fas fa-search"></i> Search
        </button>
        @if($search ?? null)
            <a href="{{ route('events.my') }}" style="padding: 12px 24px; background: #f0f0f0; color: #333; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s ease;" 
               onmouseover="this.style.background='#e0e0e0'" 
               onmouseout="this.style.background='#f0f0f0'">
                <i class="fas fa-times"></i> Clear
            </a>
        @endif
    </form>
</div>

@if($search ?? null)
    <p style="text-align:center; color: #666; margin-bottom: 20px;">
        Search results for: <strong>{{ $search }}</strong>
    </p>
@endif

@if($events->isEmpty())
    <p>You haven’t created any events yet.</p>
@else
    <div class="dashboard-grid">
        @foreach($events as $event)

            <div class="dashboard-card">
                <h3>{{ $event->name }}</h3>

                {{-- Event poster preview --}}
                @if(!empty($event->posters) && count($event->posters) > 0)
                    <img src="{{ asset('storage/' . $event->posters[0]) }}" 
                        alt="{{ $event->name }} Poster" 
                        class="event-poster">
                @endif

                <p>{{ $event->date->format('d M Y') }} | {{ $event->time }}</p>
                <p>{{ $event->venue }}</p>


                <a href="{{ route('events.participants', $event) }}" class="btn">View Details</a>
                <a href="{{ route('events.edit', $event) }}" class="btn">Edit</a>

                <form action="{{ route('events.destroy', $event) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn danger">Delete</button>
                </form>
            </div>
        @endforeach
    </div>

    <div class="create-event-button-bottom">
        <a href="{{ route('events.create') }}" class="btn create-event-wide">Create New Event</a>
    </div>
@endif
@endsection
