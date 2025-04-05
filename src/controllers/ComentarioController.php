<?php

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use React\MySQL\QueryResult;

// Importa funciones del modelo
require_once __DIR__ . '/../models/comentarios.php';

function handleComentarios(ServerRequestInterface $request, $connection)
{
    $method = $request->getMethod();

    if ($method === 'GET') {
        return obtenerComentarios($connection);
    }

    if ($method === 'POST') {
        return crearComentario($request, $connection);
    }

    return new Response(
        405,
        ['Content-Type' => 'text/plain'],
        'Método no permitido'
    );
}
