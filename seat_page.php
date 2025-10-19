<?php
session_start();
include('db.php');

// Database connection
$conn = new mysqli("localhost", "root", "", "private_bus");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve journey details from URL parameters
$bus_name = isset($_GET['bus_name']) ? $_GET['bus_name'] : '';
$departure_time = isset($_GET['departure_time']) ? $_GET['departure_time'] : '';
$arrival_time = isset($_GET['arrival_time']) ? $_GET['arrival_time'] : '';
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to = isset($_GET['to']) ? $_GET['to'] : '';
$bus_id = isset($_GET['bus_id']) ? $_GET['bus_id'] : '';

// Fetch bus details
if (!empty($bus_id)) {
    $sql = "SELECT * FROM buses WHERE bus_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $bus_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bus = $result->fetch_assoc();
        $bus_name = htmlspecialchars($bus['bus_name']);
    } else {
        echo "<p>No bus details found for this bus.</p>";
        exit();
    }
    
    $stmt->close();
} else {
    echo "<p>Invalid bus ID.</p>";
    exit();
}

// Fetch already booked seats
$booked_seats_query = $conn->prepare("SELECT seat_number FROM booked_seats WHERE bus_id = ?");
$booked_seats_query->bind_param("i", $bus_id);
$booked_seats_query->execute();
$booked_seats_result = $booked_seats_query->get_result()->fetch_all(MYSQLI_ASSOC);
$booked_seats = array_column($booked_seats_result, 'seat_number');

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Allocation - <?php echo $bus_name; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 30px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .deck {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .seat {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #6c757d;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .seat.booked {
            background-color: #dc3545;
            cursor: not-allowed;
        }

        .seat.selected {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h4><?php echo $bus_name; ?> Travels</h4>
        <p><strong>From:</strong> <?php echo htmlspecialchars($from); ?> | 
        <strong>To:</strong> <?php echo htmlspecialchars($to); ?> | 
        <strong>Departure:</strong> <?php echo htmlspecialchars($departure_time); ?> | 
        <strong>Arrival:</strong> <?php echo htmlspecialchars($arrival_time); ?></p>

        <!-- Lower Deck -->
        <h5>Left</h5>
        <div class="deck">
            <?php for ($i = 1; $i <= 15; $i++): ?>
                <div class="seat <?php echo in_array((string)$i, $booked_seats) ? 'booked' : ''; ?>" 
                     data-seat-number="<?php echo $i; ?>" 
                     onclick="toggleSeat(this)">
                    <?php echo $i; ?>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Upper Deck -->
        <h5>Right</h5>
        <div class="deck">
            <?php for ($i = 16; $i <= 30; $i++): ?>
                <div class="seat <?php echo in_array((string)$i, $booked_seats) ? 'booked' : ''; ?>" 
                     data-seat-number="<?php echo $i; ?>" 
                     onclick="toggleSeat(this)">
                    <?php echo $i; ?>
                </div>
            <?php endfor; ?>
        </div>

        <p>Seats: <span id="numSeats">0</span></p>
        <p>Total Price: ₹<span id="totalAmount">0</span></p>

        <div class="mb-3">
            <label for="booked_by" class="form-label">Booked By</label>
            <input type="text" id="booked_by" class="form-control" placeholder="Enter your name" required>
        </div>

        <a id="proceedButton" href="#" class="btn btn-primary disabled">Proceed to Pay</a>
    </div>

    <script>
        
        let selectedSeats = [];
        const busName = "<?php echo urlencode($bus_name); ?>";
        const fromLocation = "<?php echo urlencode($from); ?>";
        const toLocation = "<?php echo urlencode($to); ?>";
        const departureTime = "<?php echo urlencode($departure_time); ?>";
        const arrivalTime = "<?php echo urlencode($arrival_time); ?>";
        const busId = "<?php echo urlencode($bus_id); ?>";
        function toggleSeat(seatElement) {
            if (seatElement.classList.contains('booked')) return;

            const seatNumber = seatElement.getAttribute('data-seat-number');
            const index = selectedSeats.indexOf(seatNumber);

            if (index > -1) {
                selectedSeats.splice(index, 1);
                seatElement.classList.remove('selected');
            } else {
                selectedSeats.push(seatNumber);
                seatElement.classList.add('selected');
            }

            updateTotal();
        }

        function updateTotal() {
            const totalAmount = selectedSeats.length * 500;
            const bookedBy = document.getElementById('booked_by').value.trim();
            document.getElementById('numSeats').textContent = selectedSeats.length;
            document.getElementById('totalAmount').textContent = totalAmount;

            const proceedButton = document.getElementById('proceedButton');
            if (selectedSeats.length > 0) {
                proceedButton.classList.remove('disabled');
                proceedButton.href = `save_booking.php?bus_id=${busId}&seats=${selectedSeats.join(',')}&total=${totalAmount}&bus_name=${busName}&from=${fromLocation}&to=${toLocation}&departure_time=${departureTime}&arrival_time=${arrivalTime}`;
                
            } else {
                proceedButton.classList.add('disabled');
                proceedButton.href = '#';
            }
        }
        document.getElementById('booked_by').addEventListener('input', updateTotal);
    </script>
</body>
</html>
