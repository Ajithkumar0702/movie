<?php
require_once('../database/config.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

// Create connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize $row with default values
$row = ['movie_name' => '', 'director' => '', 'release_year' => '', 'rating' => '', 'language' => ''];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the movie ID from the URL parameter
    $movieID = $_GET['movie_id'];

    // Get new values from the form
    $newMovieName = ($_POST['new_movie_name'] !== '') ? $_POST['new_movie_name'] : $row['movie_name'];
    $newDirector = ($_POST['new_director'] !== '') ? $_POST['new_director'] : $row['director'];
    $newReleaseYear = ($_POST['new_release_year'] !== '') ? $_POST['new_release_year'] : $row['release_year'];
    $newRating = ($_POST['new_rating'] !== '') ? $_POST['new_rating'] : $row['rating'];
    $newLanguage = ($_POST['new_language'] !== '') ? $_POST['new_language'] : $row['language'];


    // Update the movie in the database
    $updateSql = "UPDATE movies SET movie_name=?, director=?, release_year=?, rating=?, language=? WHERE id=?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("sssssi", $newMovieName, $newDirector,  $newReleaseYear, $newRating, $newLanguage, $movieID);

    if ($stmt->execute()) {
        header("Location: ../index/admin_index.php");
    } else {
        echo "Error updating movie: " . $stmt->error;
    }

    $stmt->close();
}

// Retrieve the movie details for the specified ID
$movieID = $_GET['movie_id'];

// Select query using prepared statement
$sql = "SELECT * FROM movies WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movieID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Movie</title>
    <link rel="stylesheet" href="update.css">
</head>
<body>
    <h2>Update Movie</h2>
    
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="new_movie_name">New Movie Name:</label>
        <input type="text" id="new_movie_name" name="new_movie_name" value="<?= $row['movie_name'] ?>" required>

        <label for="new_director">New Director:</label>
        <input type="text" id="new_director" name="new_director" value="<?= $row['director'] ?>" required>

       

        <label for="new_release_year">New Release Year:</label>
        <input type="text" id="new_release_year" name="new_release_year" value="<?= $row['release_year'] ?>" required>

        <label for="new_rating">New Rating:</label>
        <input type="text" id="new_rating" name="new_rating" value="<?= $row['rating'] ?>" required>

        <label for="new_language">New Language:</label>
        <input type="text" id="new_language" name="new_language" value="<?= $row['language'] ?>" required>

        <button type="submit">Update Movie</button>
    </form>
</body>
</html>
