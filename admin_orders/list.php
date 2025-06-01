<?php
require_once '../auth_check.php';
require_once '../../db_conn.php';
header('Content-Type: application/json');

$stmt = $pdo->query("SELECT * FROM orders");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
