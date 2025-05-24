<?php
session_start();
ob_start(); // Prevents premature output issues
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please Login";
    header("Location: http://localhost/FUTURE_SYNC/user_registration/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Help & Support - FutureSync</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
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

    h1 {
      font-size: 48px;
      margin-bottom: 30px;
      color: #ffc8ff;
      text-shadow: 0 0 15px #ff00ff;
      text-align: center;
    }

    .container {
  display: flex;
  flex-direction: row; /* row layout */
  justify-content: space-between;
  flex-wrap: wrap; /* ensures responsiveness */
  gap: 30px;
  padding: 30px;
  width: 100%;
  max-width: 1000px;
  background: rgba(255, 255, 255, 0.05);
  border: 2px solid #8a2be2;
  border-radius: 20px;
  box-shadow: 0 0 30px rgba(255, 0, 255, 0.2);
  backdrop-filter: blur(12px);
}

/* Each section gets half width on larger screens */
.section {
  flex: 1 1 45%;
}

/* Optional: full width on small screens */
@media (max-width: 768px) {
  .container {
    flex-direction: column;
  }

  .section {
    width: 100%;
  }
}


    .section h2 {
      font-size: 28px;
      margin-bottom: 20px;
      background: linear-gradient(90deg, #8a2be2, #ff00ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-align: center;
    }

    .contact-info {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
    }

    .contact-info div {
      font-size: 18px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: #ffc8ff;
    }

    .faq-item {
      margin: 20px 0;
      width: 100%;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding-bottom: 10px;
    }

    .question {
      font-weight: bold;
      display: flex;
      align-items: center;
      cursor: pointer;
      font-size: 18px;
      transition: 0.2s ease;
    }

    .question:hover {
      color: #ffccff;
      text-shadow: 0 0 10px #ff00ff;
    }

    .question i {
      margin-right: 10px;
      color: #ff00ff;
    }

    .popup {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.4s ease, padding 0.3s ease;
      font-size: 16px;
      background: rgba(255, 255, 255, 0.03);
      border-left: 3px solid #ff00ff;
      border-radius: 10px;
      color: #f0e8ff;
      padding: 0 15px;
    }

    .popup.show {
      padding: 10px 15px;
      max-height: 200px;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 36px;
      }

      .section h2 {
        font-size: 22px;
      }

      .contact-info div,
      .question {
        font-size: 16px;
      }

      .brand {
        flex-direction: column;
        text-align: center;
      }

      .brand-text h2 {
        font-size: 40px;
      }

      .brand-text p {
        font-size: 16px;
      }

      h1 {
        font-size: 32px;
      }
    }
    
    hr {
    color: #ff00ff;
    border: 2px solid #ff00ff;
    margin: 20px auto;
  }

  .burger {
      position: relative;
      float:left;
      top: -20px;
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
    a:hover {
      color: #ffffff;
      text-shadow: 0 0 10px #ff00ff;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <header>
    <div class="brand">
      <img src="logo.jpg" alt="Logo" onerror="this.src='default-logo.png';" />
      <div class="brand-text">
        <h2>FutureSync</h2>
        <p>The Time is Yours!</p>
      </div>
    </div>
  </header><br>
  <br>
  <div class="burger" id="burger">
    <i class="fa-solid fa-bars" ></i>
</div>


    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <span class="close-btn" id="close-btn">&times;</span>
        <ul>
            <br>
            <img id="sidebar_logo" src="http://localhost/FUTURE_SYNC/user_dashboard/logo.jpg" alt="logo" width="180" height="100"><br><br><br>
            <li><a href="http://localhost/FUTURE_SYNC/user_dashboard/dashboard.php">Home</a></li>
            <li><a href="http://localhost/FUTURE_SYNC/user_dashboard/help.php">Help</a></li>
            <li><a href="http://localhost/FUTURE_SYNC/admin_login/ad_login.php">Admin</a></li>
            <br><br><br><br><br><br><br><br><br>
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
    
  <h1>HELP & SUPPORT</h1><br>

  <div class="container">
    <!-- Contact Section -->
    <div class="section contact">
      <h2>Contact Details</h2>
      <div class="contact-info">
        <div><i class="fa-solid fa-phone"></i> 1234567890</div>
        <div><i class="fa-solid fa-envelope"></i> poo@ggmail.com</div>
        <div><i class="fa-brands fa-instagram"></i> Instagram</div>
        <div><i class="fa-brands fa-whatsapp"></i> WhatsApp</div>
        <div><i class="fa-solid fa-location-dot"></i> Location</div>
        
      </div>
      
    </div>
    <hr>
    <!-- FAQ Section -->
    <div class="section faq">
      <h2>FAQs</h2>

      <div class="faq-item">
        <div class="question" onclick="toggleAnswer('a1')" aria-expanded="false" aria-controls="a1">
          <i class="fa-solid fa-circle-question"></i> How can i send message?
        </div>
        <div id="a1" class="popup">Open Create tab and type the message and send.</div>
      </div>

      <div class="faq-item">
        <div class="question" onclick="toggleAnswer('a2')" aria-expanded="false" aria-controls="a2">
          <i class="fa-solid fa-circle-question"></i> How to view your created capsules?
        </div>
        <div id="a2" class="popup">Open the view tab and view your capsules.</div>
      </div>

      <div class="faq-item">
        <div class="question" onclick="toggleAnswer('a3')" aria-expanded="false" aria-controls="a3">
          <i class="fa-solid fa-circle-question"></i> How to Logout?
        </div>
        <div id="a3" class="popup">Go to Logout tab and click Logout button.</div>
      </div>

      <div class="faq-item">
        <div class="question" onclick="toggleAnswer('a4')" aria-expanded="false" aria-controls="a4">
          <i class="fa-solid fa-circle-question"></i> How do I contact support?
        </div>
        <div id="a4" class="popup">You can open Help tab and contact the admin for the queries.</div>
      </div>
    </div>
  </div>

  <script>
    function toggleAnswer(id) {
      const answer = document.getElementById(id);
      answer.classList.toggle('show');
    }
  </script>
</body>
</html>
