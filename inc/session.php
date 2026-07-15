<?php
if (!defined('SESSION_PHP_LOADED')) {
    define('SESSION_PHP_LOADED', true);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function getUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

function getUserName() {
    return isset($_SESSION['name']) ? $_SESSION['name'] : null;
}

function getUserEmail() {
    return isset($_SESSION['email']) ? $_SESSION['email'] : null;
}

function getUserRole() {
    return isset($_SESSION['role']) ? $_SESSION['role'] : null;
}

function isArtist() {
    return isLoggedIn() && getUserRole() == 'artist';
}

function isListener() {
    return isLoggedIn() && getUserRole() == 'listener';
}

function isOwner($music_user_id) {
    return isLoggedIn() && getUserId() == $music_user_id;
}

function loginUser($user_id, $name, $email, $role) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role;
    return true;
}

function logoutUser() {
    session_destroy();
    return true;
}

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

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function requireArtist() {
    requireLogin();
    if (!isArtist()) {
        header("Location: index.php?error=Only artists can access this page");
        exit();
    }
}

function requireListener() {
    requireLogin();
    if (!isListener()) {
        header("Location: index.php?error=Only listeners can access this page");
        exit();
    }
}

function isAdmin() {
    return isLoggedIn() && getUserRole() == 'admin';
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: index.php?error=Access denied. Admin only.");
        exit();
    }
}

function isUserBlocked($user_id) {
    global $conn;
    $sql = "SELECT status FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return isset($row['status']) && $row['status'] == 'blocked';
}

function isCurrentUserBlocked() {
    if(!isLoggedIn()) return false;
    return isUserBlocked(getUserId());
}

function requireNotBlocked() {
    if(isCurrentUserBlocked()) {
        session_destroy();
        header("Location: login.php?error=Your account has been blocked");
        exit();
    }
}
} 
?>