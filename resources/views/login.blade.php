<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Iniciar Sesion</h1>
    <form action="/login" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif
</body>
</html>
