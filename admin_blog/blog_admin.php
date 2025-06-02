<?php
header('Content-Type: application/json');
require_once '../db_conn.php'; // Adjust path

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET': // List all posts
        $stmt = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST': // Add or edit post
        $data = json_decode(file_get_contents('php://input'), true);
        $id = isset($data['id']) ? intval($data['id']) : 0;
        $title = trim($data['title'] ?? '');
        $summary = trim($data['summary'] ?? '');
        $content = trim($data['content'] ?? '');
        $image = trim($data['image'] ?? '');

        if (!$title || !$summary || !$content) {
            http_response_code(400);
            echo json_encode(['error' => 'All fields except image are required.']);
            exit;
        }

        if ($id > 0) { // Edit
            $stmt = $pdo->prepare("UPDATE blog_posts SET title=?, summary=?, content=?, image=? WHERE id=?");
            $stmt->execute([$title, $summary, $content, $image, $id]);
        } else { // Add
            $stmt = $pdo->prepare("INSERT INTO blog_posts (title, summary, content, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $summary, $content, $image]);
        }
        echo json_encode(['success' => true]);
        break;

    case 'DELETE': // Delete post
        parse_str(file_get_contents("php://input"), $data);
        $id = isset($data['id']) ? intval($data['id']) : 0;
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id=?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid id']);
        }
        break;
}
