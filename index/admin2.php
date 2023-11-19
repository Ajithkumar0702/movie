<?php
// Establish a connection to the database (replace with your database credentials)
require_once('../database/config.php'); 


// Start a session
session_start();

// Initialize $username
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ... (rest of your login logic)
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Upload</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
<?php
if ($username) {
?>


    <header>
      <a href="../login/logout.php">Logout</a>

        <h1><?= $username ?></h1>
    </header>

    <div id="upload-form">
        <form id="movie-form" action="admin.php" method="post" enctype="multipart/form-data">
           

            <label for="movie-name">Movie Name:</label>
            <input type="text" name="movie-name" id="movie-name" required>

            <label for="director">Director:</label>
            <input type="text" name="director" id="director" required>

            <label for="release-year">Release Year:</label>
            <input type="number" name="release-year" id="release-year" required>

            <label for="language">Language:</label>
            <input type="text" name="language" id="language" required>

            <label for="rating">Rating:</label>
            <input type="number" name="rating" id="rating" step="0.1" min="0" max="10" required>

            <button type="submit">Upload Movie</button>
        </form>
    </div>


    <?php
} else {
    echo "Username is not defined. Please log in.";
}
?>
</body>



</html>
