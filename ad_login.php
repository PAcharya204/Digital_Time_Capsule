<?php
session_start(); // Add this at the very top
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | FutureSync</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

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


    


form {
    background: rgba(8, 3, 24, 0);
    backdrop-filter: blur(12px);
      padding: 30px 40px;
      border-radius: 20px;
    width: 410px;
    margin: auto;
    box-shadow: 0px 0px 18px rgba(226, 43, 153, 0.6);
}

label {
    display: block;
    text-align: left;
    margin-top: 10px;
    color: #cccccc;
    font-weight: 600;
}

input[type="text"],
input[type="date"],
input[type="email"],
input[type="password"] {
    width: 99%;
    padding: 10px;
    margin: 8px 0;
    border: none;
    border-radius: 6px;
    background-color: #0f0f3d;
    color: #ffffff;
}

input::placeholder {
    color: #aaaaaa;
}

input[type="radio"] {
    margin: 0 5px 10px 15px;
}

.password-wrapper {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 30%;
    transform: translateY(-20%);
    font-size: 18px;
    cursor: pointer;
    color: #ccc;
}

button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(90deg, #8a2be2, #ff00ff);
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 16px;
    font-weight: bold;
    margin-top: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
}

button:hover {
    background: linear-gradient(90deg, #ff00ff, #8a2be2);
    transform: scale(1.05);
}

#si {
    margin-top: 20px;
    font-size: 14px;
    color: #cccccc;
}

#sii {
    color: #ff00ff;
    text-decoration: none;
    font-weight: bold;
}

#sii:hover {
    text-decoration: underline;
}
@media (max-width: 600px) {
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
    }


    h1 {
      font-size: 48px;
      margin-bottom: 30px;
      color: #ffc8ff;
      text-shadow: 0 0 15px #ff00ff;
      text-align: center;
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
  <br><br>
  <h1>Admin Login</h1>
  <form method="POST">
   
    <label>User ID</label><br>
    <input type="email" name="aemail" placeholder="Enter your Email"><br>
    <label>Password</label><br>
    <div class="password-wrapper">
      <input type="password" id="apassword" name="apassword" placeholder="Enter Password">
      <span class="toggle-password" onclick="togglePassword()">🔒</span>
    </div>
    <button type="submit" name="adlogin">Login</button>
  </form>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById('apassword');
      const icon = event.target;
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.textContent = '🔓';
      } else {
        passwordField.type = 'password';
        icon.textContent = '🔒';
      }
    }
  </script>

  <?php
  if (isset($_POST['adlogin'])) {
    $aemail = $_POST['aemail'];
    $apassword = $_POST['apassword'];
    $validemail = "Admin@admin.com";
    $validpassword = "abc";

    if (empty($aemail)) {
      echo "<script>alert('Enter the Username'); window.location.href='http://localhost/FUTURE_SYNC/admin_login/ad_login.php';</script>";
    } elseif (empty($apassword)) {
      echo "<script>alert('Enter the Password'); window.location.href='http://localhost/FUTURE_SYNC/admin_login/ad_login.php';</script>";
    } elseif ($aemail == $validemail && $apassword == $validpassword) {
      $_SESSION['aemail'] = $aemail;
 
      echo "<script>
        alert('You are successfully Logged in.');
        window.top.location.href = 'http://localhost/FUTURE_SYNC/admin_dashboard/ad_dashboard.html';
      </script>";
      exit();
    } else {
      echo "<script>alert('Enter proper credentials.'); window.location.href='http://localhost/FUTURE_SYNC/admin_login/ad_login.php';</script>";
    }
  }
  ?>
</body>

</html>
