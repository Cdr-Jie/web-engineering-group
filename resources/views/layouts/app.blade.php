<!DOCTYPE html>
<html>
<head>
    <title>CEMS</title>
    @vite('resources/css/style.css')
</head>
<body>

@include('includes.loginTopNav')

<main style="padding: 40px;">
    @yield('content')
</main>

<footer>
    <hr>
    © CHAN | BI23110228
</footer>

</body>
</html>
