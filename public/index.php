<?php
session_start();
include('../includes/header.php');
?>

<div class="container text-center">
    <h1>Welcome to Book Reviews!</h1>
    <p>Browse and review books from a variety of genres.</p>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- If the user is not logged in, show Register and Login buttons -->
        <a href="register.php" class="btn btn-success">Register</a>
        <a href="login.php" class="btn btn-primary">Login</a>
    <?php else: ?>
        <!-- If the user is logged in, show the Book List button -->
        <a href="book_list.php" class="btn btn-primary">View Book List</a>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
