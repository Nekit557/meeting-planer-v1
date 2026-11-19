<?php

header('Content-Type: application/json, charset=UTF-8');// я узнал что это нужно для того что бы php передавал данные в виде json 

require_once __DIR__ . '/config/db.php';

$stmt = $pdo->query('SELECT id, name FROM categories ORDER BY id');
$categories = $stmt->fetchAll();
echo json_encode($categories, JSON_UNESCAPED_UNICODE);

// я узнал что нужно писать в начале php и для чего это делается