<?php
$servername = "localhost";
$username = "root"; // Default in XAMPP
$password = ""; // Default in XAMPP
$dbname = "future_sync";

// Create connection
$conn = new mysqli('localhost', 'root', '', 'future_sync', 3307); 


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}
?>
