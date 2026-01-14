<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Event Nexus</title>
  @vite('resources/css/style.css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- ======= Hero Section ======= -->
  <header class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
    <img src="{{ asset('images/logo.jpg') }}" alt="Event Nexus Logo" class = 'logo'>
      <h1>Event Nexus</h1>
      <p>Organize, manage, and participate in campus events seamlessly</p>
    </div>
  </header>

  <!-- ======= Top Navigation ======= -->
   @include('includes.topNav')

  <?php
     #include("include/topNav.php");
  ?>  
  
  <main>
    <section class="intro">
      <h2>Welcome to Event Nexus</h2>
      <p>
        This system helps you manage and explore upcoming campus events efficiently.
        Register or log in to get started.
      </p>
    </section>
    <section class="listing">
      <h2>Event Listing</h2>
      
      <div class="filter-section">
        <button class="filter-btn active" data-type="all">All Events</button>
        <button class="filter-btn" data-type="Workshop">Workshop</button>
        <button class="filter-btn" data-type="Seminar">Seminar</button>
        <button class="filter-btn" data-type="Competition">Competition</button>
        <button class="filter-btn" data-type="Festival">Festival</button>
        <button class="filter-btn" data-type="Sport">Sport</button>
        <button class="filter-btn" data-type="Course">Course</button>
      </div>
      
      <div class="events-carousel-container">
        <button class="carousel-btn carousel-btn-left" id="prevBtn">
          <i class="fas fa-chevron-left"></i>
        </button>
        
        <div class="carousel-wrapper">
          <div class="carousel-events" id="carouselEvents">
            @forelse($events as $event)

              <div class="carousel-event-card" data-event-type="{{ $event->type }}">
                <div class="event-card" style="position: relative; cursor: not-allowed;">
                  @if($event->posters)
                    @php
                      $poster = is_array($event->posters) ? $event->posters[0] : $event->poster;
                    @endphp
                    <div class="event-image-wrapper">
                      <img src="{{ asset('storage/' . $poster) }}" alt="{{ $event->title }}" class="event-image">
                      <div class="event-hover-overlay">
                        <p>Login to join this event</p>
                      </div>
                    </div>
                  @else
                    <div class="event-image-placeholder">No Image</div>
                  @endif
                  
                  <div class="event-content">
                    <h3>{{ $event->name }}</h3>
                    <p class="event-venue">
                      <i class="fas fa-map-marker-alt"></i> {{ $event->venue }}
                    </p>
                    <p class="event-date">
                      <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                    </p>
                    <p class="event-time">
                      <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                    </p>
                    <p class="event-type">
                      <span class="badge">{{ $event->type }}</span>
                    </p>
                  </div>
                  
                </div>
              </div>
            @empty
              <p style="text-align: center; width: 100%;">No events available at the moment.</p>
            @endforelse
          </div>
        </div>
        
        <button class="carousel-btn carousel-btn-right" id="nextBtn">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </section>
  </main>

  @include('includes.footer')
  <!-- <footer>
        <hr>
        <p>&copy; Sam | BI12345678</p>
    </footer> -->

  <script>
    // Filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    let currentFilter = 'all';

    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        // Update active button
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        // Set current filter
        currentFilter = btn.getAttribute('data-type');
        
        // Reset carousel position
        currentIndex = 0;
        
        // Show filtered events
        showEvents();
      });
    });

    // Carousel functionality
    const carouselEvents = document.getElementById('carouselEvents');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let currentIndex = 0;

    function getVisibleCards() {
      const allCards = document.querySelectorAll('.carousel-event-card');
      if (currentFilter === 'all') {
        return Array.from(allCards);
      }
      return Array.from(allCards).filter(card => {
        const eventType = card.getAttribute('data-event-type');
        return eventType === currentFilter;
      });
    }

    function showEvents() {
      const allCards = document.querySelectorAll('.carousel-event-card');
      const visibleCards = getVisibleCards();
      const totalVisibleCards = visibleCards.length;
      
      // Hide all cards
      allCards.forEach(card => card.style.display = 'none');
      
      // Show 3 cards starting from currentIndex
      for (let i = currentIndex; i < currentIndex + 3 && i < totalVisibleCards; i++) {
        visibleCards[i].style.display = 'block';
      }
      
      // Disable prev button if at start
      prevBtn.disabled = currentIndex === 0;
      
      // Disable next button if at end
      nextBtn.disabled = currentIndex + 3 >= totalVisibleCards;
    }

    prevBtn.addEventListener('click', () => {
      if (currentIndex > 0) {
        currentIndex -= 3;
        showEvents();
      }
    });

    nextBtn.addEventListener('click', () => {
      const visibleCards = getVisibleCards();
      if (currentIndex + 3 < visibleCards.length) {
        currentIndex += 3;
        showEvents();
      }
    });

    // Initialize carousel on page load
    showEvents();
  </script>
</body>
</html>
