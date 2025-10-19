<?php
$servername = "localhost";
$username = "root"; // Default username for WAMP; replace if different
$password = ""; // Default password for WAMP; leave empty if no password is set
$dbname = "private_bus"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
