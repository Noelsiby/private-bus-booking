<?php
// Start session to store selected seat information
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "private_bus");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve bus_id from the URL
$bus_id = isset($_GET['bus_id']) ? $_GET['bus_id'] : '';

$bus_name = '';
$departure_time = '';
$arrival_time = '';
$from = '';
$to = '';

if (!empty($bus_id)) {
    // Query to fetch bus details based on bus_id
    $sql = "SELECT * FROM buses WHERE bus_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $bus_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bus = $result->fetch_assoc();
        // Display bus name or other details if needed
        $bus_name = htmlspecialchars($bus['bus_name']);
        // Assuming you have these details in your bus table
        $departure_time = htmlspecialchars($bus['departure_time']);
        $arrival_time = htmlspecialchars($bus['arrival_time']);
        $from = htmlspecialchars($bus['from_location']);
        $to = htmlspecialchars($bus['to_location']);
    } else {
        echo "<p>No bus details found for this bus.</p>";
        exit();
    }
    $stmt->close();
} else {
    echo "<p>Invalid bus ID.</p>";
    exit();
}

// Handle seat selection form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selected_seat = isset($_POST['selected_seat']) ? $_POST['selected_seat'] : "A1"; // Example seat selected
    $passenger_name = isset($_POST['passenger_name']) ? $_POST['passenger_name'] : "John Doe"; // Get passenger name from form
    $passenger_age = isset($_POST['passenger_age']) ? $_POST['passenger_age'] : 30; // Get passenger age from form
    $passenger_gender = isset($_POST['passenger_gender']) ? $_POST['passenger_gender'] : "Male"; // Get passenger gender from form

    // Redirect to payment page with all details
    echo "<a href='payment_page.php?bus_name=" . urlencode($bus_name) . 
         "&departure_time=" . urlencode($departure_time) . 
         "&arrival_time=" . urlencode($arrival_time) . 
         "&from=" . urlencode($from) . 
         "&to=" . urlencode($to) . 
         "&name=" . urlencode($passenger_name) .  
         "&age=" . urlencode($passenger_age) .    
         "&gender=" . urlencode($passenger_gender) . 
         "&seats=" . urlencode($selected_seat) . 
         "' class='btn btn-primary'>Proceed to Payment</a>"; 

    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Allocation - <?php echo $bus_name; ?></title>
    <link rel="stylesheet" href="stylesss.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h4>&larr; Bus Travels - <?php echo $bus_name; ?></h4>
        <span><a href="/Piechart.html">Pie chart</a></span>
        <hr />

        <!-- Seat Types Information -->
        <div class="seatTypes">
            <h6>Know about Your Seat Types &#9888;</h6>
            <div class="seat2"><span class="typename">Available</span></div>
            <div class="seat2 ladies2"><p class="typename">Available only for ladies</p></div>
            <div class="seat2 bookothers"><p class="typename">Booked by others</p></div>
            <div class="seat2 booked2"><p class="typename">Selected by You</p></div>
            <div class="seat2 ladiesbook"><p class="typename">Booked by female passengers</p></div>
        </div>

        <!-- Lower Deck Seats -->
        <div class="deck lower">
            <h4>Lower deck</h4>
            <div class="seat" data-bs-toggle="tooltip" title="₹120">1</div>
            <div class="seat1"></div>
            <div class="seat ladies">2</div>
            <div class="seat ladies">3</div>
            <div class="seat ladies">4</div>
            <div class="seat ladies">5</div>
            <div class="seat ladies">6</div>
            <div class="seat ladies">7</div>
            <div class="seat ladies">8</div>
            <div class="seat ladies">9</div>
            <div class="seat ladies">10</div>
            <div class="seat ladies">11</div>
            <div class="seat ladies">12</div>
            <div class="seat ladies">13</div>
            <div class="seat ladies">14</div>
            <div class="seat ladies">15</div>
        </div>

        <!-- Upper Deck Seats -->
        <div class="deck upper">
            <h4>Upper deck</h4>
            <div class="seat" data-bs-toggle="tooltip" title="₹90">1</div>
            <div class="seat1"></div>
            <div class="seat ladies">2</div>
            <div class="seat ladies">3</div>
            <div class="seat ladies">4</div>
            <div class="seat ladies">5</div>
            <div class="seat ladies">6</div>
            <div class="seat ladies">7</div>
            <div class="seat ladies">8</div>
            <div class="seat ladies">9</div>
            <div class="seat ladies">10</div>
            <div class="seat ladies">11</div>
            <div class="seat ladies">12</div>
            <div class="seat ladies">13</div>
            <div class="seat ladies">14</div>
            <div class="seat ladies">15</div>
        </div>

        <!-- Total Price Section -->
        <div class="totalprice" id="totalPrice">
            <p>Seats: <span id="numSeats">0</span></p>
            <p>Total Price: ₹<span id="totalAmount">0</span></p>
            <button type="button" class="btn btn-primary" id="continueButton" onclick="showPassengerInfo()">Continue</button>
            <button type="button" class="btn btn-secondary" id="resetButton">Reset</button>
        </div>

        <!-- Passenger Information Form (Hidden until seats selected) -->
        <div class="passenger-info" id="passengerInfoForm" style="display:none;">
            <h5>Enter Passenger Information</h5>
            <form id="passengerForm" method="POST">
                <div class="mb-3">
                    <label for="passengerName" class="form-label">Passenger Name</label>
                    <input type="text" class="form-control" id="passengerName" name="passenger_name" required />
                </div>
                <div class="mb-3">
                    <label for="passengerAge" class="form-label">Age</label>
                    <input type="number" class="form-control" id="passengerAge" name="passenger_age" required />
                </div>
                <div class="mb-3">
                    <label for="passengerGender" class="form-label">Gender</label>
                    <select class="form-select" id="passengerGender" name="passenger_gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <input type="hidden" name="selected_seat" id="selectedSeat" value="" />
                <button type="submit" class="btn btn-success">Proceed to Payment</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="app.js"></script>
    <script>
        // JavaScript function to show passenger information form
        function showPassengerInfo() {
            const selectedSeats = document.querySelectorAll('.seat.selected'); // Assuming you mark selected seats with a class
            const numSeats = selectedSeats.length;
            const totalPrice = numSeats * 120; // Example price per seat

            // Show passenger info form and populate values
            document.getElementById('numSeats').innerText = numSeats;
            document.getElementById('totalAmount').innerText = totalPrice;
            document.getElementById('passengerInfoForm').style.display = 'block';
            document.getElementById('selectedSeat').value = Array.from(selectedSeats).map(seat => seat.innerText).join(', '); // Get selected seats
        }

        // Event listeners for seat selection
        document.querySelectorAll('.seat').forEach(seat => {
            seat.addEventListener('click', function() {
                this.classList.toggle('selected'); // Mark selected
            });
        });

        // Reset button functionality
        document.getElementById('resetButton').addEventListener('click', function() {
            document.querySelectorAll('.seat.selected').forEach(seat => {
                seat.classList.remove('selected'); // Deselect all seats
            });
            document.getElementById('passengerInfoForm').style.display = 'none'; // Hide form
        });
    </script>
</body>
</html>
