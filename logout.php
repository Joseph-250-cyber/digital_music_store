<?php
include("inc/session.php");

// Use the logoutUser function from session.php
logoutUser();

header("Location: index.php?success=Logged out successfully");
exit();
?>