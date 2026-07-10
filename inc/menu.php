<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
?>

<!-- ===== MAIN NAVIGATION ===== -->
<nav class="main-nav">
    <div class="container">
        <a href="index.php" class="logo">
            <span class="logo-icon">🎵</span>
            <span class="logo-text">Music Store</span>
        </a>
        <ul class="nav-menu">
            <li><a href="index.php">Home</a></li>
            
            <?php if($is_logged_in && $user_role == 'artist') { ?>
                <li><a href="register.php">Add Music</a></li>
            <?php } ?>
            
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="services.php">Services</a></li>
            
            <?php if($is_logged_in) { ?>
                <li class="user-info">
                    <span><i class="fas fa-user"></i> <?php echo $user_name; ?> (<?php echo ucfirst($user_role); ?>)</span>
                </li>
                <li><a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <?php } else { ?>
                <li><a href="login.php" class="btn-login"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                <li><a href="register_user.php" class="btn-register"><i class="fas fa-user-plus"></i> Register</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>