<?php
include('../config/db.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to update a review.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get review details from the form
    $review_id = $_POST['review_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];

    // Validate the inputs
    if ($review_id && $rating && $review_text) {
        $user_id = $_SESSION['user_id'];

        // Update the review in the database
        $sql = "UPDATE reviews SET rating = ?, review_text = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isii", $rating, $review_text, $review_id, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Review updated successfully!";
        } else {
            echo "Failed to update review or review not found.";
        }
    } else {
        echo "All fields are required.";
    }
}
?>
