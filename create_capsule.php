<?php
session_start();
ob_start();
include 'db.php';

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title>Write a Letter to Your Future Self</title>
  <script src="email_scheduler.js"></script>
  <link rel="stylesheet" href="styles.css"/>
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
      padding: 40px 20px;
    }

    h1 {
      font-size: 48px;
      margin-bottom: 30px;
      color: #ffc8ff;
      text-shadow: 0 0 15px #ff00ff;
      text-align: center;
    }

    form {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(12px);
      padding: 30px 40px;
      border-radius: 20px;
      width: 100%;
      max-width: 900px;
      border: 2px solid white;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .form-container {
      display: flex;
      justify-content: space-between;
      gap: 30px;
      flex-wrap: wrap;
    }

    .left-column,
    .right-column {
      flex: 1 1 45%;
      display: flex;
      flex-direction: column;
    }

    label {
      font-weight: bold;
      margin-top: 10px;
      color: #ffcaff;
      text-shadow: 0 0 5px rgba(255, 255, 255, 0.1);
    }

    input, textarea, select {
      width: 100%;
      padding: 12px 14px;
      border-radius: 10px;
      border: none;
      background: #f8f1fa;
      color: #1a0029;
      font-size: 16px;
    }

    input[type="file"] {
      background: #fff;
    }

    input::placeholder,
    textarea::placeholder {
      color: #777;
    }

    textarea {
      min-height: 150px;
      resize: vertical;
    }

    button {
      margin-top: 25px;
      background: linear-gradient(135deg, #9f00ff, #ff00ff);
      color: white;
      border: none;
      padding: 12px;
      font-size: 18px;
      font-weight: bold;
      border-radius: 10px;
      cursor: pointer;
      box-shadow: 0 5px 20px rgba(255, 0, 255, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    button:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 35px rgba(255, 0, 255, 0.5);
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 32px;
      }

      form {
        padding: 20px;
      }

      .form-container {
        flex-direction: column;
      }
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
      margin-top: -20px;
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
      <li><a href="http://localhost/FUTURE_SYNC/admin_dashboard/ad_logout.php">Logout</a></li>
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

  <h1>Create your Time Capsule</h1><br>

  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-container">
      <!-- Left Side (Subject + Message) -->
      <div class="left-column">
        <label>Subject</label><br>
        <input type="text" name="subject" id="subject" placeholder="Enter Subject line" required/><br>

        <label>Message</label><br>
        <textarea name="message" id="message" rows="13" placeholder="Dear FutureMe," required></textarea><br>
      </div>

      <!-- Right Side (File, Date, Emails) -->
      <div class="right-column">
        
        <label>Upload a File (Optional)</label><br>
        <input type="file" name="ffile" id="ffile" accept=".pdf,.doc,.docx,.xlsx,.txt,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.wmv"/><br>

        <label for="rdate">Choose a delivery date:</label><br>
        <input type="datetime-local" id="rdate" name="rdate" min="<?= date('Y-m-d\TH:i') ?>" required><br>


        <label>Sender Email:</label>
        <p style='color:red';>*Must be same as Login email</p><br>
        <input type="email" id="semail" name="semail" placeholder="Enter your Login Email ID" required/><br>

        <label>Recipient Email:</label><br>
        <input type="email" id="remail" name="remail" placeholder="Enter Recipient email" required/><br>
      </div>
    </div>

    <button type="submit" name="send">Send to the Future</button>
  </form>

  <?php
  include 'db.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $subject = htmlspecialchars($_POST["subject"]);
      $message = htmlspecialchars($_POST["message"]);
      $rdate = $_POST["rdate"];
      $semail= filter_var($_POST["semail"], FILTER_SANITIZE_EMAIL);
      $remail = filter_var($_POST["remail"], FILTER_SANITIZE_EMAIL);
      
      $targetDir = "uploads/";
      if (!is_dir($targetDir)) {
          mkdir($targetDir, 0777, true);
      }

      function uploadFile($file, $allowedTypes) {
    global $targetDir;

    if (!isset($file) || $file["error"] === UPLOAD_ERR_NO_FILE) {
        return ""; // No file uploaded
    }

    if ($file["error"] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Upload failed with error code: " . $file["error"] . "');</script>";
        exit();
    }

    $fileName = time() . "_" . basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $targetFilePath;
        } else {
            echo "<script>alert('Error moving uploaded file.');</script>";
            exit();
        }
    } else {
        echo "<script>alert('Invalid file format: " . htmlspecialchars($file["name"]) . "');</script>";
        exit();
    }
}


      $allowedTypes = ["pdf", "doc", "docx", "xlsx", "txt", "jpg", "jpeg", "png", "gif", "mp4", "avi", "mov", "wmv"];

      $ffile = uploadFile($_FILES["ffile"], $allowedTypes);

      $stmt = $conn->prepare("INSERT INTO capsules (subject, message, ffile, rdate, semail, remail, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
      $stmt->bind_param("ssssss", $subject, $message, $ffile, $rdate, $semail, $remail);

      if ($stmt->execute()) {
          echo "<script>alert('Successfully scheduled for future delivery.');</script>";
      } else {
          echo "<script>alert('Database error.');</script>";
      }
  }
  ?>

</body>
</html>
