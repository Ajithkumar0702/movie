<?php
// Database Configuration
$dbHost = 'localhost';  // Replace with your database host
$dbUsername = 'root';  // Replace with your database username
$dbPassword = '';  // Replace with your database password
$dbName = 'movie';  // Your database name (sonaconnect)

// Create a database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to utf8 (if necessary)
$conn->set_charset("utf8");
?>
