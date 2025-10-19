<?php
session_start();

// Default admin credentials
$defaultUsername = "admin";
$defaultPassword = "admin";

// Check if the admin is already logged in
if (!isset($_SESSION['admin_logged_in'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === $defaultUsername && $password === $defaultPassword) {
            $_SESSION['admin_logged_in'] = true;
        } else {
            echo "<script>alert('Invalid Username or Password');</script>";
            header("Location: admin_login.html");
            exit();
        }
    } else {
        header("Location: admin_login.html");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Private Bus</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('bus.png') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        header {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 2rem;
            font-weight: 600;
        }

        header p {
            font-size: 1rem;
            margin-top: 5px;
        }

        .navbar {
            background-color: #ff5733;
            padding: 10px 20px;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            justify-content: center;
        }

        .navbar li {
            margin: 0 15px;
        }

        .navbar a {
            text-decoration: none;
            color: #fff;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            color: #ddd;
        }

        main {
            padding: 40px 20px;
            text-align: center;
            background: rgba(255, 255, 255, 0.9);
            margin: 20px auto;
            max-width: 800px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        main h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #444;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Private Bus Admin Dashboard</h1>
            <p>Manage your bus services efficiently</p>
        </div>
    </header>
    <nav class="navbar">
        <ul>
            <li><a href="manage_buses.php">Manage Buses</a></li>
            <!--li><a href="manage_routes.php">Manage Routes</a></li-->
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_tickets.php">Manage Tickets</a></li>
            <li><a href="manage_booked_seats.php">Manage Seats</a></li>
            <li><a href="logout.php" onclick="return confirm('Are you sure you want to log out?');">Logout</a></li>
        </ul>
    </nav>
    <main>
        <div class="dashboard-content">
            <h2>Welcome, Admin</h2>
            <p>Here you can manage all aspects of your bus reservation system.</p>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Private Bus Reservation System. All rights reserved.</p>
    </footer>
</body>
</html>
