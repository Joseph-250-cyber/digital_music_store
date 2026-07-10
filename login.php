<?php
include("inc/header.php");
include("inc/menu.php");
?>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-wrapper">
    <div class="main-content" style="max-width:500px; margin:0 auto;">
        <h1 style="text-align:center;">🔐 Login</h1>
        <p class="page-intro" style="text-align:center;">Welcome back! Login to your account.</p>

        <?php if(isset($_GET['error'])) { ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>

        <form action="login_process.php" method="post">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <label style="font-size:14px; color:#4a5d72;">
                    <input type="checkbox" name="remember"> Remember Me
                </label>
                <a href="#" style="color:#0e7c7b; font-size:14px;">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-submit" style="width:100%;"><i class="fas fa-sign-in-alt"></i> Login</button>
        </form>

        <p class="form-footer" style="text-align:center; margin-top:20px;">
            Don't have an account? <a href="register_user.php">Register here</a>
        </p>
    </div>
</div>

<?php include("inc/footer.php"); ?>