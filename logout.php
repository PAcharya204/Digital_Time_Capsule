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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <title>Logout</title>
    <script>
        function confirmLogout() 
        {
            return confirm("Are you sure you want to logout?");
        }
    </script>
</head>
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


    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    h3 {
      font-size: 52px;
      color: #ffc8ff;
      margin: 50px 0 30px;
      text-shadow: 0 0 15px #ff00ff;
    }
    
    form {
       
        padding: 30px 40px;
        border-radius: 20px;
        
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    input[type="submit"] {
        background: linear-gradient(135deg, #9f00ff, #ff00ff);
      padding: 30px;
      width: 230px;
      height: 120px;
      color: #fff;
      border:none;
      border-radius: 20px;
      text-decoration: none;
      font-size: 30px;
      font-weight: bold;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 30px rgba(255, 0, 255, 0.3);
      transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    input[type="submit"]:hover {
        transform: scale(1.1);
      box-shadow: 0 15px 45px rgba(255, 0, 255, 0.5);
      background: linear-gradient(135deg, #ff00ff, #9f00ff);
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

<body>
<header>
    <div class="brand">
      <img src="logo.jpg" alt="Logo">
      <div class="brand-text">
        <h2>FutureSync</h2>
        <p>The Time is Yours!</p>
      </div>
    </div>
  </header><br><br>

  <div class="burger" id="burger">
    <i class="fa-solid fa-bars" ></i>
</div>


    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <span class="close-btn" id="close-btn">&times;</span>
        <ul>
            <br>
            <img id="sidebar_logo" src="http://localhost/FUTURE_SYNC/user_dashboard/logo.jpg" alt="logo" width="180"
                height="100px"><br><br><br>
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
    <h3>Want to Logout from your Account?</h3><br>
    <form action="" method="POST" onsubmit="return confirmLogout();">
        <input type="submit" value="LOGOUT" name="logout">
    </form>

    <?php
        if(isset($_POST['logout']))
        {
            session_unset();
            session_destroy();
            header("location:http://localhost/FUTURE_SYNC/user_login/login.php  ");
            exit();
        }
        ?>
</body>

</html>