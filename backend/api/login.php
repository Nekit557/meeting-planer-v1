<?php 

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? null;
if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(['error' => 'Почта и пароль обязательны'], JSON_UNESCAPED_UNICODE);
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Неверная почта или пароль'], JSON_UNESCAPED_UNICODE);
    exit;
}

$apiToken = bin2hex(random_bytes(32));

$stmt = $pdo->prepare('UPDATE users SET api_token = :api_token WHERE id = :id');
$stmt->execute([':api_token' => $apiToken, ':id' => $user['id']]);
http_response_code(200);
echo json_encode([
    'id' => $user['id'],
    'name'=> $user['name'],
    'email' => strtolower(trim($user['email'])), 
    'role' => $user['role'],
    'api_token' => $apiToken
], JSON_UNESCAPED_UNICODE);
exit;


