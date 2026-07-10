<?php
include("inc/header.php");
include("inc/menu.php");
include("inc/connection.php");

session_start();
$is_logged_in = isset($_SESSION['user_id']);
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Fetch all music with creator info
$sql = "SELECT music.*, users.name as creator_name, users.role as creator_role 
        FROM music 
        JOIN users ON music.user_id = users.id 
        ORDER BY music.id DESC";
$result = mysqli_query($conn, $sql);
?>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-wrapper">
    <div class="main-content">
        <h1>🎵 Digital Music Store</h1>
        <p class="page-intro">Discover and manage your music collection</p>

        <?php if($is_logged_in && $_SESSION['role'] == 'artist') { ?>
            <a href="register.php" class="btn-add"><i class="fas fa-plus"></i> Add New Music</a>
        <?php } elseif($is_logged_in && $_SESSION['role'] == 'listener') { ?>
            <p style="color:#4a5d72; margin:10px 0;">👋 Welcome, <?php echo $_SESSION['name']; ?>! You can browse all music here.</p>
        <?php } else { ?>
            <p style="color:#4a5d72; margin:10px 0;">🔒 <a href="login.php" style="color:#0e7c7b; font-weight:600;">Login</a> as an Artist to add music.</p>
        <?php } ?>

        <?php if(mysqli_num_rows($result) > 0) { ?>
            <table class="music-table">
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Genre</th>
                        <th>Price</th>
                        <th>Added By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { 
                        $is_owner = ($is_logged_in && $row['user_id'] == $user_id);
                    ?>
                        <tr>
                            <td>
                                <?php if(!empty($row['cover_image'])) { ?>
                                    <img src="images/<?php echo $row['cover_image']; ?>" alt="Cover" class="cover-img">
                                <?php } else { ?>
                                    <img src="images/default-cover.jpg" alt="No Cover" class="cover-img">
                                <?php } ?>
                            </td>
                            <td><strong><?php echo $row['title']; ?></strong></td>
                            <td><?php echo $row['artist']; ?></td>
                            <td><span class="genre-badge"><?php echo $row['genre']; ?></span></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td>
                                <span class="creator-name">
                                    <?php echo $row['creator_name']; ?>
                                    <?php if($row['creator_role'] == 'artist') { ?>
                                        <i class="fas fa-check-circle" style="color:#0e7c7b; font-size:12px;" title="Verified Artist"></i>
                                    <?php } ?>
                                </span>
                            </td>
                            <td>
                                <?php if($is_owner && $row['user_id'] == $user_id && $_SESSION['role'] == 'artist') { ?>
                                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this music?')"><i class="fas fa-trash"></i> Delete</a>
                                <?php } elseif($is_logged_in && $_SESSION['role'] == 'artist') { ?>
                                    <span style="color:#999; font-size:13px;">🔒 Owned by <?php echo $row['creator_name']; ?></span>
                                <?php } elseif($is_logged_in && $_SESSION['role'] == 'listener') { ?>
                                    <span style="color:#999; font-size:13px;">🎧 Listen Only</span>
                                <?php } else { ?>
                                    <span style="color:#999; font-size:13px;">🔒 Login to manage</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p style="text-align:center; padding:40px 0; color:#4a5d72;">
                🎵 No music added yet. 
                <?php if($is_logged_in && $_SESSION['role'] == 'artist') { ?>
                    <a href="register.php" style="color:#0e7c7b; font-weight:600;">Add your first music!</a>
                <?php } else { ?>
                    Be the first to <a href="login.php" style="color:#0e7c7b; font-weight:600;">Login</a> as an Artist and add music.
                <?php } ?>
            </p>
        <?php } ?>
    </div>
    <?php include("inc/sidebar.php"); ?>
</div>

<?php include("inc/footer.php"); ?>