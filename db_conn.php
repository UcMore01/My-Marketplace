<?php
// Database configuration
$host = 'localhost';
$db   = 'marketplace';
$user = 'your_username';     // Replace!
$pass = 'root';              // Replace!
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // In production, don't show details:
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "A server error occurred. Please try again later."
    ]);
    // Optionally: error_log($e->getMessage());
    exit;
}
?>
