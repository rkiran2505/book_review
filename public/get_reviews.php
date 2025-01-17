<?php
include('../config/db.php');
session_start();

// Check if the user is logged in by verifying if 'user_id' exists in the session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // If not logged in, set $user_id to null

// Check if the book ID is passed via GET
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Query to fetch reviews for the book (including user_id)
    $sql_reviews = "SELECT r.id as review_id, r.rating, r.review_text, u.username, r.user_id 
                    FROM reviews r
                    JOIN users u ON r.user_id = u.id
                    WHERE r.book_id = ?";
    $stmt = $conn->prepare($sql_reviews);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any reviews for the book
    if ($result->num_rows > 0) {
        // Display each review
        while ($review = $result->fetch_assoc()) {
            echo '<div class="card mb-2">';
            echo '<div class="card-body">';
            echo '<h6 class="card-title">' . htmlspecialchars($review['username']) . '</h6>';
            echo '<p class="card-text"><strong>Rating:</strong> ' . $review['rating'] . ' / 5</p>';
            echo '<p class="card-text"><strong>Review:</strong> ' . htmlspecialchars($review['review_text']) . '</p>';

            // If the logged-in user is the one who created the review, show update and delete buttons
            if ($user_id && $review['user_id'] == $user_id) {  // Check if the logged-in user is the owner of the review
                echo '<button class="btn btn-warning btn-sm" onclick="editReview(' . $review['review_id'] . ')">Edit Review</button>';
                echo '<button class="btn btn-danger btn-sm ml-2" onclick="deleteReview(' . $review['review_id'] . ')">Delete Review</button>';
            }
            echo '</div>';
            echo '</div>';
        }
    } else {
        // If no reviews, show a message and the option to add a new review
        if ($user_id) {
            echo '<button class="btn btn-success btn-sm" onclick="addReview(' . $book_id . ')">Add Review</button>';
        }
    }
} else {
    echo '<p>Invalid request.</p>';
}

$conn->close();
?>
