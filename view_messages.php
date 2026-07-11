<?php
require_once("inc/session.php");
require_once("inc/header.php");
require_once("inc/menu.php");
require_once("inc/connection.php");

// ONLY ADMIN CAN VIEW MESSAGES
requireAdmin();

$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="main-wrapper">
    <div class="main-content">
        <h1>📩 Messages <span style="font-size:14px; color:#666; font-weight:normal;">(Admin Only)</span></h1>
        <p class="page-intro">View all messages from the contact form.</p>

        <?php if(isset($_GET['success'])) { ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> <?php echo $_GET['success']; ?>
            </div>
        <?php } ?>

        <?php if(isset($_GET['error'])) { ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>

        <!-- Message Stats -->
        <?php 
        $unread_sql = "SELECT COUNT(*) as unread_count FROM messages WHERE status = 'unread'";
        $unread_result = mysqli_query($conn, $unread_sql);
        $unread_row = mysqli_fetch_assoc($unread_result);
        $unread_count = $unread_row['unread_count'];
        ?>

        <div style="display:flex; gap:15px; margin-bottom:20px; flex-wrap:wrap;">
            <div style="background:#1a1a1a; padding:10px 20px; border-radius:8px; border-left:4px solid #f0a500;">
                <strong style="color:#fff;">Total Messages:</strong>
                <span style="color:#f0a500;"><?php echo mysqli_num_rows($result); ?></span>
            </div>
            <div style="background:#1a1a1a; padding:10px 20px; border-radius:8px; border-left:4px solid #e74c3c;">
                <strong style="color:#fff;">Unread:</strong>
                <span style="color:#e74c3c;"><?php echo $unread_count; ?></span>
            </div>
        </div>

        <?php if(mysqli_num_rows($result) > 0) { ?>
            <table class="music-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><strong><?php echo $row['name']; ?></strong></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['subject'] ?: '—'; ?></td>
                            <td style="max-width:200px; word-wrap:break-word;">
                                <?php echo substr($row['message'], 0, 50) . (strlen($row['message']) > 50 ? '...' : ''); ?>
                            </td>
                            <td>
                                <?php if($row['status'] == 'unread') { ?>
                                    <span style="background:#e74c3c; color:#fff; padding:2px 10px; border-radius:20px; font-size:11px;">🔴 Unread</span>
                                <?php } elseif($row['status'] == 'read') { ?>
                                    <span style="background:#f0a500; color:#0a2a2a; padding:2px 10px; border-radius:20px; font-size:11px;">📖 Read</span>
                                <?php } else { ?>
                                    <span style="background:#0e7c7b; color:#fff; padding:2px 10px; border-radius:20px; font-size:11px;">✅ Replied</span>
                                <?php } ?>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <?php if($row['status'] == 'unread') { ?>
                                    <a href="mark_read.php?id=<?php echo $row['id']; ?>" class="btn-edit" style="font-size:11px;">Mark Read</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p style="text-align:center; padding:40px 0; color:#4a5d72;">
                📭 No messages found.
            </p>
        <?php } ?>

        <a href="index.php" class="btn-back"><i class="fas fa-home"></i> Back to Home</a>
    </div>
    <?php require_once("inc/sidebar.php"); ?>
</div>

<?php require_once("inc/footer.php"); ?>