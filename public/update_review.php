<?php
include('../config/db.php');
session_start();

// Check if the user is logged in and data is available
if (!isset($_SESSION['user_id']) || !isset($_POST['review_id']) || !isset($_POST['rating']) || !isset($_POST['review_text'])) {
    echo "Invalid request.";
    exit;
}

$user_id = $_SESSION['user_id'];
$review_id = $_POST['review_id'];
$rating = $_POST['rating'];
$review_text = $_POST['review_text'];

// Update the review in the database
$sql_update = "UPDATE reviews SET rating = ?, review_text = ? WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql_update);
$stmt->bind_param("isii", $rating, $review_text, $review_id, $user_id);
$stmt->execute();

echo "Review updated successfully.";
$conn->close();
?>
