<!-- Sidebar Toggle Button -->
<button class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar Overlay (for mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside class="sidebar">
    <h2><i class="fas fa-lock"></i> ADMIN</h2>
    <ul>
        <li><a href="/admin" class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i>Dashboard</a></li>
        <li><a href="/admin/admins" class="{{ Route::is('admin.list') || Route::is('admin.create') || Route::is('admin.edit') ? 'active' : '' }}"><i class="fas fa-users-cog"></i>Manage Admins</a></li>
        <li><a href="/admin/users" class="{{ Route::is('admin.users') || Route::is('admin.user.create') || Route::is('admin.user.edit') ? 'active' : '' }}"><i class="fas fa-users"></i>Users</a></li>
        <li><a href="/admin/events" class="{{ Route::is('admin.events') || Route::is('admin.event.create') || Route::is('admin.event.edit') ? 'active' : '' }}"><i class="fas fa-calendar"></i>Events</a></li>
        <li><a href="/admin/registrations" class="{{ Route::is('admin.registrations') || Route::is('admin.registration.create') || Route::is('admin.registration.edit') ? 'active' : '' }}"><i class="fas fa-clipboard-list"></i>Registrations</a></li>
    </ul>
</aside>

<script>
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    // Toggle sidebar when button is clicked
    sidebarToggle.addEventListener('click', function () {
        sidebar.classList.toggle('active');
        sidebarOverlay.classList.toggle('active');
    });

    // Close sidebar when overlay is clicked
    sidebarOverlay.addEventListener('click', function () {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
    });

    // Close sidebar when a link is clicked
    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            }
        });
    });

    // Handle window resize
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('active');
            sidebar.classList.remove('hidden');
            sidebarOverlay.classList.remove('active');
        }
    });
</script>
