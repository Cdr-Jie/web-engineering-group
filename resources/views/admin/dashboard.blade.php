<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/admin.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('includes.sidebar')

    <div class="admin-container">
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Admin Dashboard</h1>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <!-- Notification Bell -->
                    <a href="/admin/notifications" style="font-size: 20px; color: #333; text-decoration: none; position: relative;" title="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge" id="adminNotificationBadge" style="display: none; position: absolute; top: -8px; right: -8px; background-color: #dc2626; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; font-weight: bold;">0</span>
                    </a>
                    <!-- Logout Button -->
                    <form action="/admin/logout" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; padding: 12px 24px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 38, 38, 0.3)'">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Admin Profile Card -->
            @if($admin)
                <div class="card" style="margin-bottom: 30px; background: linear-gradient(135deg, #f0fdfb 0%, #ffffff 100%); border-left: 4px solid #00d9a3;">
                    <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 20px; align-items: center;">
                        <!-- Profile Icon -->
                        <div style="display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; background: linear-gradient(135deg, #00d9a3 0%, #1aa573 100%); border-radius: 50%; color: white; font-size: 28px;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        
                        <!-- Profile Info -->
                        <div>
                            <h3 style="margin: 0 0 10px 0; color: #333;">{{ $admin->name }}</h3>
                            <p style="margin: 5px 0; color: #666; font-size: 14px;">
                                <i class="fas fa-envelope" style="color: #00d9a3; margin-right: 8px;"></i>{{ $admin->email }}
                            </p>
                            <p style="margin: 5px 0; color: #666; font-size: 14px;">
                                <i class="fas fa-phone" style="color: #00d9a3; margin-right: 8px;"></i>{{ $admin->phone ?? 'N/A' }}
                            </p>
                           
                        </div>
                        
                        <!-- Member Since -->
                        <div style="text-align: right;">
                            <p style="margin: 0; color: #666; font-size: 12px;">Member Since</p>
                            <p style="margin: 5px 0 0 0; color: #00d9a3; font-size: 16px; font-weight: 600;">
                                {{ $admin->created_at->format('M Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Dashboard Statistics -->
            <div class="dashboard-grid" id="dashboardGrid">
                <a href="/admin/users" class="card card-link" draggable="true" data-card-id="users">
                    <div class="card-icon"><i class="fas fa-users"></i></div>
                    <h3>Total Users</h3>
                    <div class="card-value">{{ $totalUsers }}</div>
                </a>

                <a href="/admin/events" class="card card-link" draggable="true" data-card-id="events">
                    <div class="card-icon"><i class="fas fa-calendar"></i></div>
                    <h3>Total Events</h3>
                    <div class="card-value">{{ $totalEvents }}</div>
                </a>

                <a href="/admin/registrations" class="card card-link" draggable="true" data-card-id="registrations">
                    <div class="card-icon"><i class="fas fa-clipboard-list"></i></div>
                    <h3>Total Registrations</h3>
                    <div class="card-value">{{ $totalRegistrations }}</div>
                </a>

                <a href="/admin/admins" class="card card-link" draggable="true" data-card-id="admins">
                    <div class="card-icon"><i class="fas fa-user-shield"></i></div>
                    <h3>Total Admins</h3>
                    <div class="card-value">{{ $adminCount }}</div>
                </a>

                <a href="/admin/approvals?status=pending" class="card card-link" draggable="true" data-card-id="approvals" style="border-left: 4px solid #ffc107;">
                    <div class="card-icon" style="color: #ffc107;"><i class="fas fa-check-circle"></i></div>
                    <h3>Pending Approvals</h3>
                    <div class="card-value" style="color: #ffc107;">{{ $pendingApprovals }}</div>
                </a>
            </div>
            <!-- Customization Button -->
            <div style="text-align: center; margin: 30px 0;">
                <button id="customizeBtn" class="btn" style="background: linear-gradient(135deg, #00d9a3 0%, #1aa573 100%); color: white; padding: 12px 30px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-edit"></i> Customize Layout
                </button>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <h2>Quick Actions</h2>
                <div class="actions" style="margin-top: 20px;">
                    <!-- Admin Dropdown -->
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" id="adminDropdown">
                            <i class="fas fa-plus"></i> Add New Admin <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="adminDropdownMenu">
                            <a href="/admin/admins/create" class="dropdown-item">
                                <i class="fas fa-user-plus"></i> Create New Admin
                            </a>
                            <a href="/admin/admins/promote" class="dropdown-item">
                                <i class="fas fa-crown"></i> Promote User to Admin
                            </a>
                        </div>
                    </div>
                    <a href="/admin/users" class="btn btn-secondary"><i class="fas fa-users"></i> View Users</a>
                    <a href="/admin/events" class="btn btn-secondary"><i class="fas fa-calendar"></i> View Events</a>
                    <a href="/admin/registrations" class="btn btn-secondary"><i class="fas fa-clipboard-list"></i> View Registrations</a>
                </div>
            </div>
        </main>
    </div>

    <script>
        const adminDropdown = document.getElementById('adminDropdown');
        const adminDropdownMenu = document.getElementById('adminDropdownMenu');
        const customizeBtn = document.getElementById('customizeBtn');
        const dashboardGrid = document.getElementById('dashboardGrid');
        let isCustomizing = false;
        let draggedElement = null;

        // Toggle customization mode
        customizeBtn.addEventListener('click', function () {
            isCustomizing = !isCustomizing;
            
            if (isCustomizing) {
                // Enable customization mode
                customizeBtn.innerHTML = '<i class="fas fa-save"></i> Save Layout';
                customizeBtn.style.background = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
                dashboardGrid.style.cursor = 'grab';
                dashboardGrid.classList.add('customizing');
                localStorage.setItem('dashboardCustomizing', 'true');
            } else {
                // Save and disable customization mode
                customizeBtn.innerHTML = '<i class="fas fa-edit"></i> Customize Layout';
                customizeBtn.style.background = 'linear-gradient(135deg, #00d9a3 0%, #1aa573 100%)';
                dashboardGrid.style.cursor = 'default';
                dashboardGrid.classList.remove('customizing');
                saveDashboardLayout();
                localStorage.setItem('dashboardCustomizing', 'false');
            }
        });

        // Drag and drop functionality
        dashboardGrid.addEventListener('dragstart', function (e) {
            if (!isCustomizing) return;
            draggedElement = e.target.closest('.card');
            draggedElement.style.opacity = '0.5';
        });

        dashboardGrid.addEventListener('dragend', function (e) {
            if (draggedElement) {
                draggedElement.style.opacity = '1';
                draggedElement = null;
            }
        });

        dashboardGrid.addEventListener('dragover', function (e) {
            if (!isCustomizing) return;
            e.preventDefault();
            const card = e.target.closest('.card');
            if (card && card !== draggedElement) {
                const grid = document.getElementById('dashboardGrid');
                const allCards = [...grid.querySelectorAll('.card')];
                const draggedIndex = allCards.indexOf(draggedElement);
                const targetIndex = allCards.indexOf(card);

                if (draggedIndex < targetIndex) {
                    card.parentNode.insertBefore(draggedElement, card.nextSibling);
                } else {
                    card.parentNode.insertBefore(draggedElement, card);
                }
            }
        });

        // Save dashboard layout to localStorage
        function saveDashboardLayout() {
            const cards = dashboardGrid.querySelectorAll('.card');
            const layout = Array.from(cards).map(card => card.getAttribute('data-card-id'));
            localStorage.setItem('dashboardLayout', JSON.stringify(layout));
        }

        // Load saved dashboard layout
        function loadDashboardLayout() {
            const savedLayout = localStorage.getItem('dashboardLayout');
            if (savedLayout) {
                try {
                    const layout = JSON.parse(savedLayout);
                    const cards = dashboardGrid.querySelectorAll('.card');
                    const cardMap = {};
                    
                    cards.forEach(card => {
                        cardMap[card.getAttribute('data-card-id')] = card;
                    });

                    layout.forEach(cardId => {
                        if (cardMap[cardId]) {
                            dashboardGrid.appendChild(cardMap[cardId]);
                        }
                    });
                } catch (e) {
                    console.error('Error loading dashboard layout:', e);
                }
            }
        }

        // Initialize customization mode from localStorage
        function initializeCustomizationMode() {
            const isCustomizing = localStorage.getItem('dashboardCustomizing') === 'true';
            if (isCustomizing) {
                customizeBtn.click();
            }
        }

        // Toggle admin dropdown
        adminDropdown.addEventListener('click', function (e) {
            e.stopPropagation();
            adminDropdownMenu.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.dropdown')) {
                adminDropdownMenu.classList.remove('active');
            }
        });

        // Load layout on page load
        document.addEventListener('DOMContentLoaded', function () {
            loadDashboardLayout();
            initializeCustomizationMode();
            loadAdminNotificationCount();
        });

        // Load unread notification count for admin
        function loadAdminNotificationCount() {
            fetch('{{ route("notifications.unreadCount") }}', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                }
            })
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('adminNotificationBadge');
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(error => console.error('Error loading notification count:', error));
        }

        // Refresh notification count every 30 seconds
        setInterval(loadAdminNotificationCount, 30000);
    </script>
</body>
</html>
