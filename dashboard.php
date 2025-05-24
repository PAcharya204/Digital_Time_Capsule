<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FutureSync</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(135deg, #1a0029, #2d0066);
      color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
      overflow-x: hidden;
    }
    header {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      display: flex;
      align-items: center;
      padding: 20px 40px;
      width: 99%;
      box-shadow: 0 8px 30px rgba(255, 0, 255, 0.1);
      margin-top: 0;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .brand img {
      width: 100px;
      border-radius: 14px;
      background: transparent;
    }

    .brand-text h2 {
      font-size: 60px;
      background: linear-gradient(90deg, #ff00cc, #3333ff);
      background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: 3px 3px 10px rgba(255, 255, 255, 0.3);
    }

    .brand-text p {
      font-size: 22px;
      color: #ffcaff;
    }
        #sidebar_logo {
            top: 0;
            left: 0;
            position: absolute;
        }


        .main-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 40px 20px;
  text-align: center;
}

.big_logo img {
  width: 100%; /* You can keep it 200% if you really want, but 100% is standard */
  max-width: 600px;
  border-radius: 15px;
  box-shadow: 0 0 20px rgba(255, 0, 128, 0.5);
}


    .button-container {
      margin-top: -60px;
    }

    .button2 {
      width: 300px;
      padding: 12px 20px;
      font-size: 18px;
      border-radius: 8px;
      background: #7209b7;
      color: white;
      border: 2px solid #ff70d9;
      cursor: pointer;
      transition: 0.3s;
    }

    .button2:hover {
      background: #ff70d9;
      color: #08011f;
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(255, 0, 128, 0.6);
    }

    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      padding: 40px;
      max-width: 1200px;
      margin: auto;
    }

    .grid-item {
      background: #1e1232;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(255, 0, 128, 0.2);
      transition: 0.3s;
    }

    .grid-item:hover {
      transform: scale(1.05);
      box-shadow: 0 0 15px rgba(255, 0, 128, 0.4);
    }

    .grid-item h3 {
      color: #ff70d9;
    }

    .grid-item p {
      color: #d1c4e9;
    }

    .section {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: center;
      margin: 60px auto;
      max-width: 1000px;
      gap: 40px;
    }

    .section img {
      width: 300px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(255, 0, 128, 0.4);
    }

    .section-content {
      max-width: 600px;
      color: #d1c4e9;
    }

    .section-content h2 {
      color: #ff70d9;
      margin-bottom: 10px;
    }

    .section-content p {
      line-height: 1.7;
    }

    .divider {
      margin: 40px auto;
      width: 90%;
      height: 2px;
      background: linear-gradient(to right, #ff70d9, #7209b7);
      border: none;
      border-radius: 2px;
    }

    .footer {
      display: flex;
      justify-content: space-around;
      align-items: center;
      position: fixed;
      bottom: 0;
      width: 100%;
      background: #1b0e3f;
      padding: 10px;
      box-shadow: 0 -2px 10px rgba(255, 0, 128, 0.3);
    }

    .footer div {
      text-align: center;
      padding: 10px;
      flex: 1;
      color: #aaa;
      transition: 0.3s;
    }

    .footer div:hover {
      color: #ff70d9;
      transform: scale(1.05);
    }

    .footer a {
      text-decoration: none;
      color: inherit;
    }

    /* ========== TABLET (1024px and below) ========== */
@media (max-width: 1024px) {
  header {
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 20px;
  }

  .brand {
    flex-direction: column;
    gap: 10px;
  }

  .brand-text h2 {
    font-size: 48px;
  }

  .brand-text p {
    font-size: 20px;
  }

  .grid-container {
    padding: 20px;
  }
}

/* ========== SMALL TABLET / LANDSCAPE PHONE (768px and below) ========== */
@media (max-width: 768px) {
  .main-container {
    padding: 20px 10px;
  }

  .big_logo img {
    max-width: 90%;
  }

  .button2 {
    width: 90%;
  }

  .section {
    flex-direction: column;
    text-align: center;
    gap: 30px;
  }

  .section img {
    width: 90%;
  }

  .footer {
    flex-direction: column;
    text-align: center;
    padding: 15px;
  }

  .burger {
    position: absolute;
    left: 10px;
  }

  .sidebar {
    width: 200px;
  }

  .brand-text h2 {
    font-size: 36px;
  }

  .brand-text p {
    font-size: 18px;
  }
}

/* ========== PHONE PORTRAIT (480px and below) ========== */
@media (max-width: 480px) {
  .brand-text h2 {
    font-size: 28px;
  }

  .brand-text p {
    font-size: 16px;
  }

  .section-content {
    padding: 0 10px;
  }

  .button2 {
    font-size: 16px;
    padding: 10px 16px;
  }

  .footer div {
    padding: 6px;
    font-size: 14px;
  }

  .close-btn {
    font-size: 20px;
    top: 10px;
    right: 10px;
  }

  .sidebar {
    width: 180px;
  }

  .sidebar ul li {
    font-size: 16px;
  }
}


    .burger {
      position: relative;
      float:left;
      
      left: -48%;
      font-size: 30px;
      cursor: pointer;
      z-index: 2;
      color: #ff00ff;
    }

    .hide {
      display: none;
    }

    .sidebar {
      width: 250px;
      height: 100vh;
      background: linear-gradient(135deg, #1a0029, #2d0066);
      position: fixed;
      left: -250px;
      top: 10px;;
      z-index: 1000;
      transition: 0.3s;
      box-shadow: 2px 0 10px rgba(255, 0, 255, 0.3);
    }

    .sidebar.open {
      left: 0;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      padding: 15px;
      border-bottom: 1px solid #2D2D50;
      font-size: 18px;
    }

    .sidebar ul li a {
      text-decoration: none;
      color: #ffc8ff;
      display: block;
      transition: 0.3s;
    }

    .sidebar ul li a:hover {
      background: gray;
      padding-left: 10px;
      padding: 10px;
      border-radius: 50px;
    }

    .close-btn {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 25px;
      cursor: pointer;
      color: #ffc8ff;
    }

        #sidebar_logo {
            top: 0;
            left: 0;
            position: absolute;
        }
  </style>
</head>

<body>
  <!-- Header -->
  <header>
    <div class="brand">
      <img src="logo.jpg" alt="Logo">
      <div class="brand-text">
        <h2>FutureSync</h2>
        <p>The Time is Yours!</p>
      </div>
    </div>
  </header>
  <br>

  <div class="burger" id="burger">
    <i class="fa-solid fa-bars" ></i>
</div>


    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <span class="close-btn" id="close-btn">&times;</span>
        <ul>
            <br>
            <img id="sidebar_logo" src="http://localhost/FUTURE_SYNC/user_dashboard/logo.jpg" alt="logo" width="180"
                height="100px"><br><br><br><br><br><br><br>
            <li><a href="http://localhost/FUTURE_SYNC/user_dashboard/dashboard.php">Home</a></li>
            <li><a href="http://localhost/FUTURE_SYNC/user_dashboard/help.php">Help</a></li>
            <li><a href="http://localhost/FUTURE_SYNC/admin_login/ad_login.php">Admin</a></li>
            <li><a href="http://localhost/FUTURE_SYNC/user_registration/index.php">Sign up</a></li>
            <li><a href="http://localhost/FUTURE_SYNC/user_login/login.php">Login</a></li>
            <br><br><br><br>
            <li><a href="http://localhost/FUTURE_SYNC/user_dashboard/logout.php">Logout</a></li>
        </ul>
    </div>

    <script>
        // Get elements
        const burger = document.getElementById('burger');
        const sidebar = document.getElementById('sidebar');
        const closeBtn = document.getElementById('close-btn');

        // Open sidebar and hide burger icon
        burger.addEventListener('click', () => {
            sidebar.classList.add('open');
            burger.classList.add('hide'); // Hide burger icon
        });

        // Close sidebar and show burger icon
        closeBtn.addEventListener('click', () => {
            sidebar.classList.remove('open');
            burger.classList.remove('hide'); // Show burger icon again
        });

        // Close sidebar when clicking outside and show burger again
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !burger.contains(e.target)) {
                sidebar.classList.remove('open');
                burger.classList.remove('hide'); // Show burger again
            }
        });
    </script>
    <br><br>

  <!-- Main Content -->
  <div class="main-container">
    <div class="big_logo">
      <img src="FullLogo.jpg" alt="Main Logo" >
    </div>
    
  </div>

  <!-- Grid Section -->
  <div class="grid-container">
    <div class="grid-item">
      <h3>Time Capsule 2025</h3>
      <p>Capture your moments for the future.</p>
    </div>
    <div class="grid-item">
      <h3>Memory Vault</h3>
      <p>Store and revisit your best memories.</p>
    </div>
    <div class="grid-item">
      <h3>Future Innovations</h3>
      <p>See what’s coming next in technology.</p>
    </div>
  </div>

  <!-- What is Time Capsule -->
  <div class="section">
    <img src="Futuresync.jpg" alt="Time Capsule">
    <div class="section-content">
      <h2>What is Time Capsule</h2>
      <p>
        A time capsule is a historic cache of goods or information, usually intended as a deliberate method of communication with future people. It helps future archaeologists, anthropologists, or historians. 
        Time capsules are often created during events like world's fairs or building ceremonies.
      </p>
    </div>
  </div>
  <hr class="divider">

  <!-- Our Objective -->
  <div class="section">
    <img src="Objective.jpg" alt="Objective">
    <div class="section-content">
      <h2>Our Objective</h2>
      <p>
        Our goal is to preserve precious memories, connect generations, and provide a platform to document meaningful moments. Whether it’s a message to your future self or a collection of cherished memories, we ensure it stays safe and timeless.
      </p>
    </div>
  </div>
  <hr class="divider">

  <!-- Our Mission -->
  <div class="section">
    <img src="mission.jpeg" alt="Mission">
    <div class="section-content">
      <h2>Our Mission</h2>
      <p>
        Better Human Beings: To inspire, guide, and equip people to be better! We empower users to preserve their legacy and document their journey through our innovative digital time capsule platform.
      </p>
    </div>
  </div>
  <hr class="divider"><br><br><br>

  <!-- Footer -->
  <div class="footer">
    <a href="http://localhost/FUTURE_SYNC/create_capsule/create_capsule.php">
      <div>
        <i class="fa-solid fa-pen-to-square"></i>
        <p>Create</p>
      </div>
    </a>
    <a href="http://localhost/FUTURE_SYNC/view_capsule/nview.php">
      <div>
        <i class="fa-solid fa-eye"></i>
        <p>My Creation</p>
      </div>
    </a>
    <a href="http://localhost/FUTURE_SYNC/user_dashboard/profile.php">
      <div>
        <i class="fa-solid fa-user"></i>
        <p>User Profile</p>
      </div>
    </a>
  </div>

  <script>
    document.getElementById('burger').addEventListener('click', () => {
      document.getElementById('sidebar').classList.add('open');
    });

    document.getElementById('close-btn').addEventListener('click', () => {
      document.getElementById('sidebar').classList.remove('open');
    });
  </script>
</body>
</html>
