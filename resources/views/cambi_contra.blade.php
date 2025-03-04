<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro e Inicio de Sesión - Cafetería Jesús Obrero</title>
    <link rel="icon" href="imagenes/cj.png" type="image/png"> <!-- Enlace al favicon -->
    @vite(entrypoints: [ 'resources/js/app.js','resources/css/login.css'])
    <!-- Asegúrate de tener un archivo CSS -->


</head>

<body>
    <x-header>

    </x-header>
    <form class="form-container">
                <h2 class="j">Cambiar contraseña</h2>
                <label for="newPassword">Nueva contraseña:</label>
                <input type="password" id="newPassword" name="newPassword" placeholder="Ingrese su nueva contraseña"
                    required>
                <label for="confirmPassword">Confirmar contraseña:</label>
                <input type="password" id="confirmPassword" name="confirmPassword"
                    placeholder="Confirme su nueva contraseña" required>
                <br>
                <br>
                <br>
                <a class="htt b" href="{{ route('login') }}">Enviar</a>
                <p class="link">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}" onclick="showLoginForm()">Iniciar sesión</a>
                </p>
            </form>
            <x-footer>

    </x-footer>
                
            </body>