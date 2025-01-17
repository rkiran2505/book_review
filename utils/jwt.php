<?php
define('JWT_SECRET', 'your-secret-key'); // Use a strong secret key

function generateJWT($user) {
    $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
    $payload = base64_encode(json_encode([
        'id' => $user['id'],
        'username' => $user['username'],
        'exp' => time() + 3600 // Token expiration time (1 hour)
    ]));
    $signature = hash_hmac('sha256', "$header.$payload", JWT_SECRET, true);
    $signature = base64_encode($signature);
    return "$header.$payload.$signature";
}

function validateJWT($jwt) {
    list($header, $payload, $signature) = explode('.', $jwt);
    $valid_signature = base64_encode(hash_hmac('sha256', "$header.$payload", JWT_SECRET, true));
    
    if ($valid_signature === $signature) {
        $decoded_payload = json_decode(base64_decode($payload), true);
        if ($decoded_payload['exp'] > time()) {
            return $decoded_payload;
        }
    }
    return false;
}
?>
