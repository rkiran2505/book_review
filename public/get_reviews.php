<?php
include('../config/db.php');
session_start();

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Fetch the reviews for the given book
    $sql_reviews = "SELECT id, rating, review_text FROM reviews WHERE book_id = ?";
    $stmt = $conn->prepare($sql_reviews);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result_reviews = $stmt->get_result();

    while ($review = $result_reviews->fetch_assoc()) {
        echo "<div class='review'>";
        echo "<p>Rating: " . htmlspecialchars($review['rating']) . "/5</p>";
        echo "<p>" . htmlspecialchars($review['review_text']) . "</p>";

        // Show update and delete buttons only for the current user's review
        if (isset($_SESSION['user_id'])) {
            echo "<button onclick='editReview({$review['id']})' class='btn btn-info btn-sm'>Edit</button>";
            echo "<button onclick='deleteReview({$review['id']})' class='btn btn-danger btn-sm'>Delete</button>";
        }

        echo "</div>";
    }
}
?>
