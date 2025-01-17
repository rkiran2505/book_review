<?php
include('../config/db.php');
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to add a review.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = isset($_POST['rating']) ? $_POST['rating'] : null;
    $review_text = isset($_POST['review_text']) ? $_POST['review_text'] : null;
    $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : null;
    
    // Validate inputs
    if ($rating && $review_text && $book_id) {
        $user_id = $_SESSION['user_id'];

        // Insert the new review into the database
        $sql = "INSERT INTO reviews (book_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiis", $book_id, $user_id, $rating, $review_text);
        $stmt->execute();

        echo "Review added successfully!";
    } else {
        echo "All fields are required.";
    }
}
?>
