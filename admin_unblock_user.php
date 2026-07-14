<?php
require_once("inc/session.php");
require_once("inc/connection.php");

requireAdmin();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if(!$id) {
    header("Location: admin_users.php?error=No user ID provided");
    exit();
}

// Unblock user
$sql = "UPDATE users SET status = 'active' WHERE id = $id";

if(mysqli_query($conn, $sql)) {
    header("Location: admin_users.php?success=User unblocked successfully");
    exit();
} else {
    header("Location: admin_users.php?error=" . mysqli_error($conn));
    exit();
}
?>