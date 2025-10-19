<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "private_bus");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Debugging: Check the incoming data
var_dump($data);

// Validate and sanitize inputs
$departure_time = !empty($data['departure_time']) ? $conn->real_escape_string($data['departure_time']) : null;
$arrival_time = !empty($data['arrival_time']) ? $conn->real_escape_string($data['arrival_time']) : null;
$bus_name = !empty($data['bus_name']) ? $conn->real_escape_string($data['bus_name']) : null;
$from = !empty($data['from']) ? $conn->real_escape_string($data['from']) : null;
$to = !empty($data['to']) ? $conn->real_escape_string($data['to']) : null;
$name = !empty($data['name']) ? $conn->real_escape_string($data['name']) : null;
$age = isset($data['age']) ? (int)$data['age'] : null;
$gender = !empty($data['gender']) ? $conn->real_escape_string($data['gender']) : null;
$seats = !empty($data['seats']) ? $conn->real_escape_string($data['seats']) : null;
$ticket = !empty($data['ticket']) ? $conn->real_escape_string($data['ticket']) : null;
$pnr = !empty($data['pnr']) ? $conn->real_escape_string($data['pnr']) : null;

// Prepare and execute the INSERT query
$stmt = $conn->prepare("INSERT INTO tickets (departure_time, arrival_time, bus_name, `from`, `to`, name, age, gender, seats, ticket, pnr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssissss", $departure_time, $arrival_time, $bus_name, $from, $to, $name, $age, $gender, $seats, $ticket, $pnr);

// Execute and check for success
if ($stmt->execute()) {
    echo "Ticket stored successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
