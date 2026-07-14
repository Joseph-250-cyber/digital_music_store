<?php
require_once("inc/session.php");
require_once("inc/connection.php");

requireAdmin();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if(!$id) {
    header("Location: admin_users.php?error=No user ID provided");
    exit();
}

// Don't allow blocking yourself
if($id == getUserId()) {
    header("Location: admin_users.php?error=You cannot block yourself");
    exit();
}

// Check if user exists
$check_sql = "SELECT role FROM users WHERE id = $id";
$check_result = mysqli_query($conn, $check_sql);
$check_row = mysqli_fetch_assoc($check_result);

if(!$check_row) {
    header("Location: admin_users.php?error=User not found");
    exit();
}

// Don't allow blocking other admins
if($check_row['role'] == 'admin') {
    header("Location: admin_users.php?error=Cannot block another admin");
    exit();
}

// Block user
$sql = "UPDATE users SET status = 'blocked' WHERE id = $id";

if(mysqli_query($conn, $sql)) {
    header("Location: admin_users.php?success=User blocked successfully");
    exit();
} else {
    header("Location: admin_users.php?error=" . mysqli_error($conn));
    exit();
}
?>