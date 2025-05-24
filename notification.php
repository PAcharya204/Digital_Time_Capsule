<?php
session_start();
include 'db.php';

// Check if admin is logged in using email
if (!isset($_SESSION['aemail'])) {
    header("Location: http://localhost/FUTURE_SYNC/admin_login/ad_login.php");
    exit();
}
 // Ensure this connects to your database

// Fetch pending approval requests
$query = "SELECT id, name, dob, gender, address, phone, email FROM pending_users";
$result = mysqli_query($conn, $query);

$notifications = []; //array created to store the user request in row wise manner

if ($result) { //if query is executed
    while ($row = mysqli_fetch_assoc($result)) {  //user data is fetched and store row wise
        $notifications[] = $row; // data stored in notification array
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title>Admin Notifications</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    th,
    td {
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
      width: 80px;
    }

    .status.sent {
      background: #00cc66;
    }

    .status.pending {
      background: #ffcc00;
      color: #000;
    }

    .status.failed {
      background: #cc0033;
    }

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

      table,
      thead,
      tbody,
      th,
      td,
      tr {
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
      position: fixed;
      top: 180px;
      left: 30px;
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
      top: 10px;
      ;
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
    
    .but {
      display: flex;
  flex-direction: row;
  gap: 10px; /* space between buttons */
    }

  button {
  background: linear-gradient(135deg, #9f00ff, #ff00ff);
  padding: 10px 20px;
  color: #fff;
  border-radius: 10px;
  font-size: 20px;
  font-weight: bold;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 10px 30px rgba(255, 0, 255, 0.3);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  cursor: pointer;
}


    button:hover {
      transform: scale(1.1);
      box-shadow: 0 15px 45px rgba(255, 0, 255, 0.5);
      background: linear-gradient(135deg, #ff00ff, #9f00ff);
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
      <li><a href="http://localhost/FUTURE_SYNC/admin_dashboard/ad_dashboard.html">Home</a></li>
      <li><a href="http://localhost/FUTURE_SYNC/admin_login/ad_login.php">Admin Login</a></li>
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
  <br><br>
  <h2>Pending Approval Requests</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>DOB</th>
        <th>Gender</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($notifications) > 0): ?> <!-- if notification have any row -->
      <?php foreach ($notifications as $notification): ?> <!-- all row of notification is saved in notifications -->
      <tr>
        <td>
          <?php echo htmlspecialchars($notification['id']); ?>
        </td>
        <td>
          <?php echo htmlspecialchars($notification['name']); ?>
        </td>
        <td>
          <?php echo $notification['dob']; ?>
        </td>
        <td>
          <?php echo htmlspecialchars($notification['gender']); ?>
        </td>
        <td>
          <?php echo htmlspecialchars($notification['address']); ?>
        </td>
        <td>
          <?php echo htmlspecialchars($notification['phone']); ?>
        </td>
        <td>
          <?php echo htmlspecialchars($notification['email']); ?>
        </td>

        <td class="but">
        <div class="but">
          <form method="POST" action="process_approval.php">
            <input type="hidden" name="id" value="<?php echo $notification['id']; ?>">
            <button type="submit" name="approve" class="approve">Approve</button>
          </form>
          <form method="POST" action="process_approval.php">
            <input type="hidden" name="id" value="<?php echo $notification['id']; ?>">
            <button type="submit" name="reject" class="reject">Reject</button>
          </form>
        </div>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php else: ?>
      <tr>
        <td colspan="4">No pending approvals.</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>

</body>

</html>