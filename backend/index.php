<?php

header('Content-Type: application/json; charset=UTF-8');// я узнал что это нужно для того что бы php передавал данные в виде json 

require_once __DIR__ . '/config/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($method == 'GET' && $path === '/api/categories') {
    $stmt = $pdo->query('SELECT id, name FROM categories ORDER BY id');
    $categories = $stmt->fetchAll();
    echo json_encode($categories, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
    exit;
}

