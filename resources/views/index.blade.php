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
        <div>
		      <table border="1" align="center">
		        <tr>
		          <td>All</td>
		          <td>Filter 1</td>
		          <td>Filter 2</td>
		          <td>Filter 3</td>
		        </tr>
		      </table>
		    </div>
		    <div>
		      <table width="100%" border="1" id="event_table">
		        <tr>
              <td>Event 1<img src="{{ asset('images/event1.jpg') }}" style="width:100%"></td>
		          <td>Event 2<img src="{{ asset('images/event2.jpg') }}" style="width:100%"></td>
		          <td>Event 3<img src="{{ asset('images/event3.jpg') }}" style="width:100%"></td>
		        </tr>
		        <tr>
		          <td>img</td>
		          <td>img</td>
		          <td>img</td>
		        </tr>
		      </table>
		    </div>
        </section>
  </main>

  @include('includes.footer')
  <!-- <footer>
        <hr>
        <p>&copy; Sam | BI12345678</p>
    </footer> -->

  <script>
    // Toggle mobile menu
    const menuIcon = document.getElementById('menu-icon');
    const navLinks = document.getElementById('nav-links');
    menuIcon.onclick = () => navLinks.classList.toggle('active');
  </script>
</body>
</html>
