<?php

$dsn = 'mysql:host=localhost;dbname=book_reviews'; 
$username = 'root'; 
$password = ''; 
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
);

try {
  
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "Database connection successful!"; 
} catch (PDOException $e) {
   
    die('Connection failed: ' . $e->getMessage());
}


include_once('controllers/AuthController.php'); 
include_once('models/User.php');
include_once('utils/jwt.php'); 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if ($action === 'register') {
        $data = json_decode(file_get_contents('php://input'), true);
        $authController->register($data); 
    } elseif ($action === 'login') {
        $data = json_decode(file_get_contents('php://input'), true);
        $authController->login($data); 
    } else {
        echo json_encode(['message' => 'Invalid action']);
    }
} else {
    echo json_encode(['message' => 'Invalid request method']);
}
?>
