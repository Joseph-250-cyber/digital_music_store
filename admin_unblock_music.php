<?php
require_once("inc/session.php");
require_once("inc/connection.php");

requireAdmin();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if(!$id) {
    header("Location: admin_music.php?error=No music ID provided");
    exit();
}

// Unblock music
$sql = "UPDATE music SET status = 'active' WHERE id = $id";

if(mysqli_query($conn, $sql)) {
    header("Location: admin_music.php?success=Music unblocked successfully");
    exit();
} else {
    header("Location: admin_music.php?error=" . mysqli_error($conn));
    exit();
}
?>