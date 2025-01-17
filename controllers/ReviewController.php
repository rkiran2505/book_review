<?php
include('../config/db.php');

class ReviewController {
    public function addReview($userId, $bookId, $rating, $reviewText) {
        global $conn;
        $sql = "INSERT INTO reviews (user_id, book_id, rating, review_text) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiis", $userId, $bookId, $rating, $reviewText);
        $stmt->execute();
    }

    public function updateReview($reviewId, $rating, $reviewText) {
        global $conn;
        $sql = "UPDATE reviews SET rating = ?, review_text = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $rating, $reviewText, $reviewId);
        $stmt->execute();
    }

    public function deleteReview($reviewId) {
        global $conn;
        $sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $reviewId);
        $stmt->execute();
    }
}
?>
