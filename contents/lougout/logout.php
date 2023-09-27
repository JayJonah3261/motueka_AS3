<?php
session_start();

// Check if the user clicked the "Logout" button
if (isset($_POST['logout'])) {
    // Clear all session data
    $_SESSION = array();
    
    // Destroy the session
    session_destroy();
    
    // Redirect to the login page
    header("Location: login.php");
    exit;
} else {
    // If the user didn't click the "Logout" button, redirect to another page or display an error message
    header("Location: error.php");
    exit;
}
?>
