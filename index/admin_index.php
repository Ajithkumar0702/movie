<?php

require_once('../database/config.php'); 


session_start();


$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;


$filterMovieName = $filterDirector = $filterRating = $filterLanguage = $filterReleaseYear = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $filterMovieName = $_POST['movie_name'];
    $filterDirector = $_POST['director'];
    $filterRating = $_POST['rating'];
    $filterLanguage = $_POST['language'];
    $filterReleaseYear = $_POST['release_year'];

  
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Library</title>
    <link rel="stylesheet" href="admin_index.css">
</head>
<body>
<header>
     <a href="../login/logout.php" id="logoutButton">Logout</a>
    <a href="../index/admin2.php" id="adminLoginButton">Add movies</a>
    <h1><?= $username ?></h1>
    
    
    
</header>
<!-- Filter form in the header -->
<form method="post" action="">
        <label for="movie_name">Filter by Movie Name:</label>
        <input type="text" name="movie_name" value="<?= $filterMovieName ?>">

        <label for="director">Filter by Director:</label>
        <input type="text" name="director" value="<?= $filterDirector ?>">

        <label for="rating">Filter by Rating (1-10):</label>
        <input type="number" name="rating" min="1" max="10" value="<?= $filterRating ?>">

        <label for="language">Filter by Language:</label>
        <input type="text" name="language" value="<?= $filterLanguage ?>">

        <label for="release_year">Filter by Release Year:</label>
        <input type="number" name="release_year" min="1900" max="2099" value="<?= $filterReleaseYear ?>">

        <input type="submit" value="Apply Filters">
        <a href="./index.php" id="clearFilters">Reset</a>
    </form>

<div id="movie-list">
    <?php
    require_once('../database/config.php');


    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

 
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

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    
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
           
            echo '<a href="update.php?movie_id=' . $row['id'] . '">Update</a>';
            echo '<a href="delete.php?movie_id=' . $row['id'] . '">Delete</a>';
            echo '</div>';
        }
    } else {
        echo "No movies found with the selected filters.";
    }


    $conn->close();
    ?>
</div>

</body>
</html>
