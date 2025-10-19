<?php
session_start();

// Retrieve journey details from the session
$bus_name = isset($_SESSION['bus_name']) ? $_SESSION['bus_name'] : '';
$departure_time = isset($_SESSION['departure_time']) ? $_SESSION['departure_time'] : '';
$arrival_time = isset($_SESSION['arrival_time']) ? $_SESSION['arrival_time'] : '';
$from = isset($_SESSION['from']) ? $_SESSION['from'] : '';
$to = isset($_SESSION['to']) ? $_SESSION['to'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Display Journey Details -->
    <div class="jouarney-details">
        <h4>Journey Details</h4>
        <p><strong>Bus Name:</strong> <?php echo htmlspecialchars($bus_name); ?></p>
        <p><strong>From:</strong> <?php echo htmlspecialchars($from); ?> | 
           <strong>To:</strong> <?php echo htmlspecialchars($to); ?></p>
        <p><strong>Departure:</strong> <?php echo htmlspecialchars($departure_time); ?> | 
           <strong>Arrival:</strong> <?php echo htmlspecialchars($arrival_time); ?></p>
    </div>

    <!-- Payment Form -->
    <div class="payment-section">
        <h4>Payment Details</h4>
        <form action="ticket.php" method="GET">
            <!-- Add payment fields as needed -->
            <button type="submit">Proceed to Ticket Confirmation</button>
        </form>
    </div>



    <script>
        // Extract ticket details from URL parameters
        const params = new URLSearchParams(window.location.search);

        // Passenger Details
        document.getElementById("passengerName").textContent = params.get("name") || "Not Available";
        document.getElementById("passengerAge").textContent = params.get("age") || "Not Available";
        document.getElementById("passengerGender").textContent = params.get("gender") || "Not Available";
        document.getElementById("seatList").textContent = params.get("seats") || "Not Available";

        // Ticket Information
        document.getElementById("ticketNumber").textContent = params.get("ticket") || "Not Available";
        document.getElementById("pnrNumber").textContent = params.get("pnr") || "Not Available";

        // Print Ticket Button
        document.getElementById("printTicketButton").addEventListener("click", function () {
            window.print();  // Trigger the browser's print dialog
        });
    </script>
</body>
</html>
