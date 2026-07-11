<?php
include("inc/session.php");
include("inc/header.php");
include("inc/menu.php");
?>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-wrapper">
    <div class="main-content" style="max-width:550px; margin:0 auto;">
        <h1>📝 Create Account</h1>
        <p class="page-intro">Join the Digital Music Store community.</p>

        <?php if(isset($_GET['error'])) { ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>

        <?php if(isset($_GET['success'])) { ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> <?php echo $_GET['success']; ?>
            </div>
        <?php } ?>

        <form action="save_user.php" method="post">
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password:</label>
                <input type="password" id="password" name="password" placeholder="Create a password (min 6 characters)" required>
            </div>

            <div class="form-group">
                <label for="role"><i class="fas fa-user-tag"></i> I want to be a:</label>
                <select id="role" name="role" required>
                    <option value="listener">🎧 Listener (Browse music)</option>
                    <option value="artist">🎤 Artist (Add & manage music)</option>
                </select>
                <p style="font-size:12px; color:#999; margin-top:5px;">Admin accounts are created by system administrators.</p>
            </div>

            <button type="submit" class="btn-submit" style="width:100%;"><i class="fas fa-user-plus"></i> Create Account</button>
        </form>

        <p class="form-footer" style="text-align:center; margin-top:20px;">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>
</div>

<?php include("inc/footer.php"); ?>