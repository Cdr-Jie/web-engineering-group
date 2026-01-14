<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin - Event Nexus</title>
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
                <h1>Edit Admin</h1>
                <form action="/admin/logout" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; padding: 12px 24px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 38, 38, 0.3)'">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>

            <!-- Edit Form -->
            <div class="card" style="max-width: 600px;">
                <h2>Update Admin Information</h2>

                @if($errors->any())
                    <div style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; padding: 15px; border-radius: 8px; margin-bottom: 20px; margin-top: 15px;">
                        <strong>Errors:</strong>
                        <ul style="margin: 10px 0 0 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/admin/admins/{{ $admin->id }}" method="POST" style="margin-top: 20px;">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div style="margin-bottom: 20px;">
                        <label for="name" style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; transition: all 0.3s;" onfocus="this.style.borderColor='#00d9a3'; this.style.boxShadow='0 0 0 4px rgba(0, 217, 163, 0.1)'" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>

                    <!-- Email -->
                    <div style="margin-bottom: 20px;">
                        <label for="email" style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; transition: all 0.3s;" onfocus="this.style.borderColor='#00d9a3'; this.style.boxShadow='0 0 0 4px rgba(0, 217, 163, 0.1)'" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>

                    <!-- Phone -->
                    <div style="margin-bottom: 20px;">
                        <label for="phone" style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">Phone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $admin->phone) }}" style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; transition: all 0.3s;" onfocus="this.style.borderColor='#00d9a3'; this.style.boxShadow='0 0 0 4px rgba(0, 217, 163, 0.1)'" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>

                    <!-- Role -->
                    <div style="margin-bottom: 20px;">
                        <label for="role" style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">Role</label>
                        <select id="role" name="role" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; transition: all 0.3s; cursor: pointer;" onfocus="this.style.borderColor='#00d9a3'; this.style.boxShadow='0 0 0 4px rgba(0, 217, 163, 0.1)'" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                            <option value="admin" {{ old('role', $admin->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="super_admin" {{ old('role', $admin->role) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="moderator" {{ old('role', $admin->role) === 'moderator' ? 'selected' : '' }}>Moderator</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div style="margin-bottom: 20px;">
                        <label for="password" style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">New Password</label>
                        <input type="password" id="password" name="password" placeholder="Leave blank to keep current password" style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; transition: all 0.3s;" onfocus="this.style.borderColor='#00d9a3'; this.style.boxShadow='0 0 0 4px rgba(0, 217, 163, 0.1)'" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>

                    <!-- Confirm Password -->
                    <div style="margin-bottom: 20px;">
                        <label for="password_confirmation" style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; transition: all 0.3s;" onfocus="this.style.borderColor='#00d9a3'; this.style.boxShadow='0 0 0 4px rgba(0, 217, 163, 0.1)'" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>

                    <!-- Buttons -->
                    <div style="display: flex; gap: 10px; margin-top: 30px;">
                        <button type="submit" style="flex: 1; padding: 14px; background: linear-gradient(135deg, #00d9a3 0%, #1aa573 100%); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0, 217, 163, 0.3);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="/admin/admins" style="flex: 1; padding: 14px; background: #6c757d; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;" onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
