<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promote User to Admin - Event Nexus</title>
    @vite('resources/css/admin/register.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-shield"></i> Promote User to Admin</h1>
        <p class="subtitle">Give admin privileges to an existing user</p>

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Error!</strong>
                <ul style="margin-top: 10px; margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.promote') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="user_id"><i class="fas fa-user"></i> Select User</label>
                <select name="user_id" id="user_id" required onchange="fillUserData()">
                    <option value="">-- Select a user --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-phone="{{ $user->phone }}" data-category="{{ $user->category }}">
                            {{ $user->name }} ({{ $user->email }}) - {{ ucfirst($user->category) }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name"><i class="fas fa-id-card"></i> Name</label>
                <input type="text" id="name" name="name" readonly value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" readonly value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
            </div>

            <div class="form-group">
                <label for="role"><i class="fas fa-crown"></i> Admin Role</label>
                <select name="role" id="role" required>
                    <option value="">-- Select role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="moderator" {{ old('role') == 'moderator' ? 'selected' : '' }}>Moderator</option>
                </select>
                @error('role')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-plus"></i> Promote to Admin
            </button>
        </form>

        <div class="back-link">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <script>
        function fillUserData() {
            const select = document.getElementById('user_id');
            const selectedOption = select.options[select.selectedIndex];
            
            document.getElementById('name').value = selectedOption.getAttribute('data-name') || '';
            document.getElementById('email').value = selectedOption.getAttribute('data-email') || '';
            document.getElementById('phone').value = selectedOption.getAttribute('data-phone') || '';
        }
    </script>
</body>
</html>
