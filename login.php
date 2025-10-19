<?php
session_start();
include 'db.php'; // Ensure db.php has the database connection details

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phoneno = $_POST['phoneno'];
    $password = $_POST['password'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT user_id, phoneno, password FROM users WHERE phoneno = ?");
    $stmt->bind_param("s", $phoneno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Check if password matches
        if ($password === $user['password']) {  // Ideally, use password hashing and password_verify() here
            // Set session variables
            $_SESSION['phoneno'] = $user['phoneno'];
            $_SESSION['user_id'] = $user['user_id'];

            // Redirect to booking page
            header("Location: admin_login.html");
            exit;
        } else {
            // Password mismatch, redirect with error
            header("Location: index.html?error=1");
            exit;
        }
    } else {
        // No user found, redirect with error
        header("Location: index.html?error=1");
        exit;
    }

    $stmt->close();
}
$conn->close();
?>


