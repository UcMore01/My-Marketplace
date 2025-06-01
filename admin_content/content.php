<?php
require_once '../auth_check.php';
require_once '../../db_conn.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($pdo->query("SELECT * FROM banners")->fetchAll(PDO::FETCH_ASSOC));
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("INSERT INTO banners (title, image_url, link) VALUES (?, ?, ?)");
    $success = $stmt->execute([$data['title'], $data['image_url'], $data['link']]);
    if ($success) echo json_encode(['success' => true]);
    else {
        http_response_code(500);
        echo json_encode(['error' => 'Add failed']);
    }
}
