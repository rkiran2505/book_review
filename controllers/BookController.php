<?php
class BookController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllBooks() {
        $stmt = $this->pdo->query("SELECT * FROM books");
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($books);
    }

    public function addBook($data) {
        $stmt = $this->pdo->prepare("INSERT INTO books (title, author) VALUES (?, ?)");
        $stmt->execute([$data['title'], $data['author']]);
        echo json_encode(['message' => 'Book added successfully']);
    }
}
?>
