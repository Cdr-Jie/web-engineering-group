<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Event Nexus</title>
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
                <h1>Manage Users</h1>
                <form action="/admin/logout" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; padding: 12px 24px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 38, 38, 0.3)'">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>

            <!-- Add User Button -->
            <div style="margin-bottom: 30px;">
                <a href="/admin/users/create" class="btn" style="display:inline-block;">
                    <i class="fas fa-plus"></i> Create New User
                </a>
            </div>

            <!-- Users Table -->
            <div class="card">
                <h2>User List</h2>
                <div style="overflow-x: auto; margin-top: 20px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Name</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Email</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Category</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Phone</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Created</th>
                                <th style="padding: 15px; text-align: center; color: #333; font-weight: 600;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr style="border-bottom: 1px solid #e5e7eb; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 15px; color: #333; font-weight: 500;">{{ $user->name }}</td>
                                    <td style="padding: 15px; color: #666;">{{ $user->email }}</td>
                                    <td style="padding: 15px;">
                                        <span style="background-color: #dbeafe; color: #1e40af; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                            {{ ucfirst($user->category) }}
                                        </span>
                                    </td>
                                    <td style="padding: 15px; color: #666;">{{ $user->phone ?? 'N/A' }}</td>
                                    <td style="padding: 15px; color: #666; font-size: 13px;">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td style="padding: 15px; text-align: center;">
                                        <a href="/admin/users/{{ $user->id }}/edit" class="btn-small" style="display:inline-block; background-color:#00d9a3; color:white; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px; margin-right: 8px; transition: background-color 0.3s;">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="/admin/users/{{ $user->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
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
                                    <td colspan="6" style="padding: 40px; text-align: center; color: #999;">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div style="margin-top: 30px;">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
