<?php
session_start();

// Retrieve journey details from the session if available
$bus_name = isset($_SESSION['bus_name']) ? $_SESSION['bus_name'] : 'N/A';
$departure_time = isset($_SESSION['departure_time']) ? $_SESSION['departure_time'] : 'N/A';
$arrival_time = isset($_SESSION['arrival_time']) ? $_SESSION['arrival_time'] : 'N/A';
$from = isset($_SESSION['from']) ? $_SESSION['from'] : 'N/A';
$to = isset($_SESSION['to']) ? $_SESSION['to'] : 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="payment-style.css">
</head>
<body>
    <div class="payment-container">
        <h1>Payment Information</h1>
        
        <!-- Journey Details -->
        <div class="journey-detail5s">
            <h2>Journey Details</h2>
            <p><strong>From:</strong> <?php echo htmlspecialchars($from); ?></p>
            <p><strong>To:</strong> <?php echo htmlspecialchars($to); ?></p>
            <p><strong>Departure Time:</strong> <?php echo htmlspecialchars($departure_time); ?></p>
            <p><strong>Arrival Time:</strong> <?php echo htmlspecialchars($arrival_time); ?></p>
            <p><strong>Travels:</strong> <?php echo htmlspecialchars($bus_name); ?></p>
        </div>

        <!-- Payment Form -->
        <form action="process-payment.php" method="POST">
            <input type="hidden" name="from" value="<?php echo htmlspecialchars($from); ?>">
            <input type="hidden" name="to" value="<?php echo htmlspecialchars($to); ?>">
            <input type="hidden" name="departure_time" value="<?php echo htmlspecialchars($departure_time); ?>">
            <input type="hidden" name="arrival_time" value="<?php echo htmlspecialchars($arrival_time); ?>">
            <input type="hidden" name="bus_name" value="<?php echo htmlspecialchars($bus_name); ?>">
            <!-- Add payment fields here -->
            <button type="submit">Proceed to Pay</button>
        </form>
    </div>
</body>
</html>

