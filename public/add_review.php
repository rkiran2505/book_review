<?php
include('../config/db.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to add a review.";
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write a Review for <?= htmlspecialchars($book['title']) ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Write a Review for <?= htmlspecialchars($book['title']) ?></h1>

        <form method="POST" action="submit_review.php">
            <input type="hidden" name="book_id" value="<?= $book_id ?>">

            <div class="form-group">
                <label for="rating">Rating (1-5):</label>
                <input type="number" name="rating" min="1" max="5" required class="form-control">
            </div>

            <div class="form-group">
                <label for="review_text">Review:</label>
                <textarea name="review_text" class="form-control" required></textarea>
            </div>

            <button type="submit" name="submit_review" class="btn btn-primary">Submit Review</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
