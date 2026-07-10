<?php
include("inc/session.php");
include("inc/header.php");
include("inc/menu.php");
include("inc/connection.php");

// Redirect if not an artist
requireArtist();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if(!$id) {
    header("Location: index.php?error=No music ID provided");
    exit();
}

// Check if user owns this music
$check_sql = "SELECT * FROM music WHERE id = $id";
$check_result = mysqli_query($conn, $check_sql);
$row = mysqli_fetch_assoc($check_result);

if(!$row) {
    header("Location: index.php?error=Music not found");
    exit();
}

if($row['user_id'] != getUserId()) {
    header("Location: index.php?error=You don't own this music");
    exit();
}
?>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-wrapper">
    <div class="main-content">
        <h1>✏️ Edit Music</h1>
        <p class="page-intro">Update the details of this music</p>

        <?php if(isset($_GET['error'])) { ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>

        <form action="save_db.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title"><i class="fas fa-music"></i> Title:</label>
                <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>" required>
            </div>

            <div class="form-group">
                <label for="artist"><i class="fas fa-user"></i> Artist:</label>
                <input type="text" id="artist" name="artist" value="<?php echo $row['artist']; ?>" required>
            </div>

            <div class="form-group">
                <label for="genre"><i class="fas fa-tag"></i> Genre:</label>
                <select id="genre" name="genre" required>
                    <option value="">Select Genre</option>
                    <option value="Afrobeat" <?php if($row['genre'] == 'Afrobeat') echo 'selected'; ?>>Afrobeat</option>
                    <option value="Afro-pop" <?php if($row['genre'] == 'Afro-pop') echo 'selected'; ?>>Afro-pop</option>
                    <option value="Gospel" <?php if($row['genre'] == 'Gospel') echo 'selected'; ?>>Gospel</option>
                    <option value="Hip-Hop" <?php if($row['genre'] == 'Hip-Hop') echo 'selected'; ?>>Hip-Hop</option>
                    <option value="R&B" <?php if($row['genre'] == 'R&B') echo 'selected'; ?>>R&B</option>
                    <option value="Jazz" <?php if($row['genre'] == 'Jazz') echo 'selected'; ?>>Jazz</option>
                    <option value="Electronic" <?php if($row['genre'] == 'Electronic') echo 'selected'; ?>>Electronic</option>
                    <option value="Rock" <?php if($row['genre'] == 'Rock') echo 'selected'; ?>>Rock</option>
                    <option value="Compilation" <?php if($row['genre'] == 'Compilation') echo 'selected'; ?>>Compilation</option>
                    <option value="Traditional" <?php if($row['genre'] == 'Traditional') echo 'selected'; ?>>Traditional</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price"><i class="fas fa-dollar-sign"></i> Price ($):</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo $row['price']; ?>" required>
            </div>

            <div class="form-group">
                <label for="description"><i class="fas fa-align-left"></i> Description:</label>
                <textarea id="description" name="description" rows="4"><?php echo $row['description']; ?></textarea>
            </div>

            <div class="form-group">
                <?php if(!empty($row['cover_image'])) { ?>
                    <p>Current Cover: <img src="images/<?php echo $row['cover_image']; ?>" width="80" height="80" style="border-radius:8px; object-fit:cover;"></p>
                <?php } ?>
                <label for="cover_image"><i class="fas fa-image"></i> Change Cover Image:</label>
                <input type="file" id="cover_image" name="cover_image" accept="image/*">
                <p style="font-size:12px; color:#999; margin-top:5px;">Leave empty to keep current image. Allowed: JPG, PNG, GIF</p>
            </div>

            <div class="form-group">
                <label for="release_date"><i class="fas fa-calendar"></i> Release Date:</label>
                <input type="date" id="release_date" name="release_date" value="<?php echo $row['release_date']; ?>">
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Update Music</button>
        </form>

        <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Home</a>
    </div>
    <?php include("inc/sidebar.php"); ?>
</div>

<?php include("inc/footer.php"); ?>