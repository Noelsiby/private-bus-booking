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

// Get the bus_id from the URL
$bus_id = $_GET['bus_id'];

// Fetch bus details based on the selected bus
$sql = "SELECT * FROM buses WHERE id = '$bus_id'";
$result = $conn->query($sql);
$bus = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Allocation</title>
    <link rel="stylesheet" href="stylesss.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h4 {
            color: #ff5733;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        hr {
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Back to Bus List and Pie Chart Link -->
        <h4>&larr; <a href="bus-list.php">Bus Travels</a></h4> 
        <span><a href="/Piechart.html">Pie Chart</a></span>
        <hr />

        <!-- Display Bus Details -->
        <h5>Bus: <?php echo htmlspecialchars($bus['bus_name']); ?></h5>
        <p><strong>Departure:</strong> <?php echo htmlspecialchars($bus['departure_time']); ?></p>
        <p><strong>Arrival:</strong> <?php echo htmlspecialchars($bus['arrival_time']); ?></p>
        <p><strong>Fare:</strong> INR <?php echo htmlspecialchars($bus['fare']); ?></p>

        <!-- Seat selection logic (Placeholder for actual implementation) -->
        <p>Seats Available: <?php echo htmlspecialchars($bus['seats_available']); ?></p>

        <!-- Button or Seat Selection functionality can be added here -->
        <a href="seat_selection_logic.php?bus_id=<?php echo $bus_id; ?>" class="btn btn-primary">Select Seats</a>
    </div>

    <!-- Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="app.js"></script>

</body>
</html>

<?php
$conn->close();
?>
