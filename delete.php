<?php
require_once("inc/session.php");
require_once("inc/connection.php");

// Redirect if not logged in
requireLogin();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if(!$id) {
    header("Location: index.php?error=No music ID provided");
    exit();
}

// Check if user owns this music
$check_sql = "SELECT user_id FROM music WHERE id = $id";
$check_result = mysqli_query($conn, $check_sql);
$check_row = mysqli_fetch_assoc($check_result);

if(!$check_row) {
    header("Location: index.php?error=Music not found");
    exit();
}

// ============================================================
// ADMIN CAN DELETE ANY MUSIC, OTHERS ONLY THEIR OWN
// ============================================================
if(!isAdmin() && $check_row['user_id'] != getUserId()) {
    header("Location: index.php?error=You don't own this music");
    exit();
}

// Delete the music
$sql = "DELETE FROM music WHERE id = $id";

if(mysqli_query($conn, $sql)) {
    header("Location: index.php?success=Music deleted successfully");
    exit();
} else {
    header("Location: index.php?error=" . mysqli_error($conn));
    exit();
}
?>