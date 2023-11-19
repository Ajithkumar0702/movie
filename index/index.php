<?php
// Establish a connection to the database (replace with your database credentials)
require_once('../database/config.php'); 

// Start a session
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Library</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<header>
    <a href="../login/login.html"> Admin Login</a>
    
    <!-- Filter form in the header -->
  
</header>

<form method="post" action="">
        <label for="movie_name">Filter by Movie Name:</label>
        <input type="text" name="movie_name">

        <label for="director">Filter by Director:</label>
        <input type="text" name="director">

        <label for="rating">Filter by Rating (1-10):</label>
        <input type="number" name="rating" min="1" max="10">

        <label for="language">Filter by Language:</label>
        <input type="text" name="language">

        <label for="release_year">Filter by Release Year:</label>
        <input type="number" name="release_year" min="1900" max="2099">

        <input type="submit" value="Apply Filters">
        <a href="./index.php" id="clearFilters">Reset</a>
    </form>
<div id="movie-list">
    <?php
    require_once('../database/config.php');

    // Create connection
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $filterMovieName = $_POST["movie_name"];
        $filterDirector = $_POST["director"];
        $filterRating = $_POST["rating"];
        $filterLanguage = $_POST["language"];
        $filterReleaseYear = $_POST["release_year"];

        // Construct the SQL query based on the selected filters
        $sql = "SELECT * FROM movies WHERE 1=1";
        
        if (!empty($filterMovieName)) {
            $sql .= " AND movie_name LIKE '%$filterMovieName%'";
        }

        if (!empty($filterDirector)) {
            $sql .= " AND director = '$filterDirector'";
        }

        if (!empty($filterRating)) {
            $sql .= " AND rating = '$filterRating'";
        }

        if (!empty($filterLanguage)) {
            $sql .= " AND language = '$filterLanguage'";
        }

        if (!empty($filterReleaseYear)) {
            $sql .= " AND release_year = '$filterReleaseYear'";
        }
    } else {
        // If no filters are applied, retrieve all movies
        $sql = "SELECT * FROM movies";
    }

    $result = $conn->query($sql);

    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
        // Output each movie in a tile format
        while ($row = $result->fetch_assoc()) {
            echo '<div class="movie-tile">';
            
            if (!empty($row['image_path'])) {
                echo '<img src="' . $row['image_path'] . '" alt="' . $row['movie_name'] . '">';
            }
            
            echo '<h2>' . $row['movie_name'] . '</h2>';
            echo '<p>Director: ' . $row['director'] . '</p>';
            echo '<p>Release Year: ' . $row['release_year'] . '</p>';
            echo '<p>Language: ' . $row['language'] . '</p>';
            echo '<p>Rating: ' . $row['rating'] . '</p>';
            // Add update and delete buttons
           
            echo '</div>';
        }
    } else {
        echo "No movies found with the selected filters.";
    }

    // Close connection
    $conn->close();
    ?>
</div>


</body>
</html>
