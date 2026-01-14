@extends('layouts.app')

@section('content')
@vite('resources/css/participants.css')

<div class="participants-container">
    <div class="participants-wrapper">
        <div class="participants-header">
            <a href="{{ route('events.my') }}" class="btn back-button">← Back to My Events</a>
        </div>
        {{-- Event Header --}}
        <h1 style="margin-bottom: 10px;">{{ $event->name }}</h1>
        <p style="color: #666; font-size: 0.95em; margin-bottom: 20px;">
            <strong>Date:</strong> {{ $event->date->format('d M Y') }} | <strong>Time:</strong> {{ $event->time }} | <strong>Venue:</strong> {{ $event->venue }}
        </p>

        {{-- Participants Summary --}}
        <div class="summary-box">
            <h3>Participants Summary</h3>
            <div class="summary-grid">
                <div class="summary-item">
                    <p>Total Registered</p>
                    <p>{{ $registrations->total() }}</p>
                </div>
                @if($event->max_participants)
                    <div class="summary-item">
                        <p>Capacity</p>
                        <p class="capacity">{{ $registrations->total() }} / {{ $event->max_participants }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Participants Table --}}
        <h2 style="margin-bottom: 20px;">Registered Participants</h2>

        @if($registrations->isEmpty())
            <p class="empty-state">No participants yet.</p>
        @else
            <div class="participants-table-container">
                <table class="participants-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Category</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Registered Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $index => $registration)
                            <tr>
                                <td>{{ $registrations->firstItem() + $index }}</td>
                                <td style="color: #333; font-weight: 500;">{{ $registration->user->name }}</td>
                                <td style="color: #666;">{{ $registration->user->email }}</td>
                                <td style="color: #666;">{{ ucfirst($registration->user->category) }}</td>
                                <td style="color: #00d9a3; font-weight: 600;">
                                    @if($registration->payment == 0 || $registration->payment == 'Free')
                                        Free
                                    @else
                                        RM {{ number_format($registration->payment, 2) }}
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge {{ strtolower($registration->status) }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>
                                <td style="color: #666;">{{ $registration->created_at->format('d M Y') }}</td>
                                <td>
                                    <button type="button" 
                                        class="attendance-btn {{ $registration->status === 'attended' ? 'marked' : 'unmarked' }}"
                                        data-registration-id="{{ $registration->id }}"
                                        data-event-id="{{ $event->id }}"
                                        data-status="{{ $registration->status }}">
                                        @if($registration->status === 'attended')
                                            ✓ Present
                                        @else
                                            Mark Present
                                        @endif
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">No participants found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="pagination-wrapper">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const attendanceBtns = document.querySelectorAll('.attendance-btn');

    attendanceBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const registrationId = this.getAttribute('data-registration-id');
            const eventId = this.getAttribute('data-event-id');
            const currentStatus = this.getAttribute('data-status');

            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = 'Updating...';
            this.disabled = true;

            // Make AJAX request
            fetch(`/events/${eventId}/registrations/${registrationId}/attendance`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'attended') {
                    // Mark as attended
                    this.innerHTML = '✓ Present';
                    this.classList.remove('unmarked');
                    this.classList.add('marked');
                    this.setAttribute('data-status', 'attended');
                    
                    // Update status badge
                    const statusBadge = this.closest('tr').querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.innerHTML = 'Attended';
                        statusBadge.classList.remove('registered', 'cancelled');
                        statusBadge.classList.add('attended');
                    }
                } else {
                    // Mark as registered
                    this.innerHTML = 'Mark Present';
                    this.classList.remove('marked');
                    this.classList.add('unmarked');
                    this.setAttribute('data-status', 'registered');
                    
                    // Update status badge
                    const statusBadge = this.closest('tr').querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.innerHTML = 'Registered';
                        statusBadge.classList.remove('attended', 'cancelled');
                        statusBadge.classList.add('registered');
                    }
                }
                this.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                this.innerHTML = originalText;
                this.disabled = false;
                alert('Failed to update attendance. Please try again.');
            });
        });
    });
});
</script>
@endsection
