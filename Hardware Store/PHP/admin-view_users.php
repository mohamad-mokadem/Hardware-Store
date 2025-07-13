<?php
include 'auth.php';  // Ensure the user is authenticated

// Check if the logged-in user has admin privileges (Role = 1)
if ($_SESSION['role'] != 1) {
    header("Location: index.php");  // Redirect if not an admin
    exit;
}

$conn = new mysqli("127.0.0.1", "root", "", "HardwareStore");  // Database connection

// Query to select users only (Role = 0)
$users = $conn->query("SELECT id, first_name, last_name, email, role FROM users WHERE role = 0");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/admin-view_users.css"> <!-- Your theme styles -->
    <link rel="stylesheet" href="/CSS/admin.css">  <!-- Additional styles -->
    <title>View Users</title>
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
                <h1>View Users</h1>
                
                <?php if ($users->num_rows == 0): ?>
                    <p>No users found.</p>
                <?php else: ?>
                    <table class="user-table">
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
                            <?php while ($user = $users->fetch_assoc()): ?>
                            <tr id="user-<?= $user['id'] ?>">
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['first_name'] ?> <?= $user['last_name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['role'] == 1 ? 'Admin' : 'User' ?></td>
                                <td>
                                    <button class="make-admin" data-id="<?= $user['id'] ?>">Make Admin</button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Make user an admin action
        $(".make-admin").click(function () {
            const id = $(this).data("id");

            if (confirm("Are you sure you want to make this user an admin?")) {
                $.post("admin-toggle_role.php", { id: id, role: 1 }, function (response) {
                    if (response.success) {
                        alert(response.message); // "User promoted to Admin"
                        
                        // Remove the user from the table
                        $("#user-" + id).remove();
                    } else {
                        alert(response.message); // Error message
                    }
                }, "json").fail(function () {
                    alert("An error occurred while processing the request.");
                });
            }
        });
    </script>
</body>
</html>
