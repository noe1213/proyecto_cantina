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


    <!-- Script para manejar el formulario de confirmación -->
    <script>
    const cartItems = [{
            name: "Café",
            price: 2.00,
            quantity: 1
        },
        {
            name: "Empanada",
            price: 3.00,
            quantity: 1
        },
        {
            name: "Sandwich",
            price: 5.00,
            quantity: 1
        }
    ];

    function displayCartItems() {
        const cartItemsList = document.getElementById('cartItems');
        cartItemsList.innerHTML = '';
        let total = 0;

        cartItems.forEach((item, index) => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `
                    ${item.name} - $${item.price.toFixed(2)} x 
                    <input type="number" value="${item.quantity}" min="1" data-index="${index}" class="quantity-input"> 
                    <button type="button" data-index="${index}" class="btn eliminar" onclick="removeItem(${index})">Eliminar</button>
                `;
            cartItemsList.appendChild(listItem);
            total += item.price * item.quantity;
        });

        document.getElementById('totalPedido').innerText = total.toFixed(2);
    }

    function removeItem(index) {
        cartItems.splice(index, 1);
        displayCartItems();
    }

    document.getElementById('confirmOrderForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const orderNumber = Math.floor(Math.random() * 1000000);
        const confirmationMessage = document.getElementById('confirmationMessage');
        confirmationMessage.innerHTML =
            `¡Felicidades! Tu pedido ha sido confirmado. Tu número de pedido es <strong>${orderNumber}</strong>.`;
        confirmationMessage.classList.remove('hidden');
        document.getElementById('confirmOrderForm').classList.add('hidden');
    });

    document.getElementById('cartItems').addEventListener('input', function(event) {
        if (event.target.classList.contains('quantity-input')) {
            const index = event.target.dataset.index;
            cartItems[index].quantity = parseInt(event.target.value, 10);
            displayCartItems();
        }
    });

    document.getElementById('metodoPago').addEventListener('change', function(event) {
        const metodoPago = event.target.value;
        const pagoMovilForm = document.getElementById('pagoMovilForm');
        if (metodoPago === 'pago-movil') {
            pagoMovilForm.classList.remove('hidden');
        } else {
            pagoMovilForm.classList.add('hidden');
        }
    });

    function cancelOrder() {

        // Aquí puedes agregar la lógica para cancelar el pedido
        location.href = "{{ route('catalogo') }}"; // Redirigir al inicio
    }

    // Mostrar los productos del carrito al cargar la página
    displayCartItems();
    </script>
</body>

</html>