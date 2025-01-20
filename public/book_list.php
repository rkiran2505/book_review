<?php
include('../config/db.php');
session_start();

$sql_books = "SELECT id, title, description FROM books";
$result_books = $conn->query($sql_books);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Books List</h1>
        <div class="list-group">
            <?php while ($book = $result_books->fetch_assoc()): ?>
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1"><?= htmlspecialchars($book['title']) ?></h5>
                            <p class="mb-1"><?= htmlspecialchars($book['description']) ?></p>
                        </div>
                        <div>
                            <button class="btn btn-info btn-sm" onclick="showReviews(<?= $book['id'] ?>)">Review Details</button>
                            
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="add_review.php?book_id=<?= $book['id'] ?>" class="btn btn-primary btn-sm ml-2">Add Review</a>
                            <?php endif; ?>
                            
                            <div id="reviews_<?= $book['id'] ?>" style="display:none; margin-top: 10px;"></div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function showReviews(bookId) {
            const reviewContainer = $('#reviews_' + bookId);

            if (reviewContainer.is(':visible')) {
                reviewContainer.hide(); 
                return;
            }

            $.ajax({
                url: 'get_reviews.php',  
                method: 'GET',
                data: { book_id: bookId },
                success: function(response) {
                    reviewContainer.html(response).show();
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
