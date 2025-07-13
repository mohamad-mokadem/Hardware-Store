<?php
$servername = "127.0.0.1"; // Typically 'localhost' for most servers
$username = "root";        // Your MySQL username (adjust if needed)
$password = "";            // Your MySQL password (adjust if needed)
$dbname = "hardwarestore"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
