<?php
session_start();

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

// Handle form submissions for add, update, and delete (routes and locations)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handling route operations
    if (isset($_POST['add_route'])) {
        $from_location = $_POST['from_location'];
        $to_location = $_POST['to_location'];
        $stmt = $conn->prepare("INSERT INTO routes (from_location, to_location) VALUES (?, ?)");
        $stmt->bind_param("ss", $from_location, $to_location);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_route'])) {
        $route_id = $_POST['route_id'];
        $stmt = $conn->prepare("DELETE FROM routes WHERE route_id = ?");
        $stmt->bind_param("i", $route_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit_route'])) {
        $route_id = $_POST['route_id'];
        $from_location = $_POST['from_location'];
        $to_location = $_POST['to_location'];
        $stmt = $conn->prepare("UPDATE routes SET from_location = ?, to_location = ? WHERE route_id = ?");
        $stmt->bind_param("ssi", $from_location, $to_location, $route_id);
        $stmt->execute();
        $stmt->close();
    }

    // Handling location operations
    if (isset($_POST['add_location'])) {
        $location_name = $_POST['location_name'];
        $stmt = $conn->prepare("INSERT INTO locations (location_name) VALUES (?)");
        $stmt->bind_param("s", $location_name);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update_location'])) {
        $location_id = $_POST['location_id'];
        $location_name = $_POST['location_name'];
        $stmt = $conn->prepare("UPDATE locations SET location_name = ? WHERE id = ?");
        $stmt->bind_param("si", $location_name, $location_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_location'])) {
        $location_id = $_POST['location_id'];
        $stmt = $conn->prepare("DELETE FROM locations WHERE id = ?");
        $stmt->bind_param("i", $location_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all routes and locations from the database
$routes = $conn->query("SELECT * FROM routes");
$locations = $conn->query("SELECT * FROM locations");

// Fetch route/location details for editing (if applicable)
$route_to_update = null;
$location_to_update = null;

if (isset($_GET['edit_route_id'])) {
    $route_id = $_GET['edit_route_id'];
    $result = $conn->query("SELECT * FROM routes WHERE route_id = $route_id");
    $route_to_update = $result->fetch_assoc();
}

if (isset($_GET['edit_location_id'])) {
    $location_id = $_GET['edit_location_id'];
    $result = $conn->query("SELECT * FROM locations WHERE id = $location_id");
    $location_to_update = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Routes and Locations</title>
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
    <!-- Navbar as buttons -->
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <a href="admin_dashboard.php"><button class="btn btn-primary">Admin Dashboard</button></a>
                <a href="manage_buses.php"><button class="btn btn-secondary">Manage Buses</button></a>
                <a href="manage_routes.php"><button class="btn btn-secondary">Manage Routes</button></a>
                <a href="manage_users.php"><button class="btn btn-secondary">Manage Users</button></a>
                <a href="manage_tickets.php"><button class="btn btn-secondary">Manage Tickets</button></a>
                <a href="logout.php"><button class="btn btn-danger">Logout</button></a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1>Manage Routes</h1>

        <!-- Add or Edit Route Section -->
        <h3><?php echo $route_to_update ? "Edit Route" : "Add New Route"; ?></h3>
        <form method="POST" action="manage_routes.php" class="mb-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text" name="from_location" class="form-control" placeholder="From Location" required value="<?php echo $route_to_update ? $route_to_update['from_location'] : ''; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" name="to_location" class="form-control" placeholder="To Location" required value="<?php echo $route_to_update ? $route_to_update['to_location'] : ''; ?>">
                </div>
            </div>
            <?php if ($route_to_update): ?>
                <input type="hidden" name="route_id" value="<?php echo $route_to_update['route_id']; ?>">
                <button type="submit" name="edit_route" class="btn btn-warning">Update Route</button>
                <a href="manage_routes.php" class="btn btn-secondary">Cancel</a>
            <?php else: ?>
                <button type="submit" name="add_route" class="btn btn-primary">Add Route</button>
            <?php endif; ?>
        </form>

        <!-- Routes List Section -->
        <h3>Routes List</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>From Location</th>
                    <th>To Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($route = $routes->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $route['from_location']; ?></td>
                        <td><?php echo $route['to_location']; ?></td>
                        <td>
                            <a href="manage_routes.php?edit_route_id=<?php echo $route['route_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="manage_routes.php" class="d-inline">
                                <input type="hidden" name="route_id" value="<?php echo $route['route_id']; ?>">
                                <button type="submit" name="delete_route" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this route?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Add Location Section -->
        <h3>Add New Location</h3>
        <form method="POST" action="manage_routes.php" class="mb-4">
            <input type="text" name="location_name" class="form-control" placeholder="Location Name" required>
            <button type="submit" name="add_location" class="btn btn-primary mt-3">Add Location</button>
        </form>

        <!-- Locations List Section -->
        <h3>Locations List</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Location Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($location = $locations->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $location['location_name']; ?></td>
                        <td>
                            <a href="manage_routes.php?edit_location_id=<?php echo $location['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="manage_routes.php" class="d-inline">
                                <input type="hidden" name="location_id" value="<?php echo $location['id']; ?>">
                                <button type="submit" name="delete_location" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this location?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
