<?php
include('../config/db.php');
session_start();

// Check if the user is logged in and data is available
if (!isset($_SESSION['user_id']) || !isset($_POST['review_id'])) {
    echo "Invalid request.";
    exit;
}

$user_id = $_SESSION['user_id'];
$review_id = $_POST['review_id'];

// Delete the review from the database
$sql_delete = "DELETE FROM reviews WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql_delete);
$stmt->bind_param("ii", $review_id, $user_id);
$stmt->execute();

echo "Review deleted successfully.";
$conn->close();
?>
