<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$message = isset($_SESSION['message']) ? $_SESSION['message'] : ''; 
unset($_SESSION['message']); // Prevent duplicate alerts
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <meta http-equiv="Content-Security-Policy" content="default-src 'self' 'unsafe-inline'">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="2">
    <title>Wait for Approval</title>
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
        
      padding: 20px;
      overflow-x: hidden;
    }
    h1
    {
        font-size: 28px;
      margin-bottom: 30px;
      color: #ffc8ff;
      text-shadow: 0 0 15px #ff00ff;
      text-align: center;
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
  <br><br><br><br>
<h1>Your request has been sent for admin approval.<br><br>Please wait while the admin verifies your account.</h1>



<?php if (!empty($message)): ?>

<script>
    alert("<?php echo $message; ?>");
</script>

<?php if ($message == "Your request has been approved. You can now log in.") : ?>
  <center><h2 style="color: green;">You are approved</h2></center>
    <!-- Redirect to dashboard after 2 seconds -->
    <script>
        setTimeout(function () {
            window.location.href = "http://localhost/FUTURE_SYNC/user_dashboard/dashboard.php";
        }, 2000);
    </script>

<?php elseif ($message == "Your request has been denied.Try again.") : ?>
    <center><h2 style="color: red;">You are not approved</h2></center>
    <script>
        console.log("Redirecting to index.php...");
        setTimeout(function () {
            window.location.href = "http://localhost/FUTURE_SYNC/user_registration/index.php";
        }, 2000);
    </script>

<?php endif; ?>

<?php 
// Now clear the session message AFTER JavaScript has executed
unset($_SESSION['message']);
?>

<?php endif; ?>


</body>
</html>