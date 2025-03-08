<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro e Inicio de Sesión - Cafetería Jesús Obrero</title>
    <link rel="icon" href="imagenes/cj.png" type="image/png">
    @vite(['resources/css/login.css', 'resources/css/registro.css', 'resources/js/registro.js'])
</head>

<body>
    <x-header></x-header>

    <div class="content">
        <h2 class="section-title">Registrar una cuenta</h2>
        <form id="registration-form" class="product-form" method="POST" action="#" enctype="multipart/form-data">
            @csrf

            <!-- Grupo de cédula y correo -->
            <div class="input-group">
                <div class="input-half">
                    <label for="ci">Cédula de Identidad</label>
                    <input type="number" id="ci" name="ci" required placeholder="Ej: 12345678">
                </div>
                <div class="input-half">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" required placeholder="Ej: usuario@ejemplo.com">
                </div>
            </div>

            <!-- Grupo de nombre y apellido -->
            <div class="input-group">
                <div class="input-half">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Ej: Juan">
                </div>
                <div class="input-half">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" required placeholder="Ej: Pérez">
                </div>
            </div>

            <!-- Grupo de teléfono y día de nacimiento -->
            <div class="input-group">
                <div class="input-half">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" required placeholder="Ej: 04121234567">
                </div>
                <div class="input-half">
                    <label for="dia_n">Día de Nacimiento</label>
                    <input type="number" id="dia_n" name="dia_n" min="1" max="31" required placeholder="Ej: 15">
                </div>
            </div>

            <!-- Grupo de mes y año de nacimiento -->
            <div class="input-group">
                <div class="input-half">
                    <label for="mes_n">Mes de Nacimiento</label>
                    <input type="number" id="mes_n" name="mes_n" min="1" max="12" required placeholder="Ej: 7">
                </div>
                <div class="input-half">
                    <label for="anio_n">Año de Nacimiento</label>
                    <input type="number" id="anio_n" name="anio_n" min="1900" max="2100" required
                        placeholder="Ej: 1990">
                </div>
            </div>

            <!-- Grupo de municipio y parroquia -->
            <div class="input-group">
                <div class="input-half">
                    <label for="municipio">Municipio</label>
                    <input type="text" id="municipio" name="municipio" pattern="[A-Za-zÀ-ÿ\s]+"
                        title="Solo se permiten letras y espacios" required placeholder="Ej: Libertador">
                </div>
                <div class="input-half">
                    <label for="parroquia">Parroquia</label>
                    <input type="text" id="parroquia" name="parroquia" required placeholder="Ej: Catedral">
                </div>
            </div>

            <!-- Grupo de calle -->
            <div class="input-group">
                <div class="input-full">
                    <label for="calle">Calle</label>
                    <input type="text" id="calle" name="calle" required placeholder="Ej: Av. Bolívar">
                </div>
            </div>

            <!-- Grupo de contraseñas -->
            <div class="input-group">
                <div class="input-half">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" required placeholder="••••••••">
                </div>
                <div class="input-half">
                    <label for="confir_contra">Confirmar Contraseña</label>
                    <input type="password" id="confir_contra" name="confir_contra" required placeholder="••••••••">
                </div>
            </div>

            <!-- Grupo de pregunta secreta -->
            <div class="input-group">
                <div class="input-full">
                    <label for="respuesta_secreta">Respuesta Secreta</label>
                    <input type="text" id="respuesta_secreta" name="respuesta_secreta" required
                        placeholder="Ej: Nombre de tu mascota">
                </div>
            </div>

            <!-- Botones -->
            <div class="botones">
                <button type="submit" class="guardar-btn">Registrarse</button>
                <button type="reset" class="eliminar-btn">Limpiar</button>
            </div>

            <!-- Enlace a inicio de sesión -->
            <p class="link">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}">Iniciar sesión</a>
            </p>
        </form>
    </div>

    <x-footer></x-footer>
</body>

</html>