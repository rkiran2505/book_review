<?php
include('../config/db.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to submit a review.']);
    exit;
}

// Check if form is submitted via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get review data from the form
    $book_id = $_POST['book_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];
    $user_id = $_SESSION['user_id'];

    // Validate input
    if (empty($rating) || empty($review_text)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    // Insert the review into the database
    $sql = "INSERT INTO reviews (book_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiis', $book_id, $user_id, $rating, $review_text);

    if ($stmt->execute()) {
        // Send success response
        echo json_encode(['status' => 'success', 'message' => 'Review submitted successfully.']);
    } else {
        // Send error response
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit the review. Please try again.']);
    }
}
?>
