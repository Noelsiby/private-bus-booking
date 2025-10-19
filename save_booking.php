<?php
session_start();
include('db.php');

// Get the booking details
$bus_id = isset($_GET['bus_id']) ? $_GET['bus_id'] : '';
$seats = isset($_GET['seats']) ? $_GET['seats'] : '';
$total = isset($_GET['total']) ? $_GET['total'] : '';
$bus_name = isset($_GET['bus_name']) ? $_GET['bus_name'] : '';
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to = isset($_GET['to']) ? $_GET['to'] : '';
$departure_time = isset($_GET['departure_time']) ? $_GET['departure_time'] : '';
$arrival_time = isset($_GET['arrival_time']) ? $_GET['arrival_time'] : '';

// Database connection
$conn = new mysqli("localhost", "root", "", "private_bus");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert selected seats into the database
if (!empty($seats) && !empty($bus_id)) {
    $seat_numbers = explode(',', $seats);

    foreach ($seat_numbers as $seat_number) {
        $stmt = $conn->prepare("INSERT INTO booked_seats (bus_id, seat_number) VALUES (?, ?)");
        $stmt->bind_param("is", $bus_id, $seat_number);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect to payment page with details
    header("Location: payment.html?bus_name=" . urlencode($bus_name) . "&from=" . urlencode($from) . "&to=" . urlencode($to) . "&departure_time=" . urlencode($departure_time) . "&arrival_time=" . urlencode($arrival_time) . "&seats=" . urlencode($seats) . "&total=" . urlencode($total));
    exit();
}

$conn->close();
?>
v