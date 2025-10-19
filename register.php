<?php
session_start();

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "private_bus";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $phoneno = $_POST['phoneno'];
    $password = $_POST['password'];

    // Check if the phone number is already registered
    $query = "SELECT * FROM users WHERE phoneno = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $phoneno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If phone number exists, redirect to register page with error message
        echo "<script>alert('These details are already registered. Please use different details.'); window.location.href = 'register.html?error=1';</script>";
        exit;
    } else {
        // If phone number does not exist, insert new user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $query = "INSERT INTO users (username, phoneno, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $phoneno, $hashedPassword);

        if ($stmt->execute()) {
            // Registration successful, redirect to login page
            echo "<script>alert('Registration successful!'); window.location.href = 'index.html?registered=1';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}

$conn->close();
?>
