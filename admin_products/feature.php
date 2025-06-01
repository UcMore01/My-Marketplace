<?php
require_once '../auth_check.php';
require_once '../../db_conn.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$pdo->prepare("DELETE FROM featured_products WHERE product_id=?")->execute([$data['product_id']]);
$stmt = $pdo->prepare("INSERT INTO featured_products (product_id, featured_from, featured_to) VALUES (?, ?, ?)");
$success = $stmt->execute([
    $data['product_id'], $data['featured_from'], $data['featured_to']
]);
if ($success) echo json_encode(['success' => true]);
else {
    http_response_code(500);
    echo json_encode(['error' => 'Feature failed']);
}
