<?php
include("inc/session.php");
include("inc/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    // Check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verify password
        if(password_verify($password, $row['password'])) {
            // Use the loginUser function from session.php
            loginUser($row['id'], $row['name'], $row['email'], $row['role']);
            
            header("Location: index.php?success=Welcome back, " . $row['name'] . "!");
            exit();
        } else {
            header("Location: login.php?error=Invalid password");
            exit();
        }
                // After verifying password
        if(password_verify($password, $row['password'])) {
            
            // ============================================================
            // CHECK IF USER IS BLOCKED
            // ============================================================
            if($row['status'] == 'blocked') {
                header("Location: login.php?error=Your account has been blocked. Please contact admin.");
                exit();
            }
            
            // Login successful
            loginUser($row['id'], $row['name'], $row['email'], $row['role']);
            header("Location: index.php?success=Welcome back, " . $row['name'] . "!");
            exit();
        }
    } else {
        header("Location: login.php?error=Email not found");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>