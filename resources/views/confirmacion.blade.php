<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Pedido - Cafetín Jesús Obrero</title>
    <link rel="icon" href="imagenes/cj.png" type="image/png"> <!-- Enlace al favicon -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/confirmacion.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Encabezado con elementos de navegación -->
    <x-header2>
        <nav class="desktop-nav">
            <ul class="header-nav">
                <li><a href="{{ route('catalogo') }}"><i class="fas fa-concierge-bell"></i> Menú</a></li>
                <li><a href="{{ route('historial') }}"><i class="fas fa-history"></i> Historial</a></li>

            </ul>
        </nav>
        <div class="mobile-menu-icon" onclick="toggleMobileMenu()">
            <i class="fas fa-bars"></i>
        </div>
    </x-header2>
    <br>
    <br>
    <main>
        <section id="confirmar-pedido">

            <div id="confirmationMessage" class="hidden success-message"></div>

            <div class="form-container">
                <form id="confirmOrderForm">
                    <div class="form-group">
                        <center>
                            <h2>Confirmar pedido</h2>
                        </center>

                        <div class="form-group">
                            <label for="metodoPago">Método de pago:</label>
                            <select id="metodoPago" name="metodoPago" required>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta de Débito</option>
                                <option value="pago-movil">Pago Móvil</option>
                            </select>
                        </div>
                        <div id="pagoMovilForm" class="form-group hidden">
                            <p class="co">Datos: <br><br>
                                Banco de Venezuela *0102* <br>
                                Cédula: 10.382.296 <br>
                                Teléfono: 0412-2362000
                            </p>
                            <br><br>
                        </div>
                        <div class="form-group">
                            <h3>Productos en el carrito:</h3>
                            <ul id="cartItems">
                                <!-- Aquí se mostrarán los productos del carrito -->
                            </ul>
                            <h3>Total del pedido: $<span id="totalPedido">0.00</span></h3>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn confirmar">Confirmar pedido</button>
                            <button type="button" class="btn cancelar" onclick="cancelOrder()">Cancelar pedido</button>
                        </div>
                </form>
                <img src="{{ asset('imagenes/pedidos.jpeg') }}" alt="Confirmar Pedido" class="form-image-deco">
            </div>
        </section>
    </main>
    <br>
    <br>
    <br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>


    <x-footer>

    </x-footer>

    @vite(['resources/css/confirmacion.css','resources/js/confirmacion.js'])

    <!-- Script para manejar el formulario de confirmación -->
  
</body>

</html>