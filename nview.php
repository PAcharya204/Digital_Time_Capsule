<!-- Make sure this is saved as a .php file and your PHP backend is working -->
<?php
session_start();
ob_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/FUTURE_SYNC/user_registration/index.php");
    exit();
}

// Ensure semail is set
if (!isset($_SESSION['semail']) || empty($_SESSION['semail'])) {
    die("Error: No sender email found in session. Please log in again.");
}

$semail = $_SESSION['semail'];

// Fetch user-created capsules securely
$query = "SELECT cid, subject, message, ffile, rdate, semail, remail, status FROM capsules WHERE semail = ? ORDER BY rdate";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $semail);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("Error in SQL query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title>Your Capsules</title>
  <script src="email_scheduler.js"></script>

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
      font-size: 52px;
      color: #ffc8ff;
      margin: 40px 0 20px;
      text-shadow: 0 0 15px #ff00ff;
    }

    .table-container {
      width: 100%;
      overflow-x: auto;
      padding: 0 10px;
    }

    table {
      border-collapse: separate;
      border-spacing: 0;
      margin: 30px auto;
      width: 95%;
      max-width: 1200px;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 0 25px rgba(255, 0, 255, 0.3);
      backdrop-filter: blur(6px);
    }

    th, td {
      padding: 15px 20px;
      text-align: left;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    th {
      background: #ff00ff;
      color: white;
      font-size: 18px;
      border: 2px solid #8a2be2;
      border-radius: 5px;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-weight: bold;
    }

    td {
      color: #f0e8ff;
      font-size: 16px;
      vertical-align: top;
    }

    tr:hover {
      background: rgba(255, 255, 255, 0.08);
      box-shadow: inset 0 0 15px rgba(255, 0, 255, 0.2);
    }

    .status {
      padding: 5px 10px;
      border-radius: 5px;
      display: inline-block;
      font-size: 14px;
      font-weight: bold;
      width:80px;
    }

    .status.sent { background: #00cc66; }
    .status.pending { background: #ffcc00; color: #000; }
    .status.failed { background: #cc0033; }

    a {
      color: #ffccff;
      text-decoration: underline;
    }

    a:hover {
      color: #ffffff;
      text-shadow: 0 0 10px #ff00ff;
      font-weight: bold;
    }

    .no-data {
      font-size: 20px;
      margin-top: 40px;
      color: #ccc;
      text-align: center;
    }

    @media screen and (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      thead {
        display: none;
      }

      tr {
        margin-bottom: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 10px;
        border-radius: 10px;
      }

      td {
        padding: 10px 10px 10px 50%;
        position: relative;
        text-align: left;
      }

      td::before {
        position: absolute;
        top: 10px;
        left: 10px;
        width: 45%;
        white-space: nowrap;
        font-weight: bold;
        color: #ffc8ff;
        content: attr(data-label);
      }
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

  <h1 class="page-title">Your Created Capsules</h1>
<br>
  <div class="table-container">
    <?php if ($result->num_rows > 0): ?>
      <table>
        <tr>
          <th>Sender</th>
          <th>Subject</th>
          <th>Message</th>
          <th>File</th>
          <th>Recipient</th>
          <th>Release Date</th>
          <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['semail']); ?></td>
            <td><?php echo htmlspecialchars($row['subject']); ?></td>
            <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
            <td>
              <?php if (!empty($row['ffile'])): ?>
                <a href="http://localhost/FUTURE_SYNC/create_capsule/uploads/<?php echo htmlspecialchars(basename($row['ffile'])); ?>" target="_blank">View File</a>
              <?php else: ?>
                N/A
              <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($row['remail']); ?></td>
            <td><?php echo htmlspecialchars($row['rdate']); ?></td>
            <td>
              <span class="status <?php echo strtolower($row['status']); ?>">
                <?php echo htmlspecialchars(ucfirst($row['status'])); ?>
              </span>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p class="no-data">You have not created any capsules yet.</p>
    <?php endif; ?>
  </div>

</body>
</html>
