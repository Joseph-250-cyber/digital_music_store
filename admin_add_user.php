<?php
require_once("inc/session.php");
require_once("inc/header.php");
require_once("inc/menu.php");
require_once("inc/connection.php");

requireAdmin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    // Validate
    if(empty($name) || empty($email) || empty($password)) {
        header("Location: admin_add_user.php?error=All fields are required");
        exit();
    }
    
    if(strlen($password) < 6) {
        header("Location: admin_add_user.php?error=Password must be at least 6 characters");
        exit();
    }
    
    // Check if email already exists
    $check_sql = "SELECT id FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if(mysqli_num_rows($check_result) > 0) {
        header("Location: admin_add_user.php?error=Email already registered");
        exit();
    }
    
    // Hash password and insert
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password, role, status) 
            VALUES ('$name', '$email', '$hashed_password', '$role', 'active')";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: admin_users.php?success=User added successfully");
        exit();
    } else {
        header("Location: admin_add_user.php?error=" . mysqli_error($conn));
        exit();
    }
}
?>

<div class="main-wrapper">
    <div class="main-content" style="max-width:550px; margin:0 auto;">
        <h1>👤 Add New User</h1>
        <p class="page-intro">Create a new user account.</p>

        <?php if(isset($_GET['error'])) { ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>

        <form method="post">
            <div class="form-group">
                <label><i class="fas fa-user"></i> Full Name:</label>
                <input type="text" name="name" placeholder="Enter full name" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" name="email" placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password:</label>
                <input type="password" name="password" placeholder="Create password (min 6 chars)" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-user-tag"></i> Role:</label>
                <select name="role" required>
                    <option value="listener">🎧 Listener</option>
                    <option value="artist">🎤 Artist</option>
                    <option value="admin">👑 Admin</option>
                </select>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-user-plus"></i> Create User</button>
        </form>

        <a href="admin_users.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Users</a>
    </div>
    <?php include("inc/sidebar.php"); ?>
</div>

<?php include("inc/footer.php"); ?>