<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    @vite('resources/css/style.css')
</head>
<body>

@include('includes.loginTopNav')

<section class="section-content">

    <h2 style="text-align:center;">Update Profile</h2>

<form method="POST" action="{{ route('profile.update') }}" class="profile-form">
    @csrf
    @method('PUT')

    <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
        @csrf
        @method('PUT')

        <!-- Name -->
        <label>
            Name
            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
        </label>

        <!-- Email -->
        <label>
            Email
            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
        </label>

        <!-- Password -->
        <label>
            New Password
            <input type="password" name="password" placeholder="Leave blank to keep current password">
        </label>

        <!-- Phone -->
        <label>
            Phone
            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
        </label>

        <!-- Category -->
       <label>
            Category
            <select name="category" required>
                <option value="">-- Select Category --</option>
                <option value="staff" {{ old('category', Auth::user()->category) == 'staff' ? 'selected' : '' }}>Staff</option>
                <option value="student" {{ old('category', Auth::user()->category) == 'student' ? 'selected' : '' }}>Student</option>
                <option value="public" {{ old('category', Auth::user()->category) == 'public' ? 'selected' : '' }}>Public</option>
            </select>
        </label>


        <!-- Preferred Event Types -->
        <!-- Event Type -->
        <label>
            Preferred Event Type
            <select name="events" required>
                <option value="">-- Select Event Type --</option>

                @foreach (['Workshop', 'Seminar', 'Competition', 'Festival', 'Sport', 'Course'] as $event)
                    <option value="{{ $event }}"
                        {{ old('events', Auth::user()->events) == $event ? 'selected' : '' }}>
                        {{ $event }}
                    </option>
                @endforeach
            </select>
        </label>
        
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back</a>
</form>