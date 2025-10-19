<?php
require 'db.php'; // Make sure this file contains your database connection

// Define the default admin credentials
$username = 'admin';
$password = 'admin'; // Default password, hashed for security

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashedPassword);

// Execute and check for success
if ($stmt->execute()) {
    echo "Default admin user created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
