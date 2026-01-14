<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Registrations - Event Nexus</title>
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
                <h1>Manage Registrations</h1>
                <form action="/admin/logout" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; padding: 12px 24px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 38, 38, 0.3)'">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>

            <!-- Filter Section -->
            <div class="card" style="margin-bottom: 20px;">
                <form method="GET" action="/admin/registrations" style="display: flex; align-items: center; gap: 15px;">
                    <label for="event-filter" style="color: #333; font-weight: 600;">Filter by Event:</label>
                    <select name="event_id" id="event-filter" style="padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 14px; background-color: white; color: #333; cursor: pointer; min-width: 250px;">
                        <option value="">All Events</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ $eventFilter == $event->id ? 'selected' : '' }}>
                                {{ $event->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" style="background-color: #00d9a3; color: white; padding: 10px 20px; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background-color 0.3s;">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    @if($eventFilter)
                        <a href="/admin/registrations" style="background-color: #6b7280; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600; transition: background-color 0.3s;">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Registrations Table -->
            <div class="card">
                <h2>Registration List</h2>
                <div style="overflow-x: auto; margin-top: 20px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">User</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Event</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Registered On</th>
                                <th style="padding: 15px; text-align: center; color: #333; font-weight: 600;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $registration)
                                <tr style="border-bottom: 1px solid #e5e7eb; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 15px; color: #333; font-weight: 500;">
                                        {{ $registration->user ? $registration->user->name : 'Deleted User' }}
                                    </td>
                                    <td style="padding: 15px; color: #666;">
                                        {{ $registration->event ? $registration->event->name : 'Deleted Event' }}
                                    </td>

                                    <td style="padding: 15px; color: #666; font-size: 13px;">
                                        {{ $registration->created_at->format('M d, Y h:i A') }}
                                    </td>
                                    <td style="padding: 15px; text-align: center;">
                                        
                                        <form action="/admin/registrations/{{ $registration->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this registration?');">
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
                                        No registrations found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($registrations->hasPages())
                    <div style="margin-top: 30px;">
                        {{ $registrations->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>

   
</body>
</html>
