<?php

$host = "db";
$port = "5432";
$dbname = "meeting_planner";
$user = "postgres";
$password = "secret";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

}catch (PDOException $e) {
    http_response_code(500);
    header('Content-Type: application/json, charset=UTF-8');
    echo json_encode(['error' => 'Ошибка подключения к базе данных: ' . $e->getMessage()]);
    exit;
}

// это инфа как пистаь db php и теперь я знаю как это работает 


