<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.html");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "private_bus");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users
$sql = "SELECT id, username, phoneno FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="stylezz.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        main {
            margin: 2rem auto;
            max-width: 90%;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 1rem;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
        }
        footer {
            text-align: center;
            margin-top: 2rem;
            color: #666;
        }
        .admin_dashboard {
            background-color: #007bff;
            color: white;
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
        }
        .admin_dashboard:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Users</h1>
    </header>
    <main>
        
        <a href="admin_dashboard.php" class="btn admin_dashboard">Admin Dashboard</a> <!-- Manage Buses Button -->
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['phoneno']}</td>
                                <td>
                                    <div class='action-buttons'>
                                        <form action='delete_user.php' method='POST' style='display:inline;'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <button type='submit' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Bus Reservation System. All rights reserved.</p>
    </footer>
</body>
</html>
