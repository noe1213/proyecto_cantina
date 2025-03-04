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
     <!-- Formulario de recuperación de contraseña -->
     <h2>Recuperar cuenta</h2>
     <form class="form-container">
               

                <label for="recoverEmail">Correo electrónico:</label>
                <input type="email" id="recoverEmail" name="recoverEmail" placeholder="Ingrese su correo electrónico"
                    required>
                <br><br>
                <label for="secretQuestion">¿En qué ciudad naciste?</label>

                <input type="text" id="secretQuestion" name="secretQuestion" placeholder="Ingrese su respuesta "
                    required>
                <br>
                <br>
                <a class="htt b" href="{{ route('cambi_contra') }}" onclick="showRecuForm()">Recuperar cuenta</a>


                <p class="link">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}" onclick="showLoginForm()">Iniciar sesión</a>
                </p>
            </form>
            <x-footer>

    </x-footer>
            </body>