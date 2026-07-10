<?php
include("inc/header.php");
include("inc/menu.php");

session_start();

// Check if user is logged in and is an artist
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != 'artist') {
    header("Location: index.php?error=Only artists can add music");
    exit();
}
?>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-wrapper">
    <div class="main-content">
        <h1>🎵 Add New Music</h1>
        <p class="page-intro">Enter the details of the new music track or album</p>

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

        <form action="save_db.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title"><i class="fas fa-music"></i> Title:</label>
                <input type="text" id="title" name="title" placeholder="Enter music title" required>
            </div>

            <div class="form-group">
                <label for="artist"><i class="fas fa-user"></i> Artist:</label>
                <input type="text" id="artist" name="artist" placeholder="Enter artist name" required>
            </div>

            <div class="form-group">
                <label for="genre"><i class="fas fa-tag"></i> Genre:</label>
                <select id="genre" name="genre" required>
                    <option value="">Select Genre</option>
                    <option value="Afrobeat">Afrobeat</option>
                    <option value="Afro-pop">Afro-pop</option>
                    <option value="Gospel">Gospel</option>
                    <option value="Hip-Hop">Hip-Hop</option>
                    <option value="R&B">R&B</option>
                    <option value="Jazz">Jazz</option>
                    <option value="Electronic">Electronic</option>
                    <option value="Rock">Rock</option>
                    <option value="Compilation">Compilation</option>
                    <option value="Traditional">Traditional</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price"><i class="fas fa-dollar-sign"></i> Price ($):</label>
                <input type="number" id="price" name="price" step="0.01" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label for="description"><i class="fas fa-align-left"></i> Description:</label>
                <textarea id="description" name="description" rows="4" placeholder="Brief description of the music"></textarea>
            </div>

            <div class="form-group">
                <label for="cover_image"><i class="fas fa-image"></i> Cover Image:</label>
                <input type="file" id="cover_image" name="cover_image" accept="image/*">
                <p style="font-size:12px; color:#999; margin-top:5px;">Allowed: JPG, PNG, GIF (Max 5MB)</p>
            </div>

            <div class="form-group">
                <label for="release_date"><i class="fas fa-calendar"></i> Release Date:</label>
                <input type="date" id="release_date" name="release_date">
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-plus"></i> Add Music</button>
        </form>
    </div>
    <?php include("inc/sidebar.php"); ?>
</div>

<?php include("inc/footer.php"); ?>