<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database configuration
include('config.php');

// Initialize the response array
$response = ['status' => '', 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate required fields
    if (empty($username) || empty($password)) {
        $response['status'] = 'error';
        $response['message'] = 'Username and password are required.';
    } else {
        // Query to check if the username exists
        $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the user record
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Start a session on successful login
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role']; // Store user role

                $response['status'] = 'success';
                $response['message'] = 'Login successful.';

                // Redirect based on role
                if ($user['role'] == 1) {
                    // Admin role
                    $response['redirect'] = 'admin.php';
                } else {
                    // User role
                    $response['redirect'] = 'home.php';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Incorrect password.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Username not found.';
        }

        $stmt->close();
    }

    $conn->close();
}

// Return the response as JSON if AJAX is being used
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax'])) {
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Home Improvement Store</title>
    <link rel="stylesheet" href="/CSS/style_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <a href="/PHP/home.php" class="back-button anim">← Back to Home</a>
    <div class="wrapper anim">
        <form id="loginForm" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <i class="fas fa-user"></i>
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class="fas fa-lock"></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox"> Remember me</label>
                <a href="/PHP/forgot-password.php">Forgot password?</a>
            </div>
            <button type="submit" class="submit-button">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="/PHP/signup.php">Register here</a></p>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                // Disable the button to prevent multiple submissions
                $('.submit-button').prop('disabled', true);

                // Prepare form data
                var formData = {
                    username: $('#username').val(),
                    password: $('#password').val(),
                    ajax: true
                };

                // AJAX request
                $.ajax({
                    url: 'login.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Enable the submit button
                        $('.submit-button').prop('disabled', false);

                        if (response.status === 'success') {
                            // Redirect based on the user's role
                            window.location.href = response.redirect;
                        } else {
                            // Show error message
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Error: Unable to process the request.');
                        $('.submit-button').prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>
</html>
