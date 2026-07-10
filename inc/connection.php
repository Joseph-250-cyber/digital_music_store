<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "digital_music_store_db";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>