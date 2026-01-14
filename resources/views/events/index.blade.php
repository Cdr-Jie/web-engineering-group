@extends('layouts.app')

@section('content')
<div style="margin-top: 50px;">
    <h2 style="text-align:center; margin-bottom:30px;">All Events</h2>

    {{-- Search Bar --}}
    <div style="max-width: 600px; margin: 0 auto 30px; display: flex; gap: 10px;">
        <form method="GET" action="{{ route('events.index') }}" style="flex: 1; display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Search events by name, description, or venue..." 
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
                <a href="{{ route('events.index') }}" style="padding: 12px 24px; background: #f0f0f0; color: #333; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s ease;" 
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
    <p style="text-align:center;">No events found.</p>
@else
    <div class="dashboard-grid">
        @foreach($events as $event)
            <div class="dashboard-card" style="cursor: pointer; transition: all 0.3s ease;" onclick="window.location.href='{{ route('events.show', $event) }}';" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
                {{-- Poster --}}
                @if(!empty($event->posters) && count($event->posters) > 0)
                    <img src="{{ asset('storage/' . $event->posters[0]) }}" 
                         alt="{{ $event->name }} Poster" 
                         style="width:100%; max-height:200px; object-fit:cover; margin-bottom:10px; border-radius: 8px;">
                @endif

                <h3 style="color: #00d9a3; cursor: pointer;">{{ $event->name }}</h3>
                <p>{{ $event->date->format('d M Y') }} | {{ $event->time }}</p>
                <p>{{ $event->venue }}</p>
                <p>Type: {{ $event->type }} | Mode: {{ $event->mode }}</p>

                {{-- Show badge if user owns the event --}}
                @if($event->user_id === Auth::id())
                    <div style="display: inline-block; background: linear-gradient(135deg, #00d9a3 0%, #1aa573 100%); color: white; padding: 10px 20px; border-radius: 20px; font-size: 12px; font-weight: 600; margin: 20px 0;">
                        <i class="fas fa-crown"></i> Your Event
                    </div>
                @endif

                <div>
                @php
                $registered = $event->registrations()->where('user_id', Auth::id())->exists();
                @endphp

                @if($registered)
                    <form action="{{ route('events.unregister', $event->id) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background: #e74c3c;" onclick="return confirm('Are you sure you want to unregister from this event?')">Unregister</button>
                    </form>
                @else
                    <button class="btn register-btn" onclick="event.stopPropagation(); openRegisterModal({{ $event->id }}, '{{ $event->name }}', '{{ $event->fee }}')">Register</button>
                @endif
                </div>
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
