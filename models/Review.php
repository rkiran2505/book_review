    <?php
    class Review {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function getReviewsByBook($book_id) {
            $stmt = $this->pdo->prepare("SELECT reviews.*, users.username FROM reviews JOIN users ON reviews.user_id = users.id WHERE reviews.book_id = ?");
            $stmt->execute([$book_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function addReview($book_id, $user_id, $rating, $review_text) {
            $stmt = $this->pdo->prepare("INSERT INTO reviews (book_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)");
            $stmt->execute([$book_id, $user_id, $rating, $review_text]);
        }

        public function updateReview($review_id, $rating, $review_text) {
            $stmt = $this->pdo->prepare("UPDATE reviews SET rating = ?, review_text = ? WHERE id = ?");
            $stmt->execute([$rating, $review_text, $review_id]);
        }

        public function deleteReview($review_id) {
            $stmt = $this->pdo->prepare("DELETE FROM reviews WHERE id = ?");
            $stmt->execute([$review_id]);
        }
    }
    ?>
