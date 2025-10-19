<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .bus-list-item {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .bus-list-item:hover {
            transform: scale(1.02);
        }
        h4 {
            color: #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .bus-info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .bus-info p {
            margin-bottom: 5px;
        }
        .no-buses {
            text-align: center;
            color: #6c757d;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Available Buses</h2>

    <?php
    include('db.php');
    // Database connection
    $conn = new mysqli("localhost", "root", "", "private_bus");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $from = isset($_GET['from']) ? $_GET['from'] : '';
    $to = isset($_GET['to']) ? $_GET['to'] : '';

    // Fetch buses based on selected location filters (from and to)
    if (!empty($from) && !empty($to)) {
        $sql = "SELECT bus_id, bus_name, departure_time, arrival_time, fare, seats_available FROM buses WHERE from_location LIKE ? AND to_location LIKE ?";
        $stmt = $conn->prepare("SELECT bus_id, bus_name, from_location, to_location, departure_time, arrival_time, fare, seats_available FROM buses WHERE from_location LIKE ? AND to_location LIKE ?");
        $stmt->bind_param("ss", $from, $to);
    } else {
        $stmt = $conn->prepare("SELECT bus_id, bus_name, from_location, to_location, departure_time, arrival_time, fare, seats_available FROM buses");
    }
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='bus-list-item'>";
                echo "<h4>" . htmlspecialchars($row['bus_name']) . "</h4>";
                echo "<p>From: <strong>" . htmlspecialchars($row['from_location']) . "</strong></p>";
                echo "<p>To: <strong>" . htmlspecialchars($row['to_location']) . "</strong></p>";
                echo "<p>Departure: <strong>" . htmlspecialchars($row['departure_time']) . "</strong></p>";
                echo "<p>Arrival: <strong>" . htmlspecialchars($row['arrival_time']) . "</strong></p>";
                echo "<p>Fare: <strong>INR " . htmlspecialchars($row['fare']) . "</strong></p>";
                echo "<p>Seats Available: <strong>" . htmlspecialchars($row['seats_available']) . "</strong></p>";
                echo "</div>";
                // Pass all necessary details as URL parameters for the seat page
                echo "<a href='seat_page.php?bus_id=" . htmlspecialchars($row['bus_id']) . 
                     "&bus_name=" . urlencode($row['bus_name']) . 
                     "&departure_time=" . urlencode($row['departure_time']) . 
                     "&arrival_time=" . urlencode($row['arrival_time']) . 
                     "&from=" . urlencode($from) . 
                     "&to=" . urlencode($to) . 
                     "' class='btn btn-primary'>View Seats</a>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-buses'>No buses found for the selected route.</p>";
        }
        $stmt->close();
    

    $conn->close();
    ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

