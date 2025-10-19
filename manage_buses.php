<?php
session_start();
include('db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "private_bus");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add, edit, and delete actions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['add_bus'])) {
        // Add a new bus
        $bus_name = $_POST['bus_name'];
        $from_location = $_POST['from_location'];
        $to_location = $_POST['to_location'];
        $departure_time = $_POST['departure_time'];
        $arrival_time = $_POST['arrival_time'];
        $fare = $_POST['fare'];
        $seats_available = $_POST['seats_available'];

        $stmt = $conn->prepare("INSERT INTO buses (bus_name, from_location, to_location, departure_time, arrival_time, fare, seats_available) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $bus_name, $from_location, $to_location, $departure_time, $arrival_time, $fare, $seats_available);
        $stmt->execute();
        $stmt->close();

        // Redirect back to the same page after adding
        header("Location: manage_buses.php");
        exit();
    } elseif (isset($_POST['delete_bus'])) {
        // Delete a bus
        $bus_id = $_POST['bus_id'];
        $stmt = $conn->prepare("DELETE FROM buses WHERE bus_id = ?");
        $stmt->bind_param("i", $bus_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit_bus'])) {
        // Edit a bus
        $bus_id = $_POST['bus_id'];
        $bus_name = $_POST['bus_name'];
        $from_location = $_POST['from_location'];
        $to_location = $_POST['to_location'];
        $departure_time = $_POST['departure_time'];
        $arrival_time = $_POST['arrival_time'];
        $fare = $_POST['fare'];
        $seats_available = $_POST['seats_available'];

        $stmt = $conn->prepare("UPDATE buses SET bus_name = ?, from_location = ?, to_location = ?, departure_time = ?, arrival_time = ?, fare = ?, seats_available = ? WHERE bus_id = ?");
        $stmt->bind_param("ssssssii", $bus_name, $from_location, $to_location, $departure_time, $arrival_time, $fare, $seats_available, $bus_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all buses
$buses = $conn->query("SELECT * FROM buses");

// Fetch booked seats count
$booked_query = $conn->query("SELECT bus_id, COUNT(*) AS booked_count FROM booked_seats GROUP BY bus_id");
$booked_counts = [];
while ($row = $booked_query->fetch_assoc()) {
    $booked_counts[$row['bus_id']] = $row['booked_count'];
}

// Fetch bus details for update (if necessary)
$bus_to_update = null;
if (isset($_GET['edit_id'])) {
    $bus_id = $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM buses WHERE bus_id = ?");
    $stmt->bind_param("i", $bus_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bus_to_update = $result->fetch_assoc();
    $stmt->close();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Buses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 30px;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .btn {
            margin: 5px;
        }
        table {
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .table tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <a href="admin_dashboard.php" class="btn btn-primary">Admin Dashboard</a>
                <a href="manage_buses.php" class="btn btn-secondary">Manage Buses</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1>Manage Buses</h1>

        <!-- Add/Edit Bus Section -->
        <form method="POST" action="manage_buses.php">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="bus_name" class="form-control" placeholder="Bus Name" value="<?php echo $bus_to_update['bus_name'] ?? ''; ?>" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="from_location" class="form-control" placeholder="From" value="<?php echo $bus_to_update['from_location'] ?? ''; ?>" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="to_location" class="form-control" placeholder="To" value="<?php echo $bus_to_update['to_location'] ?? ''; ?>" required>
                </div>
                <div class="col-md-2">
                    <input type="time" name="departure_time" class="form-control" value="<?php echo $bus_to_update['departure_time'] ?? ''; ?>" required>
                </div>
                <div class="col-md-2">
                    <input type="time" name="arrival_time" class="form-control" value="<?php echo $bus_to_update['arrival_time'] ?? ''; ?>" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="fare" class="form-control" placeholder="Fare" value="<?php echo $bus_to_update['fare'] ?? ''; ?>" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="seats_available" class="form-control" placeholder="Seats Available" value="<?php echo $bus_to_update['seats_available'] ?? ''; ?>" required>
                </div>
                <?php if ($bus_to_update): ?>
                    <input type="hidden" name="bus_id" value="<?php echo $bus_to_update['bus_id']; ?>">
                    <button type="submit" name="edit_bus" class="btn btn-warning">Update</button>
                <?php else: ?>
                    <button type="submit" name="add_bus" class="btn btn-success">Add Bus</button>
                <?php endif; ?>
            </div>
        </form>

        <!-- Bus List -->
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Bus ID</th>
                    <th>Bus Name</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Fare</th>
                    <th>Seats</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($bus = $buses->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $bus['bus_id']; ?></td>
                        <td><?php echo $bus['bus_name']; ?></td>
                        <td><?php echo $bus['from_location']; ?></td>
                        <td><?php echo $bus['to_location']; ?></td>
                        <td><?php echo $bus['departure_time']; ?></td>
                        <td><?php echo $bus['arrival_time']; ?></td>
                        <td><?php echo $bus['fare']; ?></td>
                        <td><?php echo ($booked_counts[$bus['bus_id']] ?? 0) . " / " . $bus['seats_available']; ?></td>
                        <td>
                            <a href="manage_buses.php?edit_id=<?php echo $bus['bus_id']; ?>" class="btn btn-info btn-sm">Edit</a>
                            <form method="POST" action="manage_buses.php" style="display:inline;">
                                <input type="hidden" name="bus_id" value="<?php echo $bus['bus_id']; ?>">
                                <button type="submit" name="delete_bus" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this bus?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
