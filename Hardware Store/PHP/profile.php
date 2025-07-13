<?php
// Include necessary scripts
include('auth.php');
include('config.php');

// Check if the user is logged in
checkLogin();

// Initialize success/error messages
$message = "";

// Handle email and password update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_email'])) {
        // Update Email
        $new_email = $_POST['email'];
        if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $sql = "UPDATE users SET email = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_email, $_SESSION['user_id']);
            if ($stmt->execute()) {
                $message = "Email updated successfully!";
            } else {
                $message = "Error updating email.";
            }
        } else {
            $message = "Invalid email format.";
        }
    }

    if (isset($_POST['update_password'])) {
        // Update Password
        $new_password = $_POST['password'];
        if (strlen($new_password) >= 8) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $hashed_password, $_SESSION['user_id']);
            if ($stmt->execute()) {
                $message = "Password updated successfully!";
            } else {
                $message = "Error updating password.";
            }
        } else {
            $message = "Password must be at least 8 characters long.";
        }
    }
}

// Fetch user data for displaying
$user_data = getUserData($conn);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Home Improvement Store</title>
    <link rel="stylesheet" href="/CSS/style_profile.css">
</head>
<body>
   
    <div class="profile-wrapper">
        <h1>Welcome, <?php echo htmlspecialchars($user_data['first_name']); ?>!</h1>
        <h2>Your Profile</h2>
        
        <!-- Success/Error Message -->
        <?php if ($message): ?>
            <div class="alert"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Profile Info -->
        <div class="profile-info">
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user_data['first_name']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user_data['last_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user_data['username']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user_data['address']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($user_data['city']); ?></p>
        </div>

        <!-- Update Email -->
        <h3>Change Email</h3>
        <form method="POST">
            <input type="email" name="email" placeholder="New Email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
            <button type="submit" name="update_email" class="btn">Update Email</button>
        </form>

        <!-- Update Password -->
        <h3>Change Password</h3>
        <form method="POST">
            <input type="password" name="password" placeholder="New Password" required>
            <button type="submit" name="update_password" class="btn">Update Password</button>
        </form>

        <div class="profile-actions">
            <a href="/PHP/logout.php" class="btn">Logout</a>
        </div>
    </div>
</body>
</html>
