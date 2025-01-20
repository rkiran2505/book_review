<?php
include('../config/db.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to update a review.";
    exit;
}

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get review details from the form
    $review_id = $_POST['review_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];

    // Debugging: Check if data is received
    if (empty($review_id) || empty($rating) || empty($review_text)) {
        echo "All fields are required.";
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Update the review in the database
    $sql = "UPDATE reviews SET rating = ?, review_text = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        echo "Error preparing SQL query: " . $conn->error;
        exit;
    }

    $stmt->bind_param("isii", $rating, $review_text, $review_id, $user_id);
    $stmt->execute();

    // Check if the review was successfully updated
    if ($stmt->affected_rows > 0) {
        echo "Review updated successfully!";
    } else {
        // If no rows are affected, it means the review was not found or the user does not have permission to update it
        echo "Failed to update review or review not found.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
    