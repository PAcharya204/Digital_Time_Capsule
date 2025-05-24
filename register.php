<?php
session_start();
include('db.php'); // Replace with your actual DB connection file

if (isset($_POST['register'])) 
{
    $errors = [];

    // Name validation
    if (preg_match("/^[a-zA-Z\s]+$/", $_POST['name'])) {
        $name = trim($_POST['name']);
    } else {
        $errors[] = "Enter a valid name (letters and spaces only).";
    }

    // DOB validation
    $dob = trim($_POST['dob']);
if (empty($dob)) {
    $errors[] = "Date of birth is required.";
} elseif (strtotime($dob) >= strtotime(date('Y-m-d'))) {
    $errors[] = "Date of birth must be in the past.";
}


    // Gender validation
    $gender = $_POST['gender'];
    if (!in_array($gender, ['Male', 'Female', 'Other'])) {
        $errors[] = "Select a valid gender.";
    }

    // Address validation
    $address = trim($_POST['address']);
    if (empty($address)) {
        $errors[] = "Address is required.";
    }

    // Phone number validation
    $phone = trim($_POST['phone']);
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
    $errors[] = "Enter a valid 10-digit phone number.";
    }


    // Email validation
    $email = trim($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    // Password validation
    $password = $_POST['password'];
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Show first error and redirect
    if (!empty($errors)) {
        $firstError = addslashes($errors[0]); // Escape quotes for JS
        echo "<script>
            alert('$firstError');
            setTimeout(function() {
                window.location.href='index.php';
            }, 100);
        </script>";
        exit();
    }

    // Check if email already exists
    $check = "SELECT email FROM user WHERE email='$email'";
    $check_run = mysqli_query($conn, $check);

    if (mysqli_num_rows($check_run) > 0) {
        echo "<script>
            alert('Email ID already exists!');
            window.location.href='index.php';
        </script>";
        exit();
    }

    // Hash password
    

    // Insert new user into pending_users
    $query = "INSERT INTO pending_users (name, dob, gender, address, phone, email, password) 
              VALUES ('$name', '$dob', '$gender', '$address', '$phone', '$email', '$password')";

    if (mysqli_query($conn, $query)) {
        echo "<script>
            alert('Request sent for admin approval.');
            window.location.href='wait.php';
        </script>";
    } else {
        echo "<script>
            alert('Request sending failed. Try again.');
            window.location.href='index.php';
        </script>";
    }
}
?>
