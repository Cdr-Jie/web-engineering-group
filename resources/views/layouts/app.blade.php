<!DOCTYPE html>
<html>
<head>
    <title>Event Nexus</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite('resources/css/style.css')
</head>
<body>

@include('includes.loginTopNav')

<main style="padding: 10px;">
    @yield('content')
</main>

@include('includes.footer')

</body>
</html>
