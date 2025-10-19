<?php
session_start();
include('db.php');

$bus_id = $_POST['bus_id'];
$seat_number = $_POST['seat_number'];
$user_id = $_SESSION['user_id'] ?? 1; // Assuming a user system is in place

$conn = new mysqli("localhost", "root", "", "private_bus");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the seat is already booked
$check_query = $conn->prepare("SELECT COUNT(*) AS count FROM booked_seats WHERE bus_id = ? AND seat_number = ?");
$check_query->bind_param("ii", $bus_id, $seat_number);
$check_query->execute();
$check_result = $check_query->get_result()->fetch_assoc();

if ($check_result['count'] > 0) {
    echo "Seat already booked!";
} else {
    // Book the seat
    $book_query = $conn->prepare("INSERT INTO booked_seats (bus_id, seat_number, user_id) VALUES (?, ?, ?)");
    $book_query->bind_param("iii", $bus_id, $seat_number, $user_id);
    $book_query->execute();
    header("Location: seat_page.php?bus_id=" . $bus_id);
}
?>
