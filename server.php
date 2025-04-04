<?php

require 'vendor/autoload.php';

use React\Http\HttpServer;
use React\Socket\SocketServer;
use Psr\Http\Message\ServerRequestInterface;
use React\Promise\Promise;
use function React\Promise\resolve;

$connection = require __DIR__ . '/src/config.php';

// Servidor HTTP
$server = new HttpServer(function (ServerRequestInterface $request) use ($connection) {
    $path = $request->getUri()->getPath();

    // Manejo de rutas
    switch ($path) {
        case '/':
            return new React\Http\Message\Response(200, ['Content-Type' => 'text/html'], file_get_contents(__DIR__ . '/src/views/login.php'));

        case '/registro':
            return new React\Http\Message\Response(200, ['Content-Type' => 'text/html'], file_get_contents(__DIR__ . '/src/views/registro.php'));

        case '/api/comentarios':
            return handleComentarios($request, $connection);

        default:
            return new React\Http\Message\Response(404, ['Content-Type' => 'text/plain'], "Página no encontrada");
    }
});

$socket = new SocketServer('0.0.0.0:8080');
$server->listen($socket);

echo "Servidor corriendo en http://localhost:8080\n";
