<?php
include('../config/db.php');
session_start();


if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to update a review.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $review_id = $_POST['review_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];

    
    if (empty($review_id) || empty($rating) || empty($review_text)) {
        echo "All fields are required.";
        exit;
    }

    $user_id = $_SESSION['user_id'];

    
    $sql = "UPDATE reviews SET rating = ?, review_text = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);

    
    if ($stmt === false) {
        echo "Error preparing SQL query: " . $conn->error;
        exit;
    }

    $stmt->bind_param("isii", $rating, $review_text, $review_id, $user_id);
    $stmt->execute();

    
    if ($stmt->affected_rows > 0) {
        echo "Review updated successfully!";
    } else {
      
        echo "Failed to update review or review not found.";
    }

    
    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
    