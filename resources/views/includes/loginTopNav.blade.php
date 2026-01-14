<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('dashboard') }}" class="brand">Event Nexus</a>
        <div class="menu-icon" id="menu-icon">
            <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-links" id="nav-links">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.index') ? 'active' : '' }}">Events</a>
            </li>
            <li>
                <a href="{{ route('notifications.index') }}" class="notification-link" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge" id="notificationBadge" style="display: none; background-color: #ff4444; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; margin-left: 5px;">0</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </form>
            </li>

        </ul>
    </div>
</nav>

<script>
    const menuIcon = document.getElementById('menu-icon');
    const navLinks = document.getElementById('nav-links');

    if (menuIcon) {
        menuIcon.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });

        // Close menu when a link is clicked
        const links = navLinks.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.classList.remove('active');
            });
        });
    }

    // Load unread notification count
    function loadNotificationCount() {
        fetch('{{ route("notifications.unreadCount") }}', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notificationBadge');
            if (data.unread_count > 0) {
                badge.textContent = data.unread_count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(error => console.error('Error loading notification count:', error));
    }

    // Load notification count on page load
    document.addEventListener('DOMContentLoaded', loadNotificationCount);

    // Refresh notification count every 30 seconds
    setInterval(loadNotificationCount, 30000);
</script>
