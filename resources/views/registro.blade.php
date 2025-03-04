<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro e Inicio de Sesión - Cafetería Jesús Obrero</title>
    <link rel="icon" href="imagenes/cj.png" type="image/png"> <!-- Enlace al favicon -->
    @vite(['resources/css/login.css'])
    @vite(['resources/css/registro.css', 'resources/js/registro.js'])
</head>
<body>
    <x-header></x-header>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="content">
        <h2 class="section-title">Registrar una cuenta</h2>
        <form id="registration-form" class="product-form" enctype="multipart/form-data">
        
            <!-- Incluir el token CSRF -->
            @csrf

            <div class="input-group">
                <div class="input-half">
                    <label for="ci">Cédula de Identidad</label>
                    <input type="number" id="ci" name="ci" required>
                </div>
                <div class="input-half">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-half">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="input-half">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-half">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" required>
                </div>
                <div class="input-half">
                    <label for="dia_n">Día de Nacimiento</label>
                    <input type="number" id="dia_n" name="dia_n" min="1" max="31" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-half">
                    <label for="mes_n">Mes de Nacimiento</label>
                    <input type="number" id="mes_n" name="mes_n" min="1" max="12" required>
                </div>
                <div class="input-half">
                    <label for="anio_n">Año de Nacimiento</label>
                    <input type="number" id="anio_n" name="anio_n" min="1900" max="2100" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-half">
                    <label for="municipio">Municipio</label>
                    <input type="text" id="municipio" name="municipio" pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras" required>
                </div>
                <div class="input-half">
                    <label for="parroquia">Parroquia</label>
                    <input type="text" id="parroquia" name="parroquia" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-full">
                    <label for="calle">Calle</label>
                    <input type="text" id="calle" name="calle" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-half">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                </div>
                <div class="input-half">
                    <label for="confir_contra">Confirmar Contraseña</label>
                    <input type="password" id="confir_contra" name="confir_contra" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-full">
                    <label for="respuesta_secreta">Pregunta Secreta</label>
                    <input type="text" id="respuesta_secreta" name="respuesta_secreta" required>
                </div>
            </div>

            <div class="botones">
                <button type="submit" class="guardar-btn">Registrarse</button>
                <button type="reset" class="eliminar-btn">Limpiar</button>
            </div>
            <p class="link">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" onclick="showLoginForm()">Iniciar sesión</a>
            </p>
        </form>
    </div>

    <x-footer></x-footer>

    <script>
       
    </script>
</body>
</html>
