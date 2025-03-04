<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro e Inicio de Sesión - Cafetería Jesús Obrero</title>
    <link rel="icon" href="imagenes/cj.png" type="image/png"> <!-- Enlace al favicon -->
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/css/login.css'])
    <!-- Asegúrate de tener un archivo CSS -->
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de tener un archivo CSS -->

</head>

<body>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <x-header>

    </x-header>

    <main>
        

            <form class="form-container">
                <h2 class="j">Iniciar sesión</h2>

                <label for="codigo">Correo:</label>

                <input type="email" id="correo" name="correo" placeholder="Ingrese su correo" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>

                <p id="errorMessage" class="error-message"></p>
                <br>
                <br>
                <a class="htt b" href="{{ route('catalogo') }}"> Iniciar sesión </a>

                <p class="link">
                    ¿Olvidaste tu contraseña?
                    <a href="{{ route('recu') }}">Recuperar aquí</a>
                </p>

                <p class="link">
                    ¿No estás registrado?
                    <a href="{{ route('registro') }}" onclick="showRegisterForm()">Registrate aquí</a>
                </p>
            </form>

    </main>

    <x-footer>

    </x-footer>


    