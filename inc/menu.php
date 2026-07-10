<?php
include("inc/session.php");
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
            
            <?php if(isArtist()) { ?>
                <li><a href="register.php">Add Music</a></li>
            <?php } ?>
            
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="services.php">Services</a></li>
            
            <?php if(isLoggedIn()) { ?>
                <li class="user-info">
                    <span><i class="fas fa-user"></i> <?php echo getUserName(); ?> (<?php echo ucfirst(getUserRole()); ?>)</span>
                </li>
                <li><a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <?php } else { ?>
                <li><a href="login.php" class="btn-login"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                <li><a href="register_user.php" class="btn-register"><i class="fas fa-user-plus"></i> Register</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>