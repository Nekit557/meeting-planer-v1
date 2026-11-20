<?php 

$data = json_decode(file_get_contents('php://input'), true);
$name = trim($data['name'] ?? '');
$email = strtolower(trim($data['email'] ??''));
$password = $data['password'] ?? null;

if (empty($name) || empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(['error' => 'Имя, Почта и пароль обязательны']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Неверный формат почты']);
    exit;
}

if (strlen($password) < 6) {
    http_response_code(400);
    echo json_encode(['error' => 'Пароль должен быть не менее 6 символов']);
    exit;
}

$stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
$stmt->execute([':email' => $email]);
$existingUser = $stmt->fetch();


if ($existingUser){
    http_response_code(409);
    echo json_encode(['error' => 'Пользователь с такой почтой уже существует'], JSON_UNESCAPED_UNICODE);
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);


$apiToken = bin2hex(random_bytes(32));

$stmt = $pdo->prepare('INSERT INTO users (name, email, password, api_token) VALUES (:name, :email, :password, :api_token) RETURNING id, name, email, role, api_token');
$stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':password' => $passwordHash,
    ':api_token' => $apiToken
]);
$newUser = $stmt->fetch();
http_response_code(200);
echo json_encode($newUser, JSON_UNESCAPED_UNICODE);
exit;