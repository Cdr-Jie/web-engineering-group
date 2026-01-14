<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Event Nexus</title>
    @vite('resources/css/style.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!-- ======= Hero Section ======= -->
    <header class="hero-small">
        <div class="overlay"></div>
        <div class="hero-content">
            <img src="{{ asset('images/logo.jpg') }}" alt="Event Nexus Logo" class="logo">
            <h1>Event Nexus</h1>
            <p>Organize, manage, and participate in campus events seamlessly</p>
        </div>
    </header>

    @include('includes.topNav')

    <section class="section-content">
        <h3>Edit User</h3>

        {{-- Display success or error messages --}}
        @if(session('success'))
            <p style="color:green">{{ session('success') }}</p>
        @endif

        @if($errors->any())
            <ul style="color:red">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('admin.user.update', $user->id) }}" method="POST" name="edit_user_form">
            @csrf
            @method('PUT')

            {{-- Category --}}
            <fieldset>
                <legend>Category</legend>
                @php
                    $categoryOld = old('category', $user->category);
                @endphp
                <label><input type="radio" name="category" value="staff" {{ $categoryOld === 'staff' ? 'checked' : '' }} required> Staff</label>
                <label><input type="radio" name="category" value="student" {{ $categoryOld === 'student' ? 'checked' : '' }}> Student</label>
                <label><input type="radio" name="category" value="public" {{ $categoryOld === 'public' ? 'checked' : '' }}> Public</label>
            </fieldset>

            {{-- Full Name --}}
            <div>
                <label for="name">Full Name</label><br>
                <input type="text" id="name" name="name" required autocomplete="name" placeholder="Jane Doe" value="{{ old('name', $user->name) }}">
            </div>

            {{-- Email --}}
            <div>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" required autocomplete="email" placeholder="you@example.edu" value="{{ old('email', $user->email) }}">
            </div>

            {{-- Phone --}}
            <div>
                <label for="phone">Phone</label><br>
                <input type="tel" id="phone" name="phone" autocomplete="tel" placeholder="+60 12-345 6789" value="{{ old('phone', $user->phone) }}">
            </div>

            {{-- Password (Optional for edit) --}}
            <div>
                <label for="password">Password <span style="font-size: 12px; color: #666;">(Leave blank to keep current password)</span></label><br>
                <input type="password" id="password" name="password" minlength="6" autocomplete="new-password" placeholder="Enter new password or leave blank">
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation">Confirm Password</label><br>
                <input type="password" id="password_confirmation" name="password_confirmation" minlength="6" autocomplete="new-password" placeholder="Repeat your password">
            </div>

            <div>
                <button type="reset">Reset</button>
                <button type="submit">Update User</button>
            </div>
        </form>

        <p id="output" style="color:red"></p>
    </section>

    <footer>
        <p>&copy; 2026 Event Nexus. All rights reserved.</p>
    </footer>
</body>
</html>
