<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user_id']) || !isset($_GET['review_id'])) {
    header('Location: index.php'); 
    exit();
}

$review_id = $_GET['review_id'];

$sql = "SELECT * FROM reviews WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $review_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Review not found or you do not have permission to edit it.";
    exit();
}

$review = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Review</h1>
        <form action="update_review.php" method="POST">
            <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
            
            <div class="form-group">
                <label for="rating">Rating (1 to 5):</label>
                <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" value="<?= $review['rating'] ?>" required>
            </div>
            
            <div class="form-group">
                <label for="review_text">Review Text:</label>
                <textarea class="form-control" id="review_text" name="review_text" rows="4" required><?= htmlspecialchars($review['review_text']) ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
