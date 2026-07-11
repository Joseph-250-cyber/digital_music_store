<?php
include("inc/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Validate
    if(empty($name) || empty($email) || empty($message)) {
        header("Location: contact.php?error=Name, email, and message are required");
        exit();
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?error=Invalid email address");
        exit();
    }
    
    // Insert message
    $sql = "INSERT INTO messages (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: contact.php?success=Thank you! Your message has been sent successfully.");
        exit();
    } else {
        header("Location: contact.php?error=" . mysqli_error($conn));
        exit();
    }
} else {
    header("Location: contact.php");
    exit();
}
?>