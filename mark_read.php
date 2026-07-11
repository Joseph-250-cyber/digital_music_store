<?php
require_once("inc/session.php");
require_once("inc/connection.php");

// ONLY ADMIN CAN MARK MESSAGES AS READ
requireAdmin();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if(!$id) {
    header("Location: view_messages.php?error=No message ID provided");
    exit();
}

// Update message status to 'read'
$sql = "UPDATE messages SET status = 'read' WHERE id = $id";

if(mysqli_query($conn, $sql)) {
    header("Location: view_messages.php?success=Message marked as read");
    exit();
} else {
    header("Location: view_messages.php?error=" . mysqli_error($conn));
    exit();
}
?>