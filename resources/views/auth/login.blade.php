<!DOCTYPE html>
<html>
    <head>
        @vite('resources/css/style.css')
    </head>
    <body>    
        <header class="hero-small">
            <div class="overlay"></div>
            <div class="hero-content">
            <img src="{{ asset('images/logo.jpg') }}" alt="CEMS Logo" class = 'logo'>
            <h1>Campus Event Management System</h1>
            <p>Organize, manage, and participate in campus events seamlessly</p>
            </div>
        </header>
        <?php 
            #include("include/topNav.php");
        ?>
        @include('includes.topNav')

        <section class="section-content">
            <div>
                <h3>Login to your account</h3>

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf

                    <label>
                        Email:<br>
                        <input type="email" name="email" required>
                    </label><br><br>

                    <label>
                        Password:<br>
                        <input type="password" name="password" required>
                    </label><br><br>

                    <button style="display:block; width:30%; margin:0 auto">
                        Login
                    </button>
                </form>

                {{-- Error messages --}}
                @if ($errors->any())
                    <div style="color:red; margin-top:10px;">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>

            <br><br>

            <div>
                <a href="{{ route('register') }}">Don't have an account? Register here</a><br>
                <a href="#">Forgot your password?</a>
            </div>
        </section>

        @include('includes.footer')
    </body>
</html>