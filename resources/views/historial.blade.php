<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafetín Jesús Obrero - Historial de Pedidos</title>
    <link rel="icon" href="imagenes/cj.png" type="image/png"> <!-- Enlace al favicon -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/historial.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>
<x-header-cjo2>

</x-header-cjo2>


    <main>
        <section id="historial">
            <div class="filter-container">
                <h2>Historial de pedidos</h2>
                <label for="filterDate">Filtrar por fecha:</label>
                <input type="date" id="filterDate" onchange="filterOrders()">
            </div>

            <table class="order-history">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Precio total</th>
                        <th>Productos</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    <!-- Aquí se llenarán los pedidos -->
                </tbody>
            </table>
        </section>
    </main>

    <x-footer>
        
        </x-footer>
    

    <!-- Script para manejar el historial de pedidos -->
    <script>
        // Ejemplo de datos de pedidos (esto debería venir de tu backend)
        const orders = [
            { dateTime: '2024-11-01T12:30', totalPrice: 25.00, products: ['Café', 'Empanada'] },
            { dateTime: '2024-11-02T14:00', totalPrice: 15.50, products: ['Té', 'Sandwich'] },
            { dateTime: '2024-11-03T09:15', totalPrice: 30.00, products: ['Cachito', 'Jugo'] },
        ];

        function displayOrders(filteredOrders) {
            const orderTableBody = document.getElementById('orderTableBody');
            orderTableBody.innerHTML = ''; // Limpiar tabla

            filteredOrders.forEach(order => {
                const row = document.createElement('tr');
                const productList = order.products.join(', ');
                
                // Separar fecha y hora
                const date = new Date(order.dateTime);
                const formattedDate = date.toLocaleDateString();
                const formattedTime = date.toLocaleTimeString([], { hour12: false });

                row.innerHTML = `
                    <td>${formattedDate}</td>
                    <td>${formattedTime}</td>
                    <td>$${order.totalPrice.toFixed(2)}</td>
                    <td>${productList}</td>`;
                
                orderTableBody.appendChild(row);
            });
        }

        function filterOrders() {
            const filterDate = document.getElementById('filterDate').value;

            if (filterDate) {
                const filteredOrders = orders.filter(order => 
                    new Date(order.dateTime).toISOString().split('T')[0] === filterDate
                );
                displayOrders(filteredOrders);
            } else {
                displayOrders(orders); // Mostrar todos si no hay filtro
            }
        }

        // Inicializar la tabla con todos los pedidos al cargar
        displayOrders(orders);
    </script>

</body>
</html>
