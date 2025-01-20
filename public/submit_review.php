<?php
include('../config/db.php');
session_start();


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to submit a review.']);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $book_id = $_POST['book_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];
    $user_id = $_SESSION['user_id'];

    
    if (empty($rating) || empty($review_text)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    
    $sql = "INSERT INTO reviews (book_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiis', $book_id, $user_id, $rating, $review_text);

    if ($stmt->execute()) {
        
        echo json_encode(['status' => 'success', 'message' => 'Review submitted successfully.']);
    } else {
        
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit the review. Please try again.']);
    }
}
?>
