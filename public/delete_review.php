<?php
include('../config/db.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to delete a review.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = $_POST['review_id'];

    // Validate the review ID
    if ($review_id) {
        $user_id = $_SESSION['user_id'];

        // Delete the review from the database
        $sql = "DELETE FROM reviews WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $review_id, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Review deleted successfully!";
        } else {
            echo "Failed to delete review or review not found.";
        }
    } else {
        echo "Invalid review ID.";
    }
}
?>
