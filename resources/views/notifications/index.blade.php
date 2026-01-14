@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2>Notifications</h2>
        @if($notifications->total() > 0)
            <button class="btn" onclick="markAllAsRead()" style="background-color: #4CAF50; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                Mark all as read
            </button>
        @endif
    </div>

    @if($notifications->total() > 0)
        <div style="background-color: #f5f5f5; border-radius: 8px; overflow: hidden;">
            @foreach($notifications as $notification)
                <div class="notification-item" data-notification-id="{{ $notification->id }}" style="padding: 15px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: start; background-color: {{ $notification->isUnread() ? '#e3f2fd' : '#fff' }};">
                    <div style="flex: 1; cursor: pointer;" onclick="markAsRead({{ $notification->id }})">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                            <strong style="color: #333;">{{ $notification->title }}</strong>
                            @if($notification->isUnread())
                                <span style="background-color: #2196F3; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">New</span>
                            @endif
                        </div>
                        <p style="margin: 0; color: #666; font-size: 14px;">{{ $notification->message }}</p>
                        <small style="color: #999;">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    <button class="delete-btn" onclick="deleteNotification({{ $notification->id }})" style="background-color: #f44336; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-left: 10px;">
                        ×
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 20px;">
            {{ $notifications->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 40px; background-color: #f5f5f5; border-radius: 8px;">
            <i class="fas fa-bell" style="font-size: 48px; color: #ccc; margin-bottom: 15px; display: block;"></i>
            <p style="color: #999; font-size: 16px;">No notifications at the moment</p>
        </div>
    @endif
</div>

<script>
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            const item = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (item) {
                item.style.backgroundColor = '#fff';
                const badge = item.querySelector('[style*="background-color: #2196F3"]');
                if (badge) badge.remove();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function markAllAsRead() {
        fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }

    function deleteNotification(notificationId) {
        if (confirm('Delete this notification?')) {
            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                const item = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (item) item.remove();
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>
@endsection
