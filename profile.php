<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
ob_start(); 
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    error_log("User not logged in. Redirecting...");
    header("Location: http://localhost/FUTURE_SYNC/user_registration/index.php");
    exit();
}    

$user_id = $_SESSION['user_id'];
$query = "SELECT name, dob, gender, address, email, phone, password FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <title>Dashboard</title>
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
      padding: 30px;
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
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .brand img {
      width: 100px;
      border-radius: 14px;
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

    .container {
      background: rgba(8, 3, 24, 0);
      
      border-radius: 25px;
      padding: 50px 40px;
      max-width: 500px;
      width: 100%;
      margin-top: 60px;
      box-shadow: 0px 0px 18px rgba(226, 43, 153, 0.6);

      position: relative;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .profile h2 {
      color: #ffc8ff;
      font-size: 2.5rem;
      margin-bottom: 30px;
      text-align: center;
      text-shadow: 0 0 10px #ff00cc;
    }

    .profile-img {
      width: 160px;
      height: 160px;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid white;
      box-shadow: 0 0 20px #ff00cc;
      margin: 0 auto 25px auto;
      display: block;
      background:transparent;
    }

    .profile p {
      font-size: 1.1rem;
      margin: 16px 0;
      color: #ffddee;
      text-align: left;
      padding: 0 10px;
    }

    .profile p strong {
      color: #ffc8ff;
      font-weight: bold;
      display: inline-block;
      width: 140px;
    }

    .burger {
      position: relative;
      float:left;
      top: 20px;
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
    <img src="logo.jpg" alt="Logo">
    <div class="brand-text">
      <h2>FutureSync</h2>
      <p>The Time is Yours!</p>
    </div>
  </div>
</header>
<br>
<div class="burger" id="burger">
    <i class="fa-solid fa-bars"></i>
  </div>

  <div class="sidebar" id="sidebar">
    <span class="close-btn" id="close-btn">&times;</span>
    <ul>&nbsp;&nbsp;&nbsp;<br>
      <img src="logo.jpg" alt="Logo" width="180" height="100"><br><br><br>
      <li><a href="http://localhost/FUTURE_SYNC/user_dashboard/dashboard.php">Home</a></li>
      <li><a href="http://localhost/FUTURE_SYNC/user_dashboard/help.php">Help</a></li>
      <li><a href="http://localhost/FUTURE_SYNC/admin_login/ad_login.php">Admin</a></li>
      <br><br><br><br><br><br><br><br><br>
      <li><a href="http://localhost/FUTURE_SYNC/user_dashboard/logout.php">Logout</a></li>
    </ul>
  </div>

  <script>
    const burger = document.getElementById('burger');
    const sidebar = document.getElementById('sidebar');
    const closeBtn = document.getElementById('close-btn');

    burger.addEventListener('click', () => {
        sidebar.classList.add('open');
        burger.classList.add('hide');
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.remove('open');
        burger.classList.remove('hide');
    });

    document.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target) && !burger.contains(e.target)) {
            sidebar.classList.remove('open');
            burger.classList.remove('hide');
        }
    });
  </script>
<div class="container">
  <div class="profile">
    <h2>Your Profile</h2>
    <img src="profile.jpeg" alt="Profile Picture" class="profile-img" /><br>
    <?php if ($user): ?>
      <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
      <p><strong>Date Of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
      <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
      <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
      <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
      <p><strong>Password:</strong> <?php echo htmlspecialchars($user['password']); ?></p>
    <?php endif; ?>

  </div>
</div>

</body>
</html>
