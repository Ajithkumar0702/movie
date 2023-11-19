<?php

require_once('../database/config.php');


session_start();


if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php"); 
    exit();
}


$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['movie_id'])) {
    $movieID = $_GET['movie_id'];

    $deleteSql = "DELETE FROM movies WHERE id=?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $movieID);

    if ($stmt->execute()) {
        header("Location: ../index/admin_index.php");
    } else {
        echo "Error deleting movie: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Movie ID not provided.";
}


$conn->close();
?>
