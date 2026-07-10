<?php
include("inc/session.php");
include("inc/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    // Validate
    if(empty($name) || empty($email) || empty($password)) {
        header("Location: register_user.php?error=All fields are required");
        exit();
    }
    
    if(strlen($password) < 6) {
        header("Location: register_user.php?error=Password must be at least 6 characters");
        exit();
    }
    
    // Check if email already exists
    $check_sql = "SELECT id FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if(mysqli_num_rows($check_result) > 0) {
        header("Location: register_user.php?error=Email already registered");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user
    $sql = "INSERT INTO users (name, email, password, role) 
            VALUES ('$name', '$email', '$hashed_password', '$role')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: login.php?success=Account created successfully! Please login.");
        exit();
    } else {
        header("Location: register_user.php?error=" . mysqli_error($conn));
        exit();
    }
} else {
    header("Location: register_user.php");
    exit();
}
?>