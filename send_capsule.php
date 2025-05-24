


<?php
include 'db.php';
require 'vendor/autoload.php';
require 'config.php'; // Load SMTP credentials at the start

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json'); // Return JSON response

$mail = new PHPMailer(true);
$emails_sent = 0;

try {
    // SMTP Configuration (Only Initialize Once)
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;  // Secure credentials
    $mail->Password = SMTP_PASSWORD;  
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    $mail->Port = 465;
    $mail->setFrom('poojithaacharya04@gmail.com', 'FutureSync');
    
    // Fetch all capsules where delivery date has passed
    $sql = "SELECT * FROM capsules WHERE rdate <= NOW() AND status = 'pending'";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        try {
            $mail->clearAddresses();
            $mail->clearAttachments();
            
            $mail->addAddress($row["remail"]);
            $mail->Subject = $row["subject"];
            $mail->Body = $row["message"];
            

            // Attach Other File
            if (!empty($row["ffile"])) {
            $mail->addAttachment($row["ffile"]);
            }

            // Send Email
            $mail->send();


            // Mark email as sent
            $updateSQL = "UPDATE capsules SET status = 'sent' WHERE cid = ?";
            $updateStmt = $conn->prepare($updateSQL);
            $updateStmt->bind_param("i", $row["cid"]);
            $updateStmt->execute();

            $emails_sent++;

        } catch (Exception $e) {
            error_log("Email error: " . $mail->ErrorInfo);
        }
    }
    
    echo json_encode(["status" => "success", "emails_sent" => $emails_sent]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "SMTP Error: " . $e->getMessage()]);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="email_scheduler.js"></script>
    <title>Document</title>
</head>

<body>

</body>

</html>