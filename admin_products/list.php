<?php
require_once '../auth_check.php';
require_once '../../db_conn.php';
header('Content-Type: application/json');

$stmt = $pdo->query("SELECT p.*, u.username as seller FROM products p JOIN users u ON p.seller_id=u.user_id");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
