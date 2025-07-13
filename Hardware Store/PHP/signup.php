<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database configuration (assumes config.php file exists)
include('config.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from POST request
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $backup = $_POST['Backup']; // Security question answer (Backup)

    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($username) || empty($password) || empty($confirmPassword) || empty($address) || empty($city) || empty($backup)) {
        echo "<script>alert('Please fill in all the required fields!');</script>";
    } elseif ($password !== $confirmPassword) {
        // Check if passwords match
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Check if the email or username already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User already exists with the same email or username
            echo "<script>alert('Email or Username already taken!');</script>";
        } else {
            // Password hashing
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Hash the backup (security question answer) for security
            $hashedBackupAnswer = password_hash($backup, PASSWORD_DEFAULT);

            // Prepare SQL statement to insert new user data into the correct column 'Backup'
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, username, password, address, city, Backup) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $firstName, $lastName, $email, $username, $hashedPassword, $address, $city, $hashedBackupAnswer);

            // Execute query
            if ($stmt->execute()) {
                echo "<script>alert('Sign up successful!'); window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }

            // Close the statement
            $stmt->close();
        }

        // Close the connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Home Improvement Store</title>
    <link rel="stylesheet" href="/CSS/style_signup.css">
</head>
<body>
    <a href="/PHP/home.php" class="back-button anim">← Back to Home</a>
    <div class="wrapper anim">
        <h1>Sign Up</h1>

        <h2>Personal Info</h2>
        <form method="POST" action="/PHP/signup.php">
            <div class="input-box">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
            </div>
            <div class="input-box">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
            </div>

            <h2>Account Credentials</h2>
            <div class="input-box">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-box">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="input-box">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-box">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
            </div>

            <h2>Shipping Information</h2>
            <div class="input-box">
                <label for="address">Street Address</label>
                <input type="text" id="address" name="address" placeholder="Street Address" required>
            </div>
            <div class="input-box">
                <label for="city">City</label>
                <input type="text" id="city" name="city" placeholder="City" required>
            </div>

            <h2>Security Question</h2>
            <div class="input-box">
                <label for="Backup">What is the name of your high school?</label>
                <input type="text" id="Backup" name="Backup" placeholder="Your High School Name" required>
            </div>
        
            <button type="submit" class="submit-button">Sign Up</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="/PHP/login.php">Log in here</a></p>
        </div>
    </div>
</body>
</html>
