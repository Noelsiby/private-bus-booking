<?php
include('db.php');
$conn = new mysqli("localhost", "root", "", "private_bus");

if ($conn->connect_error) die(json_encode(['success' => false]));

$data = json_decode(file_get_contents('php://input'), true);
$bus_id = $data['bus_id'];
$seats = $data['seats'];
$booked_by = $data['booked_by'];

foreach ($seats as $seat) {
    $stmt = $conn->prepare("INSERT INTO booked_seats (bus_id, seat_number) VALUES (?, ?)");
    $stmt->bind_param("is", $bus_id, $seat);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
echo json_encode(['success' => true]);
?>
