<?php
// Include your session handling logic (if any)
include('config.php'); // Include the database connection if needed

// Start the session
session_start();

// Destroy all sessions by clearing session data and then destroying the session
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session

// Optional: If you store session IDs in a database, you would remove them here as well

// Redirect to the login page or a specific page after ending the session
header("Location: login.php");
exit;
?>
