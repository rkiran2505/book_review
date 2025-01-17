<?php
class Book {
    public $id;
    public $title;
    public $author;

    public function __construct($id, $title, $author) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
    }

    public static function getAllBooks($pdo) {
        $stmt = $pdo->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addBook($pdo, $title, $author) {
        $stmt = $pdo->prepare("INSERT INTO books (title, author) VALUES (?, ?)");
        $stmt->execute([$title, $author]);
    }
}
?>
