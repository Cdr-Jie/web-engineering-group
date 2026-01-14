<!DOCTYPE html>
<html>
<head>
    <title>Event Nexus</title>
    @vite('resources/css/style.css')
</head>
<body>

@include('includes.loginTopNav')

<main style="padding: 40px;">
    @yield('content')
</main>

@include('includes.footer')

</body>
</html>
