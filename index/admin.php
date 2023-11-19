<?php
// Replace these variables with your actual database credentials
require_once('../database/config.php');

// Function to sanitize input data
function sanitizeInput($conn, $data) {
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}

// Function to handle file upload
function uploadFile($file) {
    $target_dir = "./";
    $target_file = $target_dir . basename($file["name"]);
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        // Log the error or handle it appropriately
        return null;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $movieName = sanitizeInput($conn, $_POST["movie-name"]);
    $director = sanitizeInput($conn, $_POST["director"]);
    $releaseYear = sanitizeInput($conn, $_POST["release-year"]);
    $language = sanitizeInput($conn, $_POST["language"]);
    $rating = sanitizeInput($conn, $_POST["rating"]);

    // Handle image upload
    $imagePath = "default.jpg"; // Provide a default image path if no image is uploaded

    

    // SQL query to insert data into the database using prepared statements
    $sql = "INSERT INTO movies (movie_name, director, release_year, language, rating, image_path) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $movieName, $director, $releaseYear, $language, $rating, $imagePath);

    if ($stmt->execute()) {
        header("Location: ../index/admin_index.php");
        
    } else {
        // Log the error or handle it appropriately
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
