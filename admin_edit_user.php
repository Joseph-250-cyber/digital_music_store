<?php
require_once("inc/session.php");
require_once("inc/header.php");
require_once("inc/menu.php");
require_once("inc/connection.php");

requireAdmin();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if(!$id) {
    header("Location: admin_users.php?error=No user ID provided");
    exit();
}

// Get user data
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(!$row) {
    header("Location: admin_users.php?error=User not found");
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = $_POST['password'];
    
    // Check if email already exists (except current user)
    $check_sql = "SELECT id FROM users WHERE email = '$email' AND id != $id";
    $check_result = mysqli_query($conn, $check_sql);
    
    if(mysqli_num_rows($check_result) > 0) {
        header("Location: admin_edit_user.php?id=$id&error=Email already in use");
        exit();
    }
    
    // Build update query
    if(!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET name='$name', email='$email', role='$role', password='$hashed_password' WHERE id=$id";
    } else {
        $sql = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id=$id";
    }
    
    if(mysqli_query($conn, $sql)) {
        header("Location: admin_users.php?success=User updated successfully");
        exit();
    } else {
        header("Location: admin_edit_user.php?id=$id&error=" . mysqli_error($conn));
        exit();
    }
}
?>

<div class="main-wrapper">
    <div class="main-content" style="max-width:550px; margin:0 auto;">
        <h1>✏️ Edit User</h1>
        <p class="page-intro">Update user details.</p>

        <?php if(isset($_GET['error'])) { ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>

        <form method="post">
            <div class="form-group">
                <label><i class="fas fa-user"></i> Name:</label>
                <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-user-tag"></i> Role:</label>
                <select name="role" required>
                    <option value="listener" <?php if($row['role'] == 'listener') echo 'selected'; ?>>🎧 Listener</option>
                    <option value="artist" <?php if($row['role'] == 'artist') echo 'selected'; ?>>🎤 Artist</option>
                    <option value="admin" <?php if($row['role'] == 'admin') echo 'selected'; ?>>👑 Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fas fa-lock"></i> New Password:</label>
                <input type="password" name="password" placeholder="Leave blank to keep current">
                <p style="font-size:12px; color:#999; margin-top:5px;">Leave empty to keep current password.</p>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Update User</button>
        </form>

        <a href="admin_users.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Users</a>
    </div>
    <?php include("inc/sidebar.php"); ?>
</div>

<?php include("inc/footer.php"); ?>