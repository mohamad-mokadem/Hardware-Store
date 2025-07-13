<?php
include 'auth.php'; 

// Check if the logged-in user has admin privileges (Role = 1)
if ($_SESSION['role'] != 1) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Private page that is inaccessible to the average user, allowing for administrative control over the website">
    <link rel="stylesheet" href="/CSS/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="cart.js"></script>
    <title>Admin Page</title>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Sidebar</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="/CSS/admin-view_users.css">View Users</a></li>
                    <li><a href="/CSS/admin-view_admins.css">View Admins</a></li>
                    <li><a href="/CSS/admin-manage_account.css">Manage Account</a></li>
                    <li><a href="/PHP/logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>
        <main class="admin-main">
            <header>
                <nav>
                    <ul>
                        <li><a href="/PHP/home.php">Home</a></li>
                    </ul>
                </nav>
            </header>
            <section class="main-content">
                <h1>Welcome to the Admin Panel</h1>
                <p>Manage your store, account, and users from here. Use the sidebar to navigate to various sections.</p>
            </section>
        </main>
    </div>
</body>
</html>