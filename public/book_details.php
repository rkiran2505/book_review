<?php
include('../config/db.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to add or update a review.";
    exit;
}

// Get the book_id from the URL
$book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;
if ($book_id == 0) {
    echo "No book selected.";
    exit;
}

// Fetch book details (optional, to display on the review page)
$sql_book = "SELECT title FROM books WHERE id = ?";
$stmt = $conn->prepare($sql_book);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result_book = $stmt->get_result();
$book = $result_book->fetch_assoc();

// Check if the user already has a review for this book
$sql_review = "SELECT id, rating, review_text FROM reviews WHERE book_id = ? AND user_id = ?";
$stmt_review = $conn->prepare($sql_review);
$stmt_review->bind_param("ii", $book_id, $_SESSION['user_id']);
$stmt_review->execute();
$result_review = $stmt_review->get_result();
$existing_review = $result_review->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review for <?= htmlspecialchars($book['title']) ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Review for <?= htmlspecialchars($book['title']) ?></h1>

        <?php if ($existing_review): ?>
            <!-- Update or Delete review -->
            <form id="updateReviewForm">
                <input type="hidden" name="review_id" value="<?= $existing_review['id'] ?>">
                <div class="form-group">
                    <label for="rating">Rating (1-5):</label>
                    <input type="number" name="rating" min="1" max="5" value="<?= htmlspecialchars($existing_review['rating']) ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="review_text">Review:</label>
                    <textarea name="review_text" class="form-control" required><?= htmlspecialchars($existing_review['review_text']) ?></textarea>
                </div>

                <form method="POST" action="subdirectory/update_review.php">

                <button type="button" id="deleteReviewBtn" class="btn btn-danger mt-2">Delete Review</button>
            </form>
        <?php else: ?>
            <!-- Add new review -->
            <form id="addReviewForm">
                <div class="form-group">
                    <label for="rating">Rating (1-5):</label>
                    <input type="number" name="rating" min="1" max="5" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="review_text">Review:</label>
                    <textarea name="review_text" class="form-control" required></textarea>
                </div>

                <button type="submit" name="add_review" class="btn btn-primary">Add Review</button>
            </form>
        <?php endif; ?>

        <hr>
        <h3>Reviews</h3>
        <div id="reviewsList">
            <!-- Reviews will be loaded here via AJAX -->
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const bookId = <?= $book_id ?>;

            // Function to load reviews
            function loadReviews() {
                $.ajax({
                    url: 'reviews.php',
                    method: 'GET',
                    data: { book_id: bookId },
                    success: function(response) {
                        $('#reviewsList').html(response);
                    }
                });
            }

            loadReviews(); // Initial load of reviews

            // Handle adding a new review
            $('#addReviewForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize() + '&book_id=' + bookId;

                $.ajax({
                    url: 'add_review.php',
                    method: 'POST',
                    data: formData,
                    success: function() {
                        loadReviews(); // Reload reviews after adding
                        $('#addReviewForm')[0].reset(); // Reset the form
                    }
                });
            });

            // Handle updating an existing review
            $('#updateReviewForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: 'update_review.php',
                    method: 'POST',
                    data: formData,
                    success: function() {
                        loadReviews(); // Reload reviews after updating
                    }
                });
            });

            // Handle deleting a review
            $('#deleteReviewBtn').on('click', function() {
                const reviewId = $('input[name="review_id"]').val();

                $.ajax({
                    url: 'delete_review.php',
                    method: 'POST',
                    data: { review_id: reviewId },
                    success: function() {
                        loadReviews(); // Reload reviews after deletion
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
