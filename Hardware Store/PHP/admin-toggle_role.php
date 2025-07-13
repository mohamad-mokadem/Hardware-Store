<?php
include 'auth.php'; // Ensure the user is authenticated

// Ensure the user is an admin
if ($_SESSION['role'] != 1) {
    exit('Unauthorized');
}

if (isset($_POST['id']) && isset($_POST['role'])) {
    $userId = $_POST['id'];
    $newRole = $_POST['role'];

    // Update the user's role in the database
    $conn = new mysqli("127.0.0.1", "root", "", "HardwareStore");
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("ii", $newRole, $userId);

    if ($stmt->execute()) {
        // Check if the role was revoked (set to 0)
        if ($newRole == 0) {
            // If the admin was revoked, log them out and redirect
            session_destroy();
            echo json_encode([
                'success' => true,
                'message' => 'Admin privileges revoked.',
                'redirect' => true
            ]);
        } else {
            echo json_encode(['success' => true, 'message' => 'User promoted to Admin.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating role.']);
    }

    $stmt->close();
    $conn->close();
}
