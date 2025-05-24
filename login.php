<?php
session_start(); // Start session at the top
include ('db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let closeBtn = document.getElementById("closeRegisterModal");
        let modal = document.getElementById("registerModal");

        if (closeBtn && modal) {
            console.log("Close button and modal found"); // Debugging log

            closeBtn.addEventListener("click", function () {
                console.log("Close button clicked"); // Debugging log
                modal.style.display = "none"; // Hide modal
                modal.style.opacity = "0"; // Smooth transition
                modal.style.visibility = "hidden";
            });
        } else {
            console.error("Close button or modal not found!");
        }
    });

    // Show modal after 5 seconds
    setTimeout(function () {
        let modal = document.getElementById("registerModal");
        if (modal) {
            modal.style.display = "flex";
            modal.style.opacity = "1";
            modal.style.visibility = "visible";
            console.log("Modal should now be visible.");
        } else {
            console.error("Modal element not found!");
        }
    }, 2000);
</script>

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
      <img src="logo.jpg" alt="Logo" />
      <div class="brand-text">
        <h2>FutureSync</h2>
        <p>The Time is Yours!</p>
      </div>
    </div>


        
</header>

<body>
    <div class="login">
    <h1>Login</h1>
        
            <form action="" method="POST">
            
        <br>
            <label>User ID</label><br>
            <input type="email" name="email" Placeholder="Enter your Email" required><br><br>
            <div class="password-wrapper">
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <span class="toggle-password" onclick="togglePassword()">🔒</span>
    </div>
            <label>Captcha</label><br>
            <input type="text" name="captcha1" id="captcha1" readonly><input type="text" name="ecaptcha1" id="ecaptcha1"
                placeholder="Enter Captcha" required><br><br>
            <button type="submit" name="login">Login</button><br>
            <center><p id="si">Dont have an Account? <a id="sii"
                    href="http://localhost/FUTURE_SYNC/user_registration/index.php">Registration</a></p></center>
        </form>
        <script>
            const captcha1 = document.getElementById("captcha1");
            const ecaptcha1 = document.getElementById("ecaptcha1");
            const length = 5;
            const uc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            const lc = "abcdefghijklmnopqrstuvwxyz";
            const num = "1234567890";
            const cap = uc + lc + num;

            window.onload = function () {
                getcap();
            };
            function getcap() {
                let captchaText = ""; // Temporary variable
                for (let i = 0; i < length; i++) {
                    captchaText += cap[Math.floor(Math.random() * cap.length)];
                }
                captcha1.value = captchaText; // Assign to input field
            }

            function concap() {

                if (ecaptcha1.value == captcha1.value) {
                    if (ecaptcha1.value == "" && captcha1.value == "") {
                        alert("Generate catptcha 1st");
                    }
                    else {
                        alert("Captcha submitted");
                    }
                }
                else {
                    alert("Enter correct Captcha");
                    captcha1.value = "";
                }
            }

        </script>
    </div>
    <?php


if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ecaptcha1 = $_POST['ecaptcha1']; 
    $captcha1 = $_POST['captcha1']; 

    // Check if CAPTCHA is correct
    if ($ecaptcha1 != $captcha1) {
        echo "<script>
                alert('Incorrect CAPTCHA. Please try again.');
                window.location.href = 'login.php';
              </script>";
        exit();
    }

    // Fetch user details from database
    $query = "SELECT id, name, email, phone, password FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && $password == $user['password']) {  // Compare passwords (assuming plaintext)
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        $_SESSION['semail'] = $user['email']; 
        echo "<script>
                alert('You are successfully logged in');
                window.top.location= 'http://localhost/FUTURE_SYNC/user_dashboard/dashboard.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Invalid email or password. Please try again.');
                window.location.href = 'login.php';
              </script>";
        exit();
    }
}
?>


<script>
        setTimeout(function () {
            let modal = document.getElementById("registerModal");
            console.log("Modal Element:", modal); // Debugging statement

            if (modal) {
                modal.style.display = "flex"; // Show modal
                modal.style.opacity = "1"; // Ensure visibility
                modal.style.visibility = "visible"; // Ensure visibility
                console.log("Modal should now be visible.");
            } else {
                console.error("Modal element not found!");
            }
        }, 2000);
    </script>
     <script>
    function togglePassword() {
      const passwordField = document.getElementById('password');
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
</body>

</html>