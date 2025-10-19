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

// Fetch all tickets
$sql = "SELECT * FROM tickets";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tickets</title>
    <link rel="stylesheet" href="stylezz.css">
    <style>
       body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f7f9fc;
    display: flex;
    flex-direction: column;
    height: 100vh; /* Make the body take up full height */
}

header {
    background-color: #4CAF50;
    color: white;
    padding: 1rem;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

main {
    margin: 2rem auto;
    max-width: 1200px;
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
    flex-grow: 1; /* Take up the remaining space */
}

footer {
    text-align: center;
    margin-top: 2rem;
    font-size: 0.9rem;
    color: #666;
    padding: 10px;
    background-color: #f7f9fc;
    border-top: 1px solid #ddd;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 8px;
    text-align: center;
    border: 1px solid #ddd;
}

th {
    background-color: #4CAF50;
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    align-items: center;
    justify-items: center;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: background-color 0.3s ease;
    display: inline-block;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
    border: none;
}

.btn-edit {
    background-color: #007bff;
    color: white;
    border: none;
}

.btn:hover {
    opacity: 0.8;
}

.btn-edit:hover {
    background-color: #0056b3;
}

.btn-delete:hover {
    background-color: #c82333;
}

.admin_dashboard {
    background-color: #28a745;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 5px;
    text-decoration: none;
    font-size: 1rem;
    display: inline-block;
    margin-bottom: 1rem;
}

.admin_dashboard:hover {
    opacity: 0.8;
}

    </style>
</head>
<body>
    <header>
        <h1>Manage Tickets</h1>
    </header>
    <main>
        <a href="admin_dashboard.php" class="btn admin_dashboard">Back to Dashboard</a> <!-- Dashboard Button -->
        <table>
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Bus Name</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Seats</th>
                    <th>Ticket No</th>
                    <th>PNR</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['ticket_id']}</td>
                                <td>{$row['departure_time']}</td>
                                <td>{$row['arrival_time']}</td>
                                <td>{$row['bus_name']}</td>
                                <td>{$row['from']}</td>
                                <td>{$row['to']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['age']}</td>
                                <td>{$row['gender']}</td>
                                <td>{$row['seats']}</td>
                                <td>{$row['ticket']}</td>
                                <td>{$row['pnr']}</td>
                                <td>
                                    <div class='action-buttons'>
                                        <form action='delete_ticket.php' method='POST' style='display:inline;'>
                                            <input type='hidden' name='ticket_id' value='{$row['ticket_id']}'>
                                            <button type='submit' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this ticket?\");'>Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No tickets found.</td></tr>";
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
