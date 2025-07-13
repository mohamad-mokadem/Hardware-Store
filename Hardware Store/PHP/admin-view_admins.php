<?php
include 'auth.php';  // Ensure the user is authenticated

// Check if the logged-in user has admin privileges (Role = 1)
if ($_SESSION['role'] != 1) {
    header("Location: index.php");  // Redirect if not an admin
    exit;
}

$conn = new mysqli("127.0.0.1", "root", "", "HardwareStore");  // Database connection

// Get the current logged-in admin's ID
$currentAdminId = $_SESSION['user_id'];

// Query to select admins only (Role = 1) excluding the currently logged-in admin
$admins = $conn->query("SELECT id, first_name, last_name, email, role FROM users WHERE role = 1 AND id != $currentAdminId");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/admin-view_users.css"> <!-- Your theme styles -->
    <link rel="stylesheet" href="/CSS/admin.css">  <!-- Additional styles -->
    <title>View Admins</title>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Sidebar</h2>
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
                <h1>View Admins</h1>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($admin = $admins->fetch_assoc()): ?>
                        <tr id="admin-<?= $admin['id'] ?>">
                            <td><?= $admin['id'] ?></td>
                            <td><?= $admin['first_name'] ?> <?= $admin['last_name'] ?></td>
                            <td><?= $admin['email'] ?></td>
                            <td><?= $admin['role'] == 1 ? 'Admin' : 'User' ?></td>
                            <td>
                                <!-- Only show 'Revoke Admin' button for other admins, not the logged-in admin -->
                                <?php if ($admin['id'] != $currentAdminId): ?>
                                    <button class="toggle-role" data-id="<?= $admin['id'] ?>" data-role="<?= $admin['role'] ?>">
                                        Revoke Admin
                                    </button>
                                <?php else: ?>
                                    <button disabled>Current Admin</button> <!-- Disable for logged-in admin -->
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Revoke Admin action (for admins other than the logged-in admin)
        $(".toggle-role").click(function () {
            const id = $(this).data("id");

            if (confirm("Are you sure you want to revoke this admin's privileges?")) {
                $.post("admin-toggle_role.php", { id: id, role: 0 }, function (response) {
                  
                }, "json").fail(function () {
                    alert("An error occurred while processing the request.");
                });
            }
        });
    </script>
</body>
</html>
