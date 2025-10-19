<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "private_bus");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $deleteQuery = "DELETE FROM booked_seats WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Seat booking deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting booking: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Fetch all booked seats
$query = "SELECT * FROM booked_seats";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Booked Seats</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Back to Admin Dashboard Button -->
        <div class="mb-3">
            <a href="admin_dashboard.php" class="btn btn-primary">Back to Admin Dashboard</a>
        </div>

        <h2 class="text-center mb-4">Manage Booked Seats</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Bus ID</th>
                    <th>Seat Number</th>
                    <th>Booked By</th>
                    <th>Booking Time</th>
             
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['bus_id']; ?></td>
                            <td><?php echo $row['seat_number']; ?></td>
                            <!td><!--?php echo $row['booked_by'] ?: 'N/A'; ?--></td-->
                            <td><?php echo $row['booking_time']; ?></td>
                            <td>
                                <!-- Delete Form -->
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No bookings found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
