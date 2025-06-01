<?php
require_once '../auth_check.php';
require_once '../../db_conn.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$stmt = $pdo->prepare("UPDATE users SET status='active' WHERE user_id=?");
$success = $stmt->execute([$data['seller_id']]);
if ($success) echo json_encode(['success' => true]);
else {
    http_response_code(500);
    echo json_encode(['error' => 'Approve failed']);
}
