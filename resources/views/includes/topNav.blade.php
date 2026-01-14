<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('index') }}" class="brand">Event Nexus</a>
        <div class="menu-icon" id="menu-icon">
            <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-links" id="nav-links">
            <li>
                <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'active' : '' }}">Home</a>
            </li>
            <li>
                <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
            </li>
            <li>
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            </li>
        </ul>
    </div>
</nav>

<script>
    const menuIcon = document.getElementById('menu-icon');
    const navLinks = document.getElementById('nav-links');

    if (menuIcon) {
        menuIcon.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });

        // Close menu when a link is clicked
        const links = navLinks.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.classList.remove('active');
            });
        });
    }
</script>
