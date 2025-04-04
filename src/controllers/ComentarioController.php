<?php

use Psr\Http\Message\ServerRequestInterface;
use React\Promise\Promise;

function handleComentarios(ServerRequestInterface $request, $connection)
{
    if ($request->getMethod() === 'GET') {
        return $connection->query('SELECT * FROM comentarios')
            ->then(function ($result) {
                return new React\Http\Message\Response(200, ['Content-Type' => 'application/json'], json_encode($result->resultRows));
            });
    }

    if ($request->getMethod() === 'POST') {
        $body = json_decode((string) $request->getBody(), true);

        return $connection->query('INSERT INTO comentarios (texto) VALUES (?)', [$body['texto']])
            ->then(function () {
                return new React\Http\Message\Response(201, [], "Comentario agregado");
            });
    }

    return new React\Http\Message\Response(405, ['Content-Type' => 'text/plain'], "Método no permitido");
}
