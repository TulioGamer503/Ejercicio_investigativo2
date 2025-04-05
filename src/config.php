<?php

use React\EventLoop\Loop;
use React\MySQL\Factory;

// Cargamos variables de entorno desde un archivo .env (requiere vlucas/phpdotenv)
// Esto debería hacerse solo una vez al inicio de la aplicación
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Obtenemos la instancia del bucle de eventos
$loop = Loop::get();

// Creamos la fábrica de conexiones
$factory = new Factory();

// Construimos el DSN (Data Source Name) usando variables de entorno
$dsn = sprintf(
    '%s:%s@%s:%d/%s',
    $_ENV['DB_USER'],      // Usuario de la base de datos
    $_ENV['DB_PASSWORD'],  // Contraseña
    $_ENV['DB_HOST'],      // Host (ej. localhost)
    $_ENV['DB_PORT'] ?? 3306, // Puerto (3306 por defecto para MySQL)
    $_ENV['DB_NAME']       // Nombre de la base de datos
);

// Creamos la conexión perezosa
$connection = $factory->createLazyConnection($dsn);

// Retornamos la conexión
return $connection;