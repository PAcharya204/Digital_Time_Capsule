<?php
session_start();
include 'db.php';

// Check if admin is logged in using email
if (!isset($_SESSION['aemail'])) {
    header("Location: http://localhost/FUTURE_SYNC/admin_login/ad_login.php");
    exit();
}


// Handle delete
if (isset($_POST['delete'])) {
    $user_id = $_POST['user_id']; // Fix: this was missing in your version

    // Get user email
    $get_email_stmt = $conn->prepare("SELECT email FROM user WHERE id = ?");
    $get_email_stmt->bind_param("i", $user_id);
    $get_email_stmt->execute();
    $get_email_result = $get_email_stmt->get_result();

    if ($get_email_result->num_rows > 0) {
        $user = $get_email_result->fetch_assoc();
        $email = $user['email'];

        // Delete related capsules
        $delete_capsules_stmt = $conn->prepare("DELETE FROM capsules WHERE semail = ?");
        $delete_capsules_stmt->bind_param("s", $email);
        $delete_capsules_stmt->execute();

        // Delete user
        $delete_user_stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
        $delete_user_stmt->bind_param("i", $user_id);
        $delete_user_stmt->execute();

        echo "<script>alert('User and their capsules deleted successfully'); window.location.href='display.php';</script>";
    } else {
        echo "<script>alert('User not found');</script>";
    }

    exit;
}


$user_query = "SELECT * FROM user";
$user_result = mysqli_query($conn, $user_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>User + Capsule Info</title>
    <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      box-shadow:none;
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
      td
      {
        color: #f0e8ff;
        font-size: 16px;
        vertical-align: top;
        text-align:center;
    }

    tr:hover {
      background: rgba(255, 255, 255, 0.08);
      box-shadow: inset 0 0 15px rgba(255, 0, 255, 0.2);
    }

    h1
    {
      font-size: 52px;
      color: #ffc8ff;
      margin: 40px 0 20px;
      text-shadow: 0 0 15px #ff00ff;
    }


    #tooltip-content {
    max-height: 300px;
    overflow-y: auto;
    white-space: pre-wrap;
    padding: 10px;
    background-color: #1e1e1e;
    color: #fff;
    border: 1px solid #444;
    border-radius: 5px;
    scrollbar-width: thin;             /* Firefox */
    scrollbar-color: #888 #2e2e2e;     /* Firefox */
}

/* Chrome, Edge, Safari */
#tooltip-content::-webkit-scrollbar {
    width: 10px;
    height:auto;
}

#tooltip-content::-webkit-scrollbar-track {
    background: #2e2e2e;
    border-radius: 10px;
}

#tooltip-content::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
    border: 2px solid #2e2e2e; /* Adds spacing inside */
}

#tooltip-content::-webkit-scrollbar-thumb:hover {
    background: #aaa;
}


        .tooltip-box {
            display: none;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #1a0029, #2d0066);
            border: 5px solid #ff00ff;
            color:white;
            border-radius: 8px;
            padding: 20px;
            width: 400px;
            z-index: 1000;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        .tooltip-box h3 {
            margin-top: 0;
        }

        .tooltip-box pre {
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .tooltip-close {
            float: right;
            cursor: pointer;
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 5px;
            width: 20px;
            height: 20px;
        }
        .tooltip-close:hover
        {
          background:red;
        }

        .btn-tooltip {
            cursor: pointer;
            background: linear-gradient(135deg, #9f00ff, #ff00ff);
            text-decoration: none;
            border: none;
        }

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
            z-index: 999;
        }
        .burger {
      position: relative;
      float:left;
      top: -30px;
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

        a:hover {
      color: #ffffff;
      text-shadow: 0 0 10px #ff00ff;
      font-weight: bold;
    }
    
    button,
input[type="submit"] {
  background: linear-gradient(135deg, #9f00ff, #ff00ff);
  padding: 30px;
  width: 180px;
  height: 80px;
  color: #fff;
  border-radius: 20px;
  text-decoration: none;
  font-size: 20px;
  font-weight: bold;
  display: flex;
  align-items: center;      /* Center vertically */
  justify-content: center;  /* Center horizontally */
  text-align:center;
  box-shadow: 0 10px 30px rgba(255, 0, 255, 0.3);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}

button
{
  top:10px;
  text-align:center;
}
button:hover,
input[type="submit"]:hover {
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
  <br>
  <br>
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

<div id="overlay" onclick="closeTooltip()"></div>

<div id="tooltip" class="tooltip-box">
    <button class="tooltip-close" onclick="closeTooltip()"><i class="fa-solid fa-xmark" style="color: white;"></i>
    </button>
    <h3 id="tooltip-title">Details</h3><br>
    <pre id="tooltip-content"></pre>
</div>

<h1>Users with Capsule Details</h1><br>

<?php if (mysqli_num_rows($user_result) > 0): ?>
    <table>
        <tr>
            <th>Serial No.</th>
            <th>User Name</th>
            <th>User Details</th>
            <th>Capsule Details</th>
            <th>Delete</th>
        </tr>
        <?php
        $user_serial = 1;
        while ($user = mysqli_fetch_assoc($user_result)):
            $uid = $user['id'];
            $uname = htmlspecialchars($user['name']);
            $user_info = "DOB: " . $user['dob'] . "\nGender: " . $user['gender'] . "\nAddress: " . $user['address'] . "\nPhone: " . $user['phone'] . "\nEmail: " . $user['email'];

            $semail = $user['email'];
            $capsule_query = $conn->prepare("SELECT subject, message, rdate, remail, status FROM capsules WHERE semail = ?");
            $capsule_query->bind_param("s", $semail);
            $capsule_query->execute();
            $capsules = $capsule_query->get_result();

            $capsule_data = "";
            $capsule_serial = 1;
            if ($capsules->num_rows > 0) {
                while ($cap = $capsules->fetch_assoc()) {
                    $capsule_data .= "Capsule #$capsule_serial\n";
                    $capsule_data .= "To: " . $cap['remail'] . "\nSubject: " . $cap['subject'] . "\nMessage: " . $cap['message'] . "\nRelease: " . $cap['rdate'] . "\nStatus: " . $cap['status'] . "\n\n";
                    $capsule_serial++;
                }
            } else {
                $capsule_data = "No capsules created.";
            }
        ?>
        <tr>
            <td><?php echo $user_serial++; ?></td>
            <td><?php echo $uname; ?></td>
            <td>
                <button class="btn-tooltip" onclick="showTooltip('<?php echo $uname; ?>\'s User Details', `\n<?php echo htmlspecialchars($user_info); ?>`)">View Details</button>
            </td>
            <td>
                <button class="btn-tooltip" onclick="showTooltip('<?php echo $uname; ?>\' Capsules', `\n<?php echo htmlspecialchars($capsule_data); ?>`)">View Capsules</button>
            </td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="user_id" value="<?php echo $uid; ?>">
                    <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this user and his capsules?');">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>

<script>
function showTooltip(title, content) {
    document.getElementById('tooltip-title').innerText = title;
    document.getElementById('tooltip-content').innerText = content;
    document.getElementById('tooltip').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}

function closeTooltip() {
    document.getElementById('tooltip').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}
</script>

</body>
</html>
