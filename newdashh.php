<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FutureSync Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    :root {
      --primary: #6c5ce7;
      --light-bg: #f5f7fa;
      --white: #fff;
      --gray: #aaa;
      --dark: #2d3436;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      display: flex;
      height: 100vh;
      background-color: var(--light-bg);
    }

    .sidebar {
      width: 220px;
      background-color: var(--white);
      box-shadow: 2px 0 5px rgba(0,0,0,0.05);
      padding-top: 30px;
      transition: 0.3s;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      color: var(--primary);
    }

    .sidebar ul {
      list-style: none;
      padding: 0 20px;
    }

    .sidebar ul li {
      margin: 20px 0;
    }

    .sidebar ul li a {
      color: var(--dark);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: 0.2s;
    }

    .sidebar ul li a:hover {
      color: var(--primary);
    }

    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .navbar {
      height: 60px;
      background-color: var(--white);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 30px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .navbar h1 {
      font-size: 20px;
      color: var(--primary);
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .user-info img {
      width: 35px;
      border-radius: 50%;
    }

    .content {
      padding: 30px;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }

    .card {
      background: var(--white);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      transition: transform 0.2s ease;
    }

    .card:hover {
      transform: translateY(-3px);
    }

    .card h3 {
      color: var(--primary);
      margin-bottom: 10px;
    }

    .card p {
      color: var(--gray);
    }

    .footer {
      text-align: center;
      padding: 20px;
      font-size: 14px;
      color: var(--gray);
    }

    @media (max-width: 768px) {
      .sidebar {
        position: absolute;
        left: -220px;
      }

      .sidebar.active {
        left: 0;
        z-index: 999;
      }

      .toggle-sidebar {
        font-size: 24px;
        cursor: pointer;
        color: var(--primary);
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <h2>FutureSync</h2>
    <ul>
      <li><a href="#"><i class="fas fa-chart-line"></i> Dashboard</a></li>
      <li><a href="#"><i class="fas fa-clock"></i> Time Capsules</a></li>
      <li><a href="#"><i class="fas fa-calendar-alt"></i> Calendar</a></li>
      <li><a href="#"><i class="fas fa-envelope"></i> Messages</a></li>
      <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
    </ul>
  </div>

  <!-- Main -->
  <div class="main">
    <!-- Navbar -->
    <div class="navbar">
      <span class="toggle-sidebar" onclick="toggleSidebar()"><i class="fas fa-bars"></i></span>
      <h1>Welcome to FutureSync</h1>
      <div class="user-info">
        <span>Hi, Alex</span>
        <img src="https://i.pravatar.cc/40" alt="User" />
      </div>
    </div>

    <!-- Content -->
    <div class="content">
      <div class="cards">
        <div class="card">
          <h3>Capsules Created</h3>
          <p>24 capsules stored</p>
        </div>
        <div class="card">
          <h3>Next Unlock</h3>
          <p>May 15, 2025</p>
        </div>
        <div class="card">
          <h3>Archived Capsules</h3>
          <p>7 items</p>
        </div>
        <div class="card">
          <h3>Reminders Sent</h3>
          <p>15 this month</p>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      &copy; 2025 FutureSync — Preserve Your Legacy
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("active");
    }
  </script>

</body>
</html>
