<?php
include('../config/db.php');
session_start();

// Check if the user is logged in and data is available
if (!isset($_SESSION['user_id']) || !isset($_POST['book_id']) || !isset($_POST['rating']) || !isset($_POST['review_text'])) {
    echo "Invalid request.";
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = $_POST['book_id'];
$rating = $_POST['rating'];
$review_text = $_POST['review_text'];

// Insert the new review into the database
$sql_insert = "INSERT INTO reviews (book_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert);
$stmt->bind_param("iiis", $book_id, $user_id, $rating, $review_text);
$stmt->execute();

echo "Review added successfully.";
$conn->close();
?>
