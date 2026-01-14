<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('dashboard') }}" class="brand">Event Nexus</a>
        <div class="menu-icon" id="menu-icon">
            <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-links" id="nav-links">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.index') ? 'active' : '' }}">Events</a>
            </li> 
            <li>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </form>
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
