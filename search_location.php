<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "private_bus";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $_GET['q'];
$sql = "SELECT * FROM locations WHERE location_name LIKE '%$query%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['location_name'] . "'></option>";
    }
} else {
    echo "<option value='No locations found'></option>";
}

$conn->close();
?>
