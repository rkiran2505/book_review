<?php
include('../config/db.php');
session_start();

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    $sql_reviews = "SELECT id, rating, review_text, user_id FROM reviews WHERE book_id = ?";
    $stmt = $conn->prepare($sql_reviews);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result_reviews = $stmt->get_result();

    while ($review = $result_reviews->fetch_assoc()) {
        echo "<div class='review'>";
        echo "<p>Rating: " . htmlspecialchars($review['rating']) . "/5</p>";
        echo "<p>" . htmlspecialchars($review['review_text']) . "</p>";

        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']) {
            echo "<button onclick='editReview({$review['id']})' class='btn btn-info btn-sm'>Edit</button>";
            echo "<button onclick='deleteReview({$review['id']})' class='btn btn-danger btn-sm'>Delete</button>";
        }

        echo "</div>";
    }
}
?>

<script>

function editReview(reviewId) {
    window.location.href = "edit_review.php?review_id=" + reviewId;
}

function deleteReview(reviewId) {
    if (confirm("Are you sure you want to delete this review?")) {
        $.ajax({
            url: 'delete_review.php', 
            type: 'POST',
            data: { review_id: reviewId },
            success: function(response) {
                if (response === 'success') {
                    alert('Review deleted successfully');
                    location.reload();
                } else {
                    alert('Error deleting review');
                }
            }
        });
    }
}
</script>
