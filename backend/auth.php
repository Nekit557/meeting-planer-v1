<?php 

function getAuthUser(PDO $pdo){
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
    if (!str_starts_with($authHeader,'Bearer ')){
        http_response_code(401);
        echo json_encode(['error' => 'Требуетяс авторизация'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $token = trim(substr($authHeader, 7));

    if(empty($token)){
        http_response_code(401);
        echo json_encode(['error'=> 'Невалидный токен'], JSON_UNESCAPED_UNICODE);
        exit;}

    $stmt = $pdo->prepare('SELECT id, name, email, role FROM users WHERE api_token = :api_token');
    $stmt->execute([':api_token'=> $token]);
    $user = $stmt->fetch();
    if (!$user) {
        http_response_code(401);
        echo json_encode(['error'=> 'Неверный токен'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    return $user;
}