<?php
require_once("inc/session.php");
require_once("inc/connection.php");

requireAdmin();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if(!$id) {
    header("Location: admin_music.php?error=No music ID provided");
    exit();
}

// Check if music exists
$check_sql = "SELECT id FROM music WHERE id = $id";
$check_result = mysqli_query($conn, $check_sql);

if(mysqli_num_rows($check_result) == 0) {
    header("Location: admin_music.php?error=Music not found");
    exit();
}

// Block music
$sql = "UPDATE music SET status = 'blocked' WHERE id = $id";

if(mysqli_query($conn, $sql)) {
    header("Location: admin_music.php?success=Music blocked successfully");
    exit();
} else {
    header("Location: admin_music.php?error=" . mysqli_error($conn));
    exit();
}
?>