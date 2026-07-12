<?php
require_once("inc/session.php");
require_once("inc/header.php");
require_once("inc/connection.php");

// Make sure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isLoggedIn();
$user_id = getUserId();
$user_role = getUserRole();

// Debug - remove after testing
// echo "Logged In: " . ($is_logged_in ? 'Yes' : 'No') . "<br>";
// echo "Role: " . ($user_role ? $user_role : 'None') . "<br>";

// Fetch all music with creator info
$sql = "SELECT music.*, users.name as creator_name, users.role as creator_role 
        FROM music 
        JOIN users ON music.user_id = users.id 
        ORDER BY music.id DESC";
$result = mysqli_query($conn, $sql);
?>

<!-- ============================================================ -->
<!-- APP CONTAINER - WRAPS SIDEBAR + MAIN CONTENT -->
<!-- ============================================================ -->
<div class="app-container">

    <!-- ===== LEFT SIDEBAR (Apple Music Style) ===== -->
    <aside class="sidebar-left">
        <div class="sidebar-logo">
            <span class="logo-icon">🎵</span>
            <span class="logo-text">Music Store</span>
        </div>

        <nav class="sidebar-nav">
            <ul>
                <li><a href="index.php" class="active"><i class="fas fa-home"></i> <span>Home</span></a></li>
                <li><a href="#"><i class="fas fa-compact-disc"></i> <span>New</span></a></li>
                <li><a href="#"><i class="fas fa-fire"></i> <span>Trending</span></a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> <span>Charts</span></a></li>
                <li><a href="#"><i class="fas fa-heart"></i> <span>Favorites</span></a></li>
                <li><a href="#"><i class="fas fa-microphone"></i> <span>Artists</span></a></li>
                <li><a href="#"><i class="fas fa-folder"></i> <span>Playlists</span></a></li>
            </ul>
        </nav>

        <div class="sidebar-divider"></div>

        <nav class="sidebar-nav">
            <ul>
                <?php if(isArtist() || isAdmin()) { ?>
                    <li><a href="register.php"><i class="fas fa-plus-circle"></i> <span>Add Music</span></a></li>
                <?php } ?>
                <li><a href="about.php"><i class="fas fa-info-circle"></i> <span>About</span></a></li>
                <li><a href="contact.php"><i class="fas fa-envelope"></i> <span>Contact</span></a></li>
                <li><a href="services.php"><i class="fas fa-cogs"></i> <span>Services</span></a></li>
            </ul>
        </nav>

        <!-- ============================================================ -->
        <!-- ADMIN MESSAGES LINK - Only visible to Admin -->
        <!-- ============================================================ -->
        <?php if(isAdmin()) { ?>
            <div class="sidebar-divider"></div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="view_messages.php" style="color:#f0a500;"><i class="fas fa-envelope"></i> <span>📩 Messages</span></a></li>
                </ul>
            </nav>
        <?php } ?>

        <div class="sidebar-divider"></div>

        <!-- User Section -->
        <div class="sidebar-user">
            <?php if($is_logged_in) { ?>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <div>
                        <span class="user-name"><?php echo getUserName(); ?></span>
                        <span class="user-role">
                            <?php echo ucfirst(getUserRole()); ?>
                            <?php if(isAdmin()) { ?> 👑<?php } ?>
                        </span>
                    </div>
                </div>
                <a href="logout.php" class="btn-logout-sidebar"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <?php } else { ?>
                <a href="login.php" class="btn-login-sidebar"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="register_user.php" class="btn-register-sidebar"><i class="fas fa-user-plus"></i> Register</a>
            <?php } ?>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content-area">

        <!-- Top Bar with Search -->
        <div class="content-topbar">
            <h1>Home</h1>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search for music, artists...">
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if(isset($_GET['success'])) { ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php } ?>

        <?php if(isset($_GET['error'])) { ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php } ?>

        <!-- ===== FEATURED SECTION ===== -->
        <div class="featured-section">
            <div class="featured-card">
                <div class="featured-content">
                    <span class="featured-badge">🔥 NEW ALBUM</span>
                    <h2>The Rolling Stones</h2>
                    <p>Mick, Ronnie, and Keith give an exclusive look at their 25th album.</p>
                    <a href="#" class="btn-featured">Listen Now</a>
                </div>
                <div class="featured-image">
                    <span style="font-size:80px;">🎸</span>
                </div>
            </div>
        </div>

        <!-- ===== LATEST RELEASES GRID ===== -->
        <section class="music-section">
            <div class="section-header">
                <h2>Latest Releases</h2>
                <?php if(isArtist() || isAdmin()) { ?>
                    <a href="register.php" class="btn-add-sm"><i class="fas fa-plus"></i> Add Music</a>
                <?php } ?>
                <a href="#" class="view-all">View All →</a>
            </div>

            <div class="music-grid">
                <?php if(mysqli_num_rows($result) > 0) { ?>
                    <?php while($row = mysqli_fetch_assoc($result)) { 
                        $is_owner = ($is_logged_in && $row['user_id'] == $user_id);
                    ?>
                        <div class="music-card">
                            <div class="music-cover">
                                <?php if(!empty($row['cover_image'])) { ?>
                                    <img src="images/<?php echo $row['cover_image']; ?>" alt="<?php echo $row['title']; ?>">
                                <?php } else { ?>
                                    <img src="images/default-cover.jpg" alt="No Cover">
                                <?php } ?>
                                <button class="play-btn"><i class="fas fa-play"></i></button>
                            </div>
                            <div class="music-info">
                                <h4><?php echo $row['title']; ?></h4>
                                <p><?php echo $row['artist']; ?></p>
                                <div class="music-meta">
                                    <span class="genre-badge"><?php echo $row['genre']; ?></span>
                                    <span class="music-price">$<?php echo number_format($row['price'], 2); ?></span>
                                </div>
                                <!-- ===== AUDIO PLAYER ===== -->
                                <?php if(!empty($row['audio_file'])) { ?>
                                    <div class="audio-player-wrapper">
                                        <audio controls style="width:100%; height:30px; margin-top:8px;">
                                            <source src="audio/<?php echo $row['audio_file']; ?>" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                <?php } else { ?>
                                    <div class="no-audio" style="margin-top:8px; font-size:11px; color:#666;">
                                        <i class="fas fa-music"></i> No audio uploaded
                                    </div>
                                <?php } ?>
                                
                                <!-- ============================================================ -->
                                <!-- MUSIC ACTIONS - FIXED FOR ADMIN -->
                                <!-- ============================================================ -->
                                <div class="music-actions">
                                    <?php if(isAdmin()) { ?>
                                        <!-- ===== ADMIN: Can edit/delete ANY music ===== -->
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete-sm" onclick="return confirm('Delete this music?')"><i class="fas fa-trash"></i> Delete</a>
                                    <?php } elseif($is_owner && isArtist()) { ?>
                                        <!-- ===== ARTIST: Can edit/delete own music ===== -->
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete-sm" onclick="return confirm('Delete this music?')"><i class="fas fa-trash"></i> Delete</a>
                                    <?php } elseif(isArtist()) { ?>
                                        <!-- ===== ARTIST: View others' music ===== -->
                                        <span class="owner-label">🎵 <?php echo $row['creator_name']; ?></span>
                                    <?php } elseif(isListener()) { ?>
                                        <!-- ===== LISTENER: Listen only ===== -->
                                        <span class="listen-label">🎧 Listen</span>
                                    <?php } else { ?>
                                        <!-- ===== NOT LOGGED IN: Show login link ===== -->
                                        <span class="login-label">🔒 <a href="login.php" style="color:#f0a500;">Login</a></span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="empty-state">
                        <p>🎵 No music added yet.</p>
                        <?php if(isArtist() || isAdmin()) { ?>
                            <a href="register.php" class="btn-add">Add your first music!</a>
                        <?php } else { ?>
                            <a href="login.php" class="btn-add">Login as Artist to add music</a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </section>

        <!-- ===== GENRE QUICK LINKS ===== -->
        <section class="genre-section">
            <div class="section-header">
                <h2>Browse by Genre</h2>
            </div>
            <div class="genre-tags">
                <a href="#" class="genre-tag">Afrobeat</a>
                <a href="#" class="genre-tag">Gospel</a>
                <a href="#" class="genre-tag">Hip-Hop</a>
                <a href="#" class="genre-tag">R&B</a>
                <a href="#" class="genre-tag">Jazz</a>
                <a href="#" class="genre-tag">Electronic</a>
                <a href="#" class="genre-tag">Rock</a>
                <a href="#" class="genre-tag">Traditional</a>
            </div>
        </section>

    </main>

</div>
<!-- ===== END APP CONTAINER ===== -->

<?php require_once("inc/footer.php"); ?>