<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Admin</title>
    @vite('resources/css/admin.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @include('includes.sidebar')

    <div class="admin-container">
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Notifications</h1>
                @if($notifications->total() > 0)
                    <button class="btn" onclick="markAllAsRead()" style="background: linear-gradient(135deg, #00d9a3 0%, #1aa573 100%); color: white; padding: 12px 24px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 217, 163, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 217, 163, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 217, 163, 0.3)'">
                        Mark all as read
                    </button>
                @endif
            </div>

            @if($notifications->total() > 0)
                <div style="background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    @foreach($notifications as $notification)
                        <div class="notification-item" data-notification-id="{{ $notification->id }}" style="padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: start; background-color: {{ $notification->isUnread() ? '#f0fdfb' : '#fff' }}; transition: background-color 0.3s ease;">
                            <div style="flex: 1; cursor: pointer;" onclick="markAsRead({{ $notification->id }})">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                    <!-- Icon based on notification type -->
                                    @if($notification->type === 'user_registered')
                                        <i class="fas fa-user-check" style="color: #00d9a3; font-size: 18px;"></i>
                                    @elseif($notification->type === 'event_created')
                                        <i class="fas fa-calendar-plus" style="color: #3b82f6; font-size: 18px;"></i>
                                    @elseif($notification->type === 'registration_confirmed')
                                        <i class="fas fa-check-circle" style="color: #10b981; font-size: 18px;"></i>
                                    @elseif($notification->type === 'new_participant')
                                        <i class="fas fa-user-plus" style="color: #f59e0b; font-size: 18px;"></i>
                                    @else
                                        <i class="fas fa-bell" style="color: #666; font-size: 18px;"></i>
                                    @endif

                                    <div>
                                        <strong style="color: #333; font-size: 16px;">{{ $notification->title }}</strong>
                                        @if($notification->isUnread())
                                            <span style="background-color: #00d9a3; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px; margin-left: 10px;">New</span>
                                        @endif
                                    </div>
                                </div>
                                <p style="margin: 8px 0; color: #555; font-size: 14px; line-height: 1.5;">{{ $notification->message }}</p>
                                <small style="color: #999;">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <button class="delete-btn" onclick="deleteNotification({{ $notification->id }})" style="background-color: #ef4444; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; margin-left: 15px; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='#ef4444'">
                                ✕
                            </button>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div style="display: flex; justify-content: center; margin-top: 30px;">
                    {{ $notifications->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 60px 40px; background-color: #f9fafb; border-radius: 8px;">
                    <i class="fas fa-bell" style="font-size: 48px; color: #d1d5db; margin-bottom: 20px; display: block;"></i>
                    <p style="color: #999; font-size: 16px;">No notifications at the moment</p>
                </div>
            @endif
        </main>
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
                    const badge = item.querySelector('[style*="background-color: #00d9a3"]');
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
                    if (item) {
                        item.style.opacity = '0';
                        item.style.transition = 'opacity 0.3s ease';
                        setTimeout(() => item.remove(), 300);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>
