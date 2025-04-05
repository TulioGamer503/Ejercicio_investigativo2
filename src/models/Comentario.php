<?php

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

function obtenerComentarios($db)
{
    return $db->query('SELECT * FROM comentarios')
        ->then(function ($result) {
            return new Response(
                200,
                ['Content-Type' => 'application/json'],
                json_encode($result->resultRows)
            );
        });
}

function crearComentario(ServerRequestInterface $request, $db)
{
    $body = json_decode((string) $request->getBody(), true);
    $texto = $body['texto'] ?? '';
    $tarea_id = $body['tarea_id'] ?? null;
    $usuario_id = $body['usuario_id'] ?? null;

    if (!$texto || !$tarea_id || !$usuario_id) {
        return new Response(400, [], 'Faltan campos requeridos.');
    }

    return $db->query(
        'INSERT INTO comentarios (texto, tarea_id, usuario_id) VALUES (?, ?, ?)',
        [$texto, $tarea_id, $usuario_id]
    )->then(function () {
        return new Response(201, [], 'Comentario creado.');
    });
}
