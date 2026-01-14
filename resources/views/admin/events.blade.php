<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - Event Nexus</title>
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
                <h1>Manage Events</h1>
                <form action="/admin/logout" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; padding: 12px 24px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 38, 38, 0.3)'">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>

            <!-- Add Event Button -->
            <div style="margin-bottom: 30px;">
                <a href="/admin/events/create" class="btn" style="display:inline-block;">
                    <i class="fas fa-plus"></i> Create New Event
                </a>
            </div>

            {{-- Search Bar --}}
            <div style="max-width: 600px; margin: 0 auto 30px; display: flex; gap: 10px;">
                <form method="GET" action="{{ route('admin.events') }}" style="flex: 1; display: flex; gap: 10px;">
                    <input type="text" name="search" placeholder="Search events by name, description, or venue..." 
                           value="{{ $search ?? '' }}" 
                           style="flex: 1; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: border-color 0.3s ease;" 
                           onfocus="this.style.borderColor='#00d9a3'" 
                           onblur="this.style.borderColor='#e0e0e0'">
                    <button type="submit" style="padding: 12px 24px; background: linear-gradient(135deg, #00d9a3 0%, #1aa573 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;" 
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 217, 163, 0.3)'" 
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if($search ?? null)
                        <a href="{{ route('admin.events') }}" style="padding: 12px 24px; background: #f0f0f0; color: #333; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s ease;" 
                           onmouseover="this.style.background='#e0e0e0'" 
                           onmouseout="this.style.background='#f0f0f0'">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </form>
            </div>

            @if($search ?? null)
                <p style="text-align:center; color: #666; margin-bottom: 20px;">
                    Search results for: <strong>{{ $search }}</strong>
                </p>
            @endif

            <!-- Events Table -->
            <div class="card">
                <h2>Event List</h2>
                <div style="overflow-x: auto; margin-top: 20px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Title</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Organizer</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Date</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Participants</th>
                                <th style="padding: 15px; text-align: left; color: #333; font-weight: 600;">Status</th>
                                <th style="padding: 15px; text-align: center; color: #333; font-weight: 600;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                                <tr style="border-bottom: 1px solid #e5e7eb; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 15px; color: #333; font-weight: 500;">{{ $event->name }}</td>
                                    <td style="padding: 15px; color: #666;">{{ $event->organizer ?? 'N/A' }}</td>
                                    <td style="padding: 15px; color: #666; font-size: 13px;">
                                        {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td style="padding: 15px; color: #666;">
                                        @if($event->max_participants)
                                            {{ $event->registrations_count ?? 0 }}/{{ $event->max_participants }}
                                        @else
                                            {{ $event->registrations_count ?? 0 }}
                                        @endif
                                    </td>
                                    <td style="padding: 15px;">
                                        @if($event->date && \Carbon\Carbon::parse($event->date)->isPast())
                                            <span style="background-color: #f3f4f6; color: #666; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                Completed
                                            </span>
                                        @else
                                            <span style="background-color: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                Active
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 15px; text-align: center;">
                                        <a href="/admin/events/{{ $event->id }}/edit" class="btn-small" style="display:inline-block; background-color:#00d9a3; color:white; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px; margin-right: 8px; transition: background-color 0.3s;">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="/admin/events/{{ $event->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this event?');">
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
                                        No events found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($events->hasPages())
                    <div style="margin-top: 30px;">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
