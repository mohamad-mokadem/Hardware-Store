<?php
include 'auth.php'; // Ensure the user is authenticated

// Ensure the user is an admin
if ($_SESSION['role'] != 1) {
    exit('Unauthorized');
}

if (isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Delete the user from the database
    $conn = new mysqli("127.0.0.1", "root", "", "HardwareStore");
    $stmt = $conn->prepare("DELETE FROM users WHERE User_ID = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting user.']);
    }
    $stmt->close();
    $conn->close();
}
