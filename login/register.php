<?php
// Establish a connection to the database (replace with your database credentials)
require_once('../database/config.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the registration form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize the input to prevent SQL injection (in a real-world scenario, use prepared statements)
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash the password (you should use a more secure hashing method, like password_hash() in a real-world scenario)
    $hashedPassword = md5($password);

    // Check if the username already exists in the database
    $checkUserQuery = "SELECT * FROM users WHERE username='$username'";
    $checkUserResult = $conn->query($checkUserQuery);

    if ($checkUserResult->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // Insert the new user into the database
        $insertUserQuery = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

        if ($conn->query($insertUserQuery) === TRUE) {
            echo "Registration successful! You can now <a href='login.html'>login</a>.";
        } else {
            echo "Error: " . $insertUserQuery . "<br>" . $conn->error;
        }
    }
} else {
    // Handle the case where the form wasn't submitted using POST
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
