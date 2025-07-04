<?php
session_start();
require_once '../../db_conn.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->execute([$username]);
$admin = $stmt->fetch();

if ($admin && password_verify($password, $admin['password_hash'])) {
    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['admin_role'] = $admin['role'];
    echo json_encode(['success' => true]);
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid credentials']);
}
