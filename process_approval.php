<?php
session_start(); 
 // Start the session to store messages
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    if (isset($_POST['approve'])) 
    {
        // Move user from pending_users to users table
        $query = "INSERT INTO user (name,dob, gender, address, email, phone, password)
                  SELECT name,dob, gender, address, email, phone, password FROM pending_users WHERE id = '$id'";
        
        if (mysqli_query($conn, $query)) 
        {
            // Delete from pending_users after successful approval

            mysqli_query($conn, "DELETE FROM pending_users WHERE id = '$id'");
            header("Location: notification.php");
            $_SESSION['message'] = "Your request has been approved. You can now log in.";
            
            exit();

        } 
        else 
        {
            echo "<script>alert('Error approving user: " . mysqli_error($conn) . "');</script>";
        }
    } 
    
    elseif (isset($_POST['reject'])) 
    {
        // Simply delete from pending_users
        if (mysqli_query($conn, "DELETE FROM pending_users WHERE id = '$id'")) 
        {

            $_SESSION['message'] = "Your request has been denied.Try again.";
            header("Location: notification.php");
            exit();
        } 
        else 
        {
            echo "<script>alert('Error rejecting user: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>
