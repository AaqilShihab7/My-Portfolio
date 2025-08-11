

<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to send email
function sendContactEmail($email, $name, $message) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'aaqilcr6@gmail.com'; // Replace with your email
    $mail->Password = 'yvji pxol tpqv zjsz';   // Replace with your App Password

    $mail->setFrom('aaqilcr6@gmail.com', 'Portfolio Contact'); // Replace with your email
    $mail->addAddress($email); // Send to the user's email (optional)
    $mail->isHTML(true);
    $mail->Subject = 'Thank You for Contacting Me';
    $mail->Body = "<p>Hi <b>$name</b>,</p><p>Thank you for your message!</p><p>Your Message: $message</p>";

    return $mail->send();
}

// Collect form data
$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$message = mysqli_real_escape_string($con, $_POST['message']);

// Validate fields
if (empty($name) || empty($email) || empty($message)) {
    echo '<script>alert("All fields are required."); window.history.back();</script>';
    exit();
}

// Insert message into the database
$sql = "INSERT INTO `messages` (`name`, `email`, `message`, `created_at`) 
        VALUES ('$name', '$email', '$message', NOW())";

if (mysqli_query($con, $sql)) {
    // Send confirmation email
    if (sendContactEmail($email, $name, $message)) {
        echo '<script>alert("Message sent successfully!"); window.location.href = "success.html";</script>';
    } else {
        echo '<script>alert("Message saved, but failed to send confirmation email."); window.location.href = "thank-you.html";</script>';
    }
} else {
    echo '<script>alert("Failed to save your message. Please try again later."); window.history.back();</script>';
}

mysqli_close($con);
?>

