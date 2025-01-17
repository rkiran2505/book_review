<?php
// Database connection credentials
$dsn = 'mysql:host=localhost;dbname=book_reviews'; // Replace with your database host and name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // To throw exceptions in case of errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Default fetch mode is associative array
);

try {
    // Create the PDO instance
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "Database connection successful!"; // Optional: for debugging purposes
} catch (PDOException $e) {
    // Handle any errors that occur during connection
    die('Connection failed: ' . $e->getMessage());
}

// Include necessary files (update the paths if needed)
include_once('controllers/AuthController.php'); // Update path to controller
include_once('models/User.php'); // Update path to model
include_once('utils/jwt.php'); // Update path to utils

// Pass the PDO instance to AuthController
// $authController = new AuthController($pdo);

// Example of handling a request (this part is just for illustration, customize based on your routes)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if ($action === 'register') {
        $data = json_decode(file_get_contents('php://input'), true);
        $authController->register($data); // Call register method
    } elseif ($action === 'login') {
        $data = json_decode(file_get_contents('php://input'), true);
        $authController->login($data); // Call login method
    } else {
        echo json_encode(['message' => 'Invalid action']);
    }
} else {
    echo json_encode(['message' => 'Invalid request method']);
}
?>
