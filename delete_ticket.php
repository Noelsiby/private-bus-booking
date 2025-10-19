<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.html");
    exit();
}

if (isset($_POST['ticket_id'])) {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "private_bus");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $ticket_id = $_POST['ticket_id'];

    // Delete ticket query
    $sql = "DELETE FROM tickets WHERE ticket_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ticket_id);

    if ($stmt->execute()) {
        header("Location: manage_tickets.php");
        exit();
    } else {
        echo "Error deleting ticket: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
