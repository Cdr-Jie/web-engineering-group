<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins - Event Nexus</title>
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
                <h1>Manage Admins</h1>
                <form action="/admin/logout" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; padding: 12px 24px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 38, 38, 0.3)'">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add Admin Button -->
            <div style="margin-bottom: 30px;">
                <a href="/admin/admins/create" class="btn" style="display:inline-block; margin: 5px;">
                    <i class="fas fa-plus"></i> Create New Admin
                
                <a href="/admin/admins/promote" class="btn" style="display:inline-block; margin: 5px;">
                    <i class="fas fa-plus"></i> Promote User to Admin
                </a>
            </div>

            <!-- Admins Table -->
            <div class="card">
                <h2>Admin List</h2>
                <div style="overflow-x: auto; margin-top: 20px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Name</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Email</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Phone</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Role</th>
                                <th style="padding: 15px; text-align: center; color: #333; font-weight: 600;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($admins as $admin)
                                <tr style="border-bottom: 1px solid #e5e7eb; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 15px; color: #333;">{{ $admin->name }}</td>
                                    <td style="padding: 15px; color: #666;">{{ $admin->email }}</td>
                                    <td style="padding: 15px; color: #666;">{{ $admin->phone ?? 'N/A' }}</td>
                                    <td style="padding: 15px;">
                                        <span style="background-color: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                            {{ ucfirst(str_replace('_', ' ', $admin->role)) }}
                                        </span>
                                    </td>
                                    <td style="padding: 15px; text-align: center;">
                                        <a href="/admin/admins/{{ $admin->id }}/edit" class="btn-small" style="display:inline-block; background-color:#00d9a3; color:white; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px; margin-right: 8px; transition: background-color 0.3s;">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="/admin/admins/{{ $admin->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background-color:#dc2626; color:white; padding: 8px 12px; border-radius: 5px; border: none; font-size: 12px; cursor: pointer; transition: background-color 0.3s;">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="padding: 40px; text-align: center; color: #999;">
                                        No admins found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($admins->hasPages())
                    <div style="margin-top: 30px;">
                        {{ $admins->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        const adminDropdown = document.getElementById('adminDropdown');
        const adminDropdownMenu = document.getElementById('adminDropdownMenu');

        // Toggle admin dropdown
        adminDropdown?.addEventListener('click', function (e) {
            e.stopPropagation();
            adminDropdownMenu?.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.dropdown')) {
                adminDropdownMenu?.classList.remove('active');
            }
        });
    </script>
</body>
</html>
