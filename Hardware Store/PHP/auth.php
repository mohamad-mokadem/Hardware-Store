<?php
// Start the session
session_start();

// Function to check if the user is logged in
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        // If not logged in, redirect to login page
        header('Location: login.php');
        exit();
    }
}

// Function to get user data
function getUserData($conn) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    return null;
}

// Function to log out (destroy session)
function logout() {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
