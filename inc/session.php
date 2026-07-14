<?php
// ============================================================
// SESSION MANAGEMENT - Single file to handle all sessions
// ============================================================

// Prevent multiple inclusions
if (!defined('SESSION_PHP_LOADED')) {
    define('SESSION_PHP_LOADED', true);

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================================
// SESSION HELPER FUNCTIONS
// ============================================================

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get current user ID
 */
function getUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

/**
 * Get current user name
 */
function getUserName() {
    return isset($_SESSION['name']) ? $_SESSION['name'] : null;
}

/**
 * Get current user email
 */
function getUserEmail() {
    return isset($_SESSION['email']) ? $_SESSION['email'] : null;
}

/**
 * Get current user role
 */
function getUserRole() {
    return isset($_SESSION['role']) ? $_SESSION['role'] : null;
}

/**
 * Check if user is an Artist
 */
function isArtist() {
    return isLoggedIn() && getUserRole() == 'artist';
}

/**
 * Check if user is a Listener
 */
function isListener() {
    return isLoggedIn() && getUserRole() == 'listener';
}

/**
 * Check if user owns a specific music
 */
function isOwner($music_user_id) {
    return isLoggedIn() && getUserId() == $music_user_id;
}

/**
 * Login user - set session variables
 */
function loginUser($user_id, $name, $email, $role) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role;
    return true;
}

/**
 * Logout user - destroy session
 */
function logoutUser() {
    session_destroy();
    return true;
}

/**
 * Get current user data as array
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    return [
        'id' => getUserId(),
        'name' => getUserName(),
        'email' => getUserEmail(),
        'role' => getUserRole()
    ];
}

/**
 * Redirect if not logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Redirect if not an Artist
 */
function requireArtist() {
    requireLogin();
    if (!isArtist()) {
        header("Location: index.php?error=Only artists can access this page");
        exit();
    }
}

/**
 * Redirect if not a Listener
 */
function requireListener() {
    requireLogin();
    if (!isListener()) {
        header("Location: index.php?error=Only listeners can access this page");
        exit();
    }
}

/**
 * Check if user is an Admin
 */
function isAdmin() {
    return isLoggedIn() && getUserRole() == 'admin';
}

/**
 * Redirect if not an Admin
 */
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: index.php?error=Access denied. Admin only.");
        exit();
    }
}

/**
 * Check if user is blocked
 */
function isUserBlocked($user_id) {
    global $conn;
    $sql = "SELECT status FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return isset($row['status']) && $row['status'] == 'blocked';
}

/**
 * Check if current user is blocked
 */
function isCurrentUserBlocked() {
    if(!isLoggedIn()) return false;
    return isUserBlocked(getUserId());
}

/**
 * Redirect if user is blocked
 */
function requireNotBlocked() {
    if(isCurrentUserBlocked()) {
        session_destroy();
        header("Location: login.php?error=Your account has been blocked");
        exit();
    }
}
} // END: if (!defined('SESSION_PHP_LOADED'))
?>