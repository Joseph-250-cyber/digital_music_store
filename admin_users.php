<?php
require_once("inc/session.php");
require_once("inc/header.php");
require_once("inc/menu.php");
require_once("inc/connection.php");

// Only Admin can access
requireAdmin();

// Get search term
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Build query
$sql = "SELECT * FROM users";
if(!empty($search)) {
    $sql .= " WHERE email LIKE '%$search%' OR name LIKE '%$search%'";
}
$sql .= " ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="main-wrapper">
    <div class="main-content">
        <h1>👥 User Management <span style="font-size:14px; color:#666; font-weight:normal;">(Admin Only)</span></h1>
        <p class="page-intro">Manage all users: view, edit, block, unblock, and delete.</p>

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

        <!-- Search Bar -->
        <div style="display:flex; gap:15px; margin-bottom:20px; flex-wrap:wrap; align-items:center;">
            <form method="GET" style="flex:1; display:flex; gap:10px;">
                <input type="text" name="search" placeholder="Search by email or name..." 
                       value="<?php echo htmlspecialchars($search); ?>" 
                       style="flex:1; padding:10px; border:2px solid #2a2a2a; border-radius:8px; background:#1a1a1a; color:#fff;">
                <button type="submit" class="btn-submit" style="width:auto; padding:10px 25px;">
                    <i class="fas fa-search"></i> Search
                </button>
                <?php if(!empty($search)) { ?>
                    <a href="admin_users.php" class="btn-back" style="margin:0; padding:10px 20px;">
                        <i class="fas fa-times"></i> Clear
                    </a>
                <?php } ?>
            </form>
            <a href="admin_add_user.php" class="btn-add"><i class="fas fa-user-plus"></i> Add User</a>
        </div>

        <!-- User Stats -->
        <?php 
        $total_sql = "SELECT COUNT(*) as total, 
                      SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
                      SUM(CASE WHEN status = 'blocked' THEN 1 ELSE 0 END) as blocked,
                      SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as admins,
                      SUM(CASE WHEN role = 'artist' THEN 1 ELSE 0 END) as artists,
                      SUM(CASE WHEN role = 'listener' THEN 1 ELSE 0 END) as listeners
                      FROM users";
        $total_result = mysqli_query($conn, $total_sql);
        $stats = mysqli_fetch_assoc($total_result);
        ?>

        <div style="display:flex; gap:15px; margin-bottom:20px; flex-wrap:wrap;">
            <div style="background:#1a1a1a; padding:10px 20px; border-radius:8px; border-left:4px solid #f0a500;">
                <strong style="color:#fff;">Total Users:</strong>
                <span style="color:#f0a500;"><?php echo $stats['total']; ?></span>
            </div>
            <div style="background:#1a1a1a; padding:10px 20px; border-radius:8px; border-left:4px solid #0e7c7b;">
                <strong style="color:#fff;">Active:</strong>
                <span style="color:#0e7c7b;"><?php echo $stats['active']; ?></span>
            </div>
            <div style="background:#1a1a1a; padding:10px 20px; border-radius:8px; border-left:4px solid #e74c3c;">
                <strong style="color:#fff;">Blocked:</strong>
                <span style="color:#e74c3c;"><?php echo $stats['blocked']; ?></span>
            </div>
            <div style="background:#1a1a1a; padding:10px 20px; border-radius:8px; border-left:4px solid #f0a500;">
                <strong style="color:#fff;">👑 Admins:</strong>
                <span style="color:#f0a500;"><?php echo $stats['admins']; ?></span>
            </div>
            <div style="background:#1a1a1a; padding:10px 20px; border-radius:8px; border-left:4px solid #0e7c7b;">
                <strong style="color:#fff;">🎤 Artists:</strong>
                <span style="color:#0e7c7b;"><?php echo $stats['artists']; ?></span>
            </div>
            <div style="background:#1a1a1a; padding:10px 20px; border-radius:8px; border-left:4px solid #3498db;">
                <strong style="color:#fff;">🎧 Listeners:</strong>
                <span style="color:#3498db;"><?php echo $stats['listeners']; ?></span>
            </div>
        </div>

        <!-- Users Table -->
        <?php if(mysqli_num_rows($result) > 0) { ?>
            <table class="music-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><strong><?php echo $row['name']; ?></strong></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <?php if($row['role'] == 'admin') { ?>
                                    <span style="color:#f0a500;">👑 Admin</span>
                                <?php } elseif($row['role'] == 'artist') { ?>
                                    <span style="color:#0e7c7b;">🎤 Artist</span>
                                <?php } else { ?>
                                    <span style="color:#3498db;">🎧 Listener</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($row['status'] == 'blocked') { ?>
                                    <span style="background:#e74c3c; color:#fff; padding:3px 12px; border-radius:20px; font-size:11px;">🚫 Blocked</span>
                                <?php } else { ?>
                                    <span style="background:#0e7c7b; color:#fff; padding:3px 12px; border-radius:20px; font-size:11px;">✅ Active</span>
                                <?php } ?>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                            <td style="display:flex; gap:5px; flex-wrap:wrap;">
                                <a href="admin_edit_user.php?id=<?php echo $row['id']; ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
                                
                                <?php if($row['status'] == 'blocked') { ?>
                                    <a href="admin_unblock_user.php?id=<?php echo $row['id']; ?>" class="btn-edit" style="background:#0e7c7b;" onclick="return confirm('Unblock this user?')">
                                        <i class="fas fa-unlock"></i>
                                    </a>
                                <?php } else { ?>
                                    <a href="admin_block_user.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Block this user?')">
                                        <i class="fas fa-lock"></i>
                                    </a>
                                <?php } ?>
                                
                                <?php if($row['role'] != 'admin') { ?>
                                    <a href="admin_delete_user.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Delete this user permanently?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p style="text-align:center; padding:40px 0; color:#4a5d72;">
                <?php if(!empty($search)) { ?>
                    🔍 No users found matching "<strong><?php echo htmlspecialchars($search); ?></strong>"
                <?php } else { ?>
                    📭 No users found.
                <?php } ?>
            </p>
        <?php } ?>

        <a href="index.php" class="btn-back"><i class="fas fa-home"></i> Back to Home</a>
    </div>
    <?php include("inc/sidebar.php"); ?>
</div>

<?php include("inc/footer.php"); ?>