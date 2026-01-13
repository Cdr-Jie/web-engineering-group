@extends('layouts.app')

@section('content')
<div style="margin-top: 50px;">
<h2 style="text-align:center; margin-bottom:20px;">All Events</h2>

@if($events->isEmpty())
    <p style="text-align:center;">No events found.</p>
@else
    <div class="dashboard-grid">
        @foreach($events as $event)
            <div class="dashboard-card">
                {{-- Poster --}}
                @if(!empty($event->posters) && count($event->posters) > 0)
                    <img src="{{ asset('storage/' . $event->posters[0]) }}" 
                         alt="{{ $event->name }} Poster" 
                         style="width:100%; max-height:200px; object-fit:cover; margin-bottom:10px;">
                @endif

                <h3>{{ $event->name }}</h3>
                <p>{{ $event->date->format('d M Y') }} | {{ $event->time }}</p>
                <p>{{ $event->venue }}</p>
                <p>Type: {{ $event->type }} | Mode: {{ $event->mode }}</p>

                {{-- Only show edit/delete if user owns the event --}}
                @if($event->user_id === Auth::id())
                    <a href="{{ route('events.edit', $event) }}" class="btn">Edit</a>

                    <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn danger">Delete</button>
                    </form>
                @endif


                 @php
                $registered = $event->registrations()->where('user_id', Auth::id())->exists();
                @endphp

                @if($registered)
                    <form action="{{ route('events.unregister', $event->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background: #e74c3c;" onclick="return confirm('Are you sure you want to unregister from this event?')">Unregister</button>
                    </form>
                @else
                    <button class="btn register-btn" onclick="openRegisterModal({{ $event->id }}, '{{ $event->name }}', '{{ $event->fee }}')">Register</button>
                @endif
            </div>
            
        @endforeach
    </div>

   


    {{-- Pagination --}}
    <div style="margin-top:20px; text-align:center;">
        {{ $events->links() }}
    </div>


    <!-- Registration Modal -->
<div id="registerModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
    background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
    <div style="background:#fff; padding:20px; border-radius:10px; max-width:500px; width:90%;">
        <h3 id="modalEventName"></h3>
        <form method="POST" action="{{ route('events.register') }}">
            @csrf
            <input type="hidden" name="event_id" id="modalEventId">

            <label>Full Name:<br>
                <input type="text" name="name" value="{{ Auth::user()->name }}" required>
            </label><br><br>

            <label>Email:<br>
                <input type="email" name="email" value="{{ Auth::user()->email }}" required>
            </label><br><br>

            <label>Payment Amount (RM):<br>
                <input type="number" name="payment" id="modalPayment" min="0" step="0.01" required>
            </label><br><br>

            <button type="submit" class="btn">Confirm Registration</button>
            <button type="button" class="btn danger" onclick="closeRegisterModal()">Cancel</button>
        </form>
    </div>
</div>


<script>
function openRegisterModal(eventId, eventName, fee) {
    document.getElementById('registerModal').style.display = 'flex';
    document.getElementById('modalEventName').innerText = 'Register for: ' + eventName;
    document.getElementById('modalEventId').value = eventId;
    document.getElementById('modalPayment').value = fee === 'Free' ? 0 : fee;
}

function closeRegisterModal() {
    document.getElementById('registerModal').style.display = 'none';
}
</script>


@endif
@endsection
