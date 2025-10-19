<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "private_bus";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the bus ID from the URL
$bus_id = isset($_GET['bus_id']) ? $_GET['bus_id'] : '';

// Ensure bus_id is not empty
if (!empty($bus_id)) {
    // SQL query to retrieve bus details based on the bus ID
    $sql = "SELECT * FROM buses WHERE bus_id = ?";  // Use bus_id instead of id

    // Print the SQL query for debugging
    echo "SQL Query: " . $sql . "<br>";  // Debugging line

    // Prepare the SQL statement to avoid SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $bus_id);  // 'i' means one integer (bus_id)

        // Execute the statement
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();

            // Check if any buses were found
            if ($result->num_rows > 0) {
                // Output data for each bus
                while ($row = $result->fetch_assoc()) {
                    // Display bus details
                    echo "<div class='bus-details'>";
                    echo "<h4>Bus Name: " . htmlspecialchars($row['bus_name']) . "</h4>";
                    echo "<p>Departure Time: " . htmlspecialchars($row['departure_time']) . "</p>";
                    echo "<p>Arrival Time: " . htmlspecialchars($row['arrival_time']) . "</p>";
                    echo "<p>Fare: INR " . htmlspecialchars($row['fare']) . "</p>";
                    echo "<p>Seats Available: " . htmlspecialchars($row['seats_available']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No details found for this bus.</p>";
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "<p>Invalid bus ID.</p>";
}

// Close the database connection
$conn->close();
?>



 