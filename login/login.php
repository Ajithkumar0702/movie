<?php
// Establish a connection to the database (replace with your database credentials)
require_once('../database/config.php'); 

// Start a session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize the input to prevent SQL injection (in a real-world scenario, use prepared statements)
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash the password (you should use a more secure hashing method, like password_hash() in a real-world scenario)
    $hashedPassword = md5($password);

    // Query to check if the username and hashed password match
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$hashedPassword'";
    $result = $conn->query($sql);

    // Check if the query returned a matching user
    if ($result->num_rows > 0) {
        // Store the username in a session variable
        $_SESSION['username'] = $username;
        header("Location: ../index/admin_index.php");

        // You can redirect the user to a dashboard or home page here
    } else {
        echo "Login failed. Invalid username or password.";
    }
} else {
    // Handle the case where the form wasn't submitted using POST
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
