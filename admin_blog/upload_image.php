<?php
header('Content-Type: application/json');
$targetDir = "../uploads/blog/";
if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['image']['tmp_name'];
    $fileName = basename($_FILES['image']['name']);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($fileType, $allowed)) {
        http_response_code(400);
        echo json_encode(['error' => 'Unsupported file type.']);
        exit;
    }
    $newName = uniqid('blog_', true) . '.' . $fileType;
    $targetFile = $targetDir . $newName;
    if (move_uploaded_file($fileTmp, $targetFile)) {
        echo json_encode(['success' => true, 'image' => '/uploads/blog/' . $newName]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Upload failed.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded.']);
}
