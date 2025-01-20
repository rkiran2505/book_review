<?php

$book_id = 123; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Book Title</h1>

        <h3>Reviews</h3>
        <div id="reviewsList">
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const bookId = <?= $book_id ?>;

            
            function loadReviews() {
                $.ajax({
                    url: 'get_reviews.php',  
                    method: 'GET',
                    data: { book_id: bookId },  
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#reviewsList').html(response.data); 
                        } else {
                            alert("Error loading reviews.");
                        }
                    },
                    error: function() {
                        alert("Error communicating with the server.");
                    }
                });
            }

            loadReviews();  
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
