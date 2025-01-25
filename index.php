<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoElite Dashboard</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo">EcoElite</div>
    <ul class="nav-links">
      <li><a href="#">Home</a></li>
      <li><a href="#about-us">About Us</a></li>
    </ul>
  </nav>

  <!-- Dashboard Content -->
  <div class="dashboard">
    <div class="content">
    <h1 class="headings">"Keep it Clean, Keep it Green"</h1>
    <p>This mantra emphasizes the importance of proper waste management, including recycling, composting, and reducing litter. Together, we can create a cleaner, greener, and healthier world.</p>
      <button class="login-btn" onclick="showLoginOptions()">Login</button>
    </div>
  </div>

  <!-- About Us Section -->
  <div id="about-us" class="content-section">
    <div class="title">
      <h1>ABOUT US</h1>
    </div>
    <div class="content">
      <p>At Waste Management Platform, we're passionate about creating a sustainable future. Our mission is to empower individuals, businesses, and governments to reduce their environmental footprint.</p>
      <h3>Our Mission</h3>
      <p>Empower communities to adopt sustainable waste management practices and reduce environmental impact.</p>
      <h3>Our Vision</h3>
      <p>A world where waste is minimized, reused, and recycled for a sustainable tomorrow.</p>
    </div>
  </div>

  <!-- Login Modal -->
  <div class="login-modal" id="loginModal">
    <div class="modal-content">
      <h2>Choose Login</h2>
      <button onclick="location.href='./Users/userLogin.php'" class="modal-btn">User Login</button>
      <button onclick="location.href='./admin/adminLogin.php'" class="modal-btn">Admin Login</button>
      <button class="close-btn" onclick="hideLoginOptions()">Close</button>
    </div>
  </div>

  <script>
    function showLoginOptions() {
      document.getElementById("loginModal").style.display = "flex";
    }
    function hideLoginOptions() {
      document.getElementById("loginModal").style.display = "none";
    }
  </script>
</body>
</html>
