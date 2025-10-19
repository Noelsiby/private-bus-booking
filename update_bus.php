<?php
require 'db.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_id = $_POST['bus_id'];
    $bus_name = $_POST['bus_name'];
    $from_place = $_POST['from_location'];
    $to_place = $_POST['to_location'];

    // Update query
    $query = "UPDATE buses SET name=?, from=?, to=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssi', $bus_name, $from_place, $to_place, $bus_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Bus updated successfully.'); window.location.href='manage_buses.php';</script>";
    } else {
        echo "<script>alert('Error updating bus.'); window.location.href='manage_buses.php';</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
