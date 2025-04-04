<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="/api/login" method="POST">
        <input type="text" name="usuario" placeholder="Usuario">
        <input type="password" name="password" placeholder="Contraseña">
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
