<?php
// Connect to the database
$servername = "localhost";
$username = "root"; // Default WAMP username
$password = ""; // Default WAMP password (leave blank)
$dbname = "private_bus";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected locations
$from = $_GET['from'];
$to = $_GET['to'];

// SQL query to get bus details
$sql = "SELECT * FROM buses WHERE from_location = '$from' AND to_location = '$to'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        header {
            background-color: #ff5733;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        .bus-list-item {
            background-color: white;
            margin: 20px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<header>
    <h1>Available Buses</h1>
</header>

<div class="bus-list-container">
    <?php
    if ($result->num_rows > 0) {
        // Output data for each bus
        while($row = $result->fetch_assoc()) {
            echo "<div class='bus-list-item'>";
            echo "<h3>" . $row['bus_name'] . "</h3>";
            echo "<p>Departure: " . $row['departure_time'] . "</p>";
            echo "<p>Duration: " . $row['duration'] . "</p>";
            echo "<p>Arrival: " . $row['arrival_time'] . "</p>";
            echo "<p>Fare: INR " . $row['fare'] . "</p>";
            echo "<p>Seats Available: " . $row['seats_available'] . "</p>";
            echo "<p>Rating: " . $row['rating'] . " stars</p>";
            echo "<button class='view-seats'>View Seats</button>";
            echo "</div>";
        }
    } else {
        echo "<p>No buses found from $from to $to.</p>";
    }
    ?>

</div>

</body>
</html>

<?php
$conn->close();
?>
