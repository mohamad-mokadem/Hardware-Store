<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database configuration (assumes config.php file exists)
include('config.php');

// Check if the user is logged in as admin (role = 1)
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    // If the user is an admin, deny access to this page
    echo "<script>alert('Admins are not allowed to reset their password using this portal.'); window.location.href = 'home.php';</script>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from POST request
    $username = $_POST['username'];
    $highschoolAnswer = $_POST['Backup']; // Security question answer
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate required fields
    if (empty($username) || empty($highschoolAnswer) || empty($newPassword) || empty($confirmPassword)) {
        echo "<script>alert('Please fill in all the required fields!');</script>";
    } elseif ($newPassword !== $confirmPassword) {
        // Check if passwords match
        echo "<script>alert('Passwords do not match!');</script>";
    } elseif (strlen($newPassword) < 8) {
        // Check if the password is at least 8 characters long
        echo "<script>alert('Password must be at least 8 characters long!');</script>";
    } else {
        // Check if the username exists and match the backup answer
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = 0"); // Only check regular users (role = 0)
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User exists, now check the backup (security question answer)
            $user = $result->fetch_assoc();

            // Verify if the backup (security question answer) is correct
            if (password_verify($highschoolAnswer, $user['Backup'])) {
                // Password hash and update the user's password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                $updateStmt->bind_param("ss", $hashedPassword, $username);

                if ($updateStmt->execute()) {
                    echo "<script>alert('Password updated successfully!'); window.location.href = 'login.php';</script>";
                } else {
                    echo "<script>alert('Error updating password: " . $updateStmt->error . "');</script>";
                }

                $updateStmt->close();
            } else {
                echo "<script>alert('Security question answer is incorrect!');</script>";
            }
        } else {
            echo "<script>alert('Username not found or user is an admin!');</script>";
        }

        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Home Improvement Store</title>
    <link rel="stylesheet" href="/CSS/style_forget.css">
</head>
<body>
    <a href="/PHP/home.php" class="back-button anim">← Back to Home</a>
    <div class="wrapper_forget anim">
        <h1>Forgot Password</h1>
        <p>Enter your username and the answer to your security question to reset your password.</p>

        <form method="POST" action="forgot-password.php">
            <div class="input-box">
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>

            
            <div class="input-box">
                <input type="text" id="Backup" name="Backup" placeholder="Your High School Name" required>
            </div>

         
            <div class="input-box">
                
                <input type="password" id="password" name="password" placeholder="New Password" required>
            </div>

            <div class="input-box">
               
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm New Password" required>
            </div>

            <button type="submit" class="submit-button">Reset Password</button>
        </form>
    </div>
</body>
</html>
