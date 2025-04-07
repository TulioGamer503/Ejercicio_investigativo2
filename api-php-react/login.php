<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Simulación de base de datos (en producción usa una base de datos real)
$usuariosValidos = [
    'admin' => password_hash('admin123', PASSWORD_BCRYPT),
];

$data = json_decode(file_get_contents("php://input"), true);

$response = [
    'success' => false,
    'message' => '',
    'token' => null
];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido', 405);
    }

    if (empty($data['usuario']) || empty($data['contrasena'])) {
        throw new Exception('Usuario y contraseña son requeridos', 400);
    }

    $usuario = $data['usuario'];
    $contrasena = $data['contrasena'];

    // Verifica si el usuario existe y la contraseña coincide
    if (array_key_exists($usuario, $usuariosValidos) && 
        password_verify($contrasena, $usuariosValidos[$usuario])) {
        
        // En un sistema real, genera un token JWT aquí
        $token = base64_encode(json_encode([
            'usuario' => $usuario,
            'exp' => time() + 3600 // Expira en 1 hora
        ]));
        
        $response = [
            'success' => true,
            'message' => 'Login exitoso',
            'token' => $token
        ];
        
        http_response_code(200);
    } else {
        throw new Exception('Credenciales inválidas', 401);
    }
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    $response['message'] = $e->getMessage();
} finally {
    echo json_encode($response);
}
?>