<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Approvals - Admin</title>
    @vite('resources/css/admin.css')
    @vite('resources/css/approvals.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('includes.sidebar')

    <div class="admin-container">
        <main class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Event Approvals</h1>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <a href="/admin/notifications" style="font-size: 20px; color: #333; text-decoration: none;" title="Notifications">
                        <i class="fas fa-bell"></i>
                    </a>
                    <form action="/admin/logout" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; padding: 12px 24px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 38, 38, 0.3)'">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search events by name, organizer..." value="{{ $search ?? '' }}">
                <button onclick="searchEvents()"><i class="fas fa-search"></i> Search</button>
            </div>

            <!-- Approval Tabs -->
            <div class="approval-tabs">
                <a href="{{ route('admin.approvals', ['status' => 'pending']) }}" class="approval-tab {{ $status === 'pending' ? 'active' : '' }}">
                    <i class="fas fa-hourglass-half"></i> Pending
                </a>
                <a href="{{ route('admin.approvals', ['status' => 'approved']) }}" class="approval-tab {{ $status === 'approved' ? 'active' : '' }}">
                    <i class="fas fa-check-circle"></i> Approved
                </a>
                <a href="{{ route('admin.approvals', ['status' => 'rejected']) }}" class="approval-tab {{ $status === 'rejected' ? 'active' : '' }}">
                    <i class="fas fa-times-circle"></i> Rejected
                </a>
                <a href="{{ route('admin.approvals', ['status' => 'all']) }}" class="approval-tab {{ $status === 'all' ? 'active' : '' }}">
                    <i class="fas fa-list"></i> All Events
                </a>
            </div>

            <!-- Events List -->
            <div class="approval-container">
                @if($events->count() > 0)
                    @foreach($events as $event)
                        <div class="event-card">
                            <div class="event-header">
                                <div class="event-title">
                                    <h3>{{ $event->name }}</h3>
                                    <span class="status-badge status-{{ $event->approval_status }}">
                                        {{ ucfirst($event->approval_status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="event-info">
                                <div class="info-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ $event->date->format('M d, Y') }} at {{ $event->time }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $event->venue }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-tag"></i>
                                    <span>{{ $event->type }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $event->max_participants ?? 'Unlimited' }} max participants</span>
                                </div>
                            </div>

                            <div class="event-description">
                                {{ Str::limit($event->description, 200) }}
                            </div>

                            <div class="creator-info">
                                <strong>Organizer:</strong> {{ $event->organizer }}<br>
                                <strong>Created by:</strong> {{ $event->user->name }} ({{ $event->user->email }})<br>
                                <strong>Created:</strong> {{ $event->created_at->format('M d, Y H:i') }}
                            </div>

                            @if($event->approval_status === 'rejected' && $event->rejection_reason)
                                <div class="rejection-note">
                                    <strong>Rejection Reason:</strong> {{ $event->rejection_reason }}
                                </div>
                            @endif

                            @if($event->approval_status === 'approved' && $event->approvedBy)
                                <div style="background: #d4edda; border-left: 4px solid #28a745; padding: 12px; border-radius: 4px; margin: 15px 0; font-size: 13px; color: #155724;">
                                    <strong>Approved by:</strong> {{ $event->approvedBy->name }}<br>
                                    <strong>Approved on:</strong> {{ $event->approval_date->format('M d, Y H:i') }}
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            @if($event->approval_status === 'pending')
                                <div class="approval-actions" style="justify-content: flex-end;">
                                    <form action="{{ route('admin.approve.event', $event) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="approval-btn-approve">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <button class="approval-btn-reject" onclick="openRejectModal({{ $event->id }})">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div style="margin-top: 30px;">
                        {{ $events->links() }}
                    </div>
                @else
                    <div class="no-events">
                        <i class="fas fa-inbox"></i>
                        <h3>No events found</h3>
                        <p>There are no events to display for this status.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Rejection Modal -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">Reject Event</div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <label style="display: block; margin-bottom: 10px; color: #333; font-weight: 600;">Rejection Reason:</label>
                    <textarea name="rejection_reason" required placeholder="Please provide a reason for rejecting this event..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeRejectModal()">Cancel</button>
                    <button type="submit" class="btn-modal-submit">Reject Event</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(eventId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/admin/approvals/${eventId}/reject`;
            modal.classList.add('show');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.remove('show');
            document.getElementById('rejectForm').reset();
        }

        function searchEvents() {
            const searchTerm = document.getElementById('searchInput').value;
            const status = new URLSearchParams(window.location.search).get('status') || 'pending';
            window.location.href = `{{ route('admin.approvals') }}?status=${status}&search=${encodeURIComponent(searchTerm)}`;
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target === modal) {
                closeRejectModal();
            }
        }

        // Allow Enter key to search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchEvents();
            }
        });
    </script>
</body>
</html>
