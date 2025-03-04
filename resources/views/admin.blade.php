<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Cafetín Jesús Obrero</title>
    <link rel="icon" href="imagenes/cj.png" type="image/png"> <!-- Enlace al favicon -->
    @vite(['resources/css/indexlog.css', 'resources/js/app.js','resources/css/p.css','resources/css/p.css'])
    <!-- Asegúrate de tener un archivo CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <style>
        .hidden {
            display: none;
        }

        .contenedor-productos-guardados,
        .contenedor-productos {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            /* Espacio entre los productos */
            width: 100%;
            justify-content: flex-start;
            /* Alinea los productos al inicio */
        }

        /* Añadimos margen inferior para separar las secciones */
        .contenedor-productos-guardados {
            margin-bottom: 40px;
        }

        .producto,
        .product-card {
            border: 1px solid #ccc;
            padding: 15px;
            width: calc(25% - 200px);
            /* Ajustamos el ancho para que quepan 4 productos */
            box-sizing: border-box;
            border-radius: 8px;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            /* Para alinear elementos verticalmente */
            position: relative;
            /* Para posicionar botones al final */
            min-height: 400px;
            /* Altura mínima para mantener consistencia */
        }

        .product-card {
            margin-bottom: 0;
        }

        .producto img,
        .product-card img {
            width: 100%;
            height: 150px;
            /* Altura ajustada */
            object-fit: cover;
            /* Recorta la imagen si es necesario */
            display: block;
            border-radius: 8px 8px 0 0;
            margin-bottom: 10px;
        }

        .producto label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            font-size: 12px;
            /* Tamaño de fuente reducido */
            color: #333;
        }

        /* Estilo de los inputs */
        .producto .input-group,
        .product-card .input-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            /* Espacio horizontal entre inputs */
            flex-wrap: wrap;
        }

        .producto .input-group label,
        .product-card .input-group label {
            width: 100%;
            margin-top: 10px;
        }

        .producto .input-group input[type="text"],
        .producto .input-group input[type="number"],
        .producto .input-group select,
        .product-card .input-group input[type="text"],
        .product-card .input-group input[type="number"] {
            width: 100%;
            padding: 5px 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 12px;
            /* Tamaño de fuente reducido */
            background-color: #fff;
            height: 28px;
            /* Altura ajustada */
        }

        /* Ajustamos los inputs para que sean más anchos y estén en columnas */
        .producto .input-group .input-half,
        .product-card .input-group .input-half {
            width: 48%;
            /* Dos inputs por fila con espacio entre ellos */
        }

        /* Estilos de los headings y textos */
        .product-card h5,
        .product-card h6 {
            font-size: 14px;
            /* Ajustamos el tamaño de fuente */
            margin: 5px 0;
            color: #333;
        }

        /* Estilos para inputs al editar */
        .product-card input[type="text"] {
            margin-bottom: 10px;
        }

        /* Ajustamos las acompanimations */
        .acompanamiento {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }

        .acompanamiento input {
            flex: 1;
            padding: 5px 8px;
            font-size: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            height: 28px;
            margin-right: 5px;
        }

        .acompanamiento button {
            padding: 5px 8px;
            font-size: 12px;
            border: none;
            border-radius: 4px;
            background-color: #dc3545;
            /* Rojo */
            color: #fff;
            cursor: pointer;
            height: 28px;
        }

        .acompanamiento button:hover {
            opacity: 0.9;
        }

        /* Responsividad */
        @media (max-width: 1200px) {

            .producto,
            .product-card {
                width: calc(33.33% - 20px);
                /* 3 productos por fila en pantallas medianas */
            }
        }

        @media (max-width: 768px) {

            .producto,
            .product-card {
                width: calc(50% - 20px);
                /* 2 productos por fila en pantallas pequeñas */
            }
        }

        @media (max-width: 480px) {

            .producto,
            .product-card {
                width: 100%;
                /* 1 producto por fila en pantallas muy pequeñas */
            }
        }

        /* Estilo del buscador */
        .search-input {
            width: 200px;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: left;
        }

        /* Estilos del contenedor principal */
        .content {
            padding: 20px;
        }

        /* Estilos del contenedor del botón agregar y el buscador */
        .add-product-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Estilo del buscador */
        .search-input {
            width: 200px;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Estilo del botón agregar producto */
        .add-product-button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 24px;
        }

        /* Icono de agregar */
        .add-product-button i {
            font-size: 24px;
        }

        /* Estilos de los contenedores de productos */
        .contenedor-productos,
        .contenedor-productos-guardados {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* Estilos de las tarjetas de producto */
        .producto,
        .product-card {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            width: 260px;
            position: relative;
        }

        /* Estilos de las imágenes de producto */
        .producto img,
        .product-card img {
            height: auto;
            cursor: pointer;
            width: 230px;
            /* Ajusta el ancho según tus necesidades */
            height: 230px;
            /* Ajusta la altura según tus necesidades */
            object-fit: cover;
            /* Esto asegurará que la imagen mantenga su proporción y se recorte si es necesario */
        }


        /* Estilos de los grupos de inputs */
        .input-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .input-half {
            flex: 1 1 45%;
        }

        /* Estilos de los botones */
        .botones {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .botones button {
            padding: 8px 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .guardar-btn,
        .save-button {
            background-color: #28a745;
            color: #fff;
        }

        .eliminar-btn,
        .delete-button {
            background-color: #dc3545;
            color: #fff;
        }

        .edit-button {
            background-color: #007bff;
            color: #fff;
        }

        .change-image-button {
            background-color: #17a2b8;
            color: #fff;
        }

        .agregar-acompanamiento-btn {
            background-color: #6c757d;
            color: #fff;
            margin-top: 10px;
            padding: 5px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .search-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .section-title {
            color: #666;
        }

        .order-list {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
        }

        .order-item {
            width: 18%;
            margin: 1%;
            padding: 10px;
            border: 1px solid #ddd;
            cursor: pointer;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            background-image: linear-gradient(to bottom right, #f0f8ff, #e0f7fa);
        }

        .order-item h3 {
            margin: 0;
            color: #333;
        }

        .order-item::before,
        .order-item::after {
            content: '';
            position: absolute;
            top: 0;
            width: 20px;
            height: 100%;
            background-color: #fff;
            border-left: 2px dashed #ddd;
        }

        .order-item::before {
            left: -10px;
        }

        .order-item::after {
            right: -10px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 1% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .close-btn {
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .status-btn {
            background-color: #008cba;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .status-btn:hover {
            background-color: #005f5f;
        }
    </style>

</head>

<body>
    <x-header-cjoae>





    </x-header-cjoae>

    <script>
        function mostrarAlertas() {
            const alertas = document.getElementById('alertas');
            alertas.style.display = alertas.style.display === 'block' ? 'none' : 'block';
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Interfaz de Administración -->
    <main>
        <div class="admin-interface">
            <aside class="sidebar">
                <h2>Menú del administrador</h2>
                <ul class="admin-menu">
                    <li><a href="{{ route('reportes') }}"><i class="fas fa-chart-line"></i>
                            Reportes</a></li>
                    <li><a href="{{ route('clientes') }}"><i class="fas fa-users"></i> Gestionar
                            clientes</a></li>
                    <li><a href="{{ route('productos') }}"><i class="fas fa-utensils"></i> Actualizar/Editar
                            menú</a></li>
                    <li><a href="{{ route('pedidos') }}"><i class="fas fa-utensils"></i> Pedidos
                            registrados</a></li>
                    <li><a href="{{ route('index') }}"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
                </ul>
            </aside>
        </div>



        <section id="reportes" class="content">
            <h2>Reportes</h2>

            <!-- Filtro de Reportes -->
            <div class="filter-container mb-4">
                <label for="calendarFilter">Seleccionar fecha:</label>
                <input type="date" id="calendarFilter" onchange="filterByDate()" class="form-control mx-2" />
            </div>

            <!-- Resumen de Reportes -->
            <div id="summaryReport" class="border p-3 rounded shadow hidden">
                <h3>Resumen del reporte para el:</h3>
                <p id="selectedDate" class="fw-bold"></p>

                <!-- Reporte por categorías de productos -->
                <div class="report hidden" id="mostOrderedReport">
                    <h4>Productos más pedidos:</h4>
                    <ul id="mostOrderedProducts" class="list-group"></ul>
                </div>

                <div class="report hidden" id="leastOrderedReport">
                    <h4>Productos menos pedidos:</h4>
                    <ul id="leastOrderedProducts" class="list-group"></ul>
                </div>

                <div class="report hidden" id="peakSalesReport">
                    <h4>Momentos de más ventas:</h4>
                    <ul id="peakSalesTimes" class="list-group"></ul>
                </div>

                <!-- Resumen de Ganancias -->
                <div id="profitSummary" class="">
                    <h4>Resumen de ganancias:</h4>
                    <p id="profitText"></p>
                </div>

                <!-- Análisis del Reporte -->
                <div id="analysisSummary" class="">
                    <h4>Análisis del reporte:</h4>
                    <p id="analysisText"></p>
                </div>
            </div>
        </section>

        <script>
            // Función para filtrar por fecha seleccionada en el calendario
            function filterByDate() {
                const selectedDate = document.getElementById('calendarFilter').value;

                // Mostrar la fecha seleccionada
                document.getElementById('selectedDate').innerText = selectedDate;

                // Simulación de datos; reemplaza esto con tu lógica real para obtener datos según la fecha seleccionada.

                const mostOrderedProducts = [`Café: 30 pedidos en ${selectedDate}`,
                    `Empanadas: 25 pedidos en ${selectedDate}`
                ];
                const leastOrderedProducts = [`Bebida Energética: 5 pedidos en ${selectedDate}`,
                    `Chicles: 2 pedidos en ${selectedDate}`
                ];
                const peakSalesTimes = [`8:00 AM - 9:00 AM en ${selectedDate}`];

                // Mostrar resultados en base a la fecha seleccionada
                document.getElementById('mostOrderedReport').classList.remove('hidden');
                document.getElementById('leastOrderedReport').classList.remove('hidden');
                document.getElementById('peakSalesReport').classList.remove('hidden');

                // Resumen de ganancias (simulado)
                const totalSales = 1000; // Reemplaza con lógica real
                const totalCosts = 600; // Reemplaza con lógica real
                const profit = totalSales - totalCosts;

                // Mostrar el resumen de ganancias
                document.getElementById('profitText').innerText =
                    `Total Ventas: $${totalSales}, Total Costos: $${totalCosts}, Ganancia: $${profit}`;

                // Análisis del reporte (simulado)
                const analysisText =
                    `El día ${selectedDate} se observó un incremento en las ventas comparado con el día anterior, lo que sugiere una tendencia positiva.`;

                // Actualiza las listas con datos simulados (reemplaza con tus datos reales)
                document.getElementById('mostOrderedProducts').innerHTML = mostOrderedProducts.map(item =>
                    `<li class="list-group-item">${item}</li>`).join('');
                document.getElementById('leastOrderedProducts').innerHTML = leastOrderedProducts.map(item =>
                    `<li class="list-group-item">${item}</li>`).join('');
                document.getElementById('peakSalesTimes').innerHTML = peakSalesTimes.map(item =>
                    `<li class="list-group-item">${item}</li>`).join('');

                // Mostrar el análisis del reporte
                document.getElementById('analysisText').innerText = analysisText;

                // Mostrar el resumen del reporte
                document.getElementById('summaryReport').classList.remove('hidden');
            }
        </script>
        <section id="clientes" class="content hidden">
            <h2>Gestionar clientes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre del usuario</th>
                        <th>Correo electrónico</th>
                        <th>Contraseña</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Juan Pérez</td>
                        <td>juan@example.com</td>
                        <td>******</td>
                        <td><button class="btn editar">Editar</button></td>
                    </tr>
                    <tr>
                        <td>María García</td>
                        <td>maria@example.com</td>
                        <td>******</td>
                        <td><button class="btn editar">Editar</button></td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section id="menu" class="content hidden">
            <h2>Actualizar/Editar Menú</h2>
            <br>

            <!-- Contenedor para el buscador y el botón de agregar -->
            <div class="add-product-container">
                <!-- Buscador -->
                <input type="text" id="searchInput" class="search-input" placeholder="Buscar producto...">
                <!-- Botón para agregar productos -->
                <button type="button" id="agregarProductoBtn" class="add-product-button"
                    style="background: none; border: none; cursor: pointer;">
                    <i class="bi bi-plus-circle" style="font-size: 24px;"></i>
                </button>
            </div>

            <!-- Títulos y contenedores para los productos guardados y en edición -->
            <h3>Productos Guardados</h3>
            <div id="contenedorProductosGuardados" class="contenedor-productos-guardados"></div>

            <h3>Productos en Edición</h3>
            <div id="contenedorProductos" class="contenedor-productos"></div>

            <form id="registerProductosForm" action="{{ route('productos.store') }}" method="POST"
                enctype="multipart/form-data" style="display:none;" onsubmit="return handleRegister(event)">
                @csrf
                <div id="product-template" style="display: none;">
                    <div class="producto">
                        <!-- Imagen del producto -->
                        <img class="imagen" src="{{ asset('imagenes/pedidos.jpeg') }}" alt="Producto">
                        <input type="file" name="imagen" accept="image/*" class="cambiar-imagen" style="display: none;"
                            onchange="previewImage(event)">

                        <!-- Campos del producto -->
                        <div class="input-group">
                            <div class="input-half">
                                <label for="nombreProducto">Nombre:</label>
                                <input id="nombreProducto" name="nombre_producto" type="text" class="nombre" value="">
                            </div>
                            <div class="input-half">
                                <label for="precioProducto">Precio:</label>
                                <input id="precioProducto" name="precio_producto" type="number" class="precio" value="">
                            </div>
                            <div class="input-half">
                                <label for="stockProducto">Stock:</label>
                                <input id="stockProducto" name="stock_producto" type="number" class="stock" value="">
                            </div>
                            <div class="input-half">
                                <label for="minimoPedido">Stock mínimo:</label>
                                <input id="minimoPedido" name="stock_minimo" type="number" class="stock" value="">
                            </div>
                            <div class="input-half">
                                <label for="categoriaProducto">Categoría:</label>
                                <select id="categoriaProducto" name="categoria_producto" class="categoria">
                                    <option value="Combos">Combos</option>
                                    <option value="Bebidas">Bebidas</option>
                                    <option value="Almuerzos">Almuerzos</option>
                                    <option value="Desayunos">Desayunos</option>
                                    <option value="Chuches">Chuches</option>
                                </select>
                            </div>
                            <div class="input-half">
                                <label for="contornoProducto">¿Tiene acompañamientos?</label>
                                <select id="contornoProducto" name="contorno_producto" class="tiene-acompanamiento">
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>
                        </div>

                        <!-- Contenedor de acompañamientos -->
                        <div class="acompanamientos hidden">
                            <!-- Acompañamientos se agregarán aquí dinámicamente -->
                        </div>

                        <!-- Botón para agregar acompañamientos -->
                        <button type="button" class="agregar-acompanamiento-btn hidden">Agregar
                            Acompañamiento</button>

                        <!-- Botones de acción -->
                        <div class="botones">
                            <button type="submit" class="guardar-btn">Guardar</button>
                            <button type="button" class="eliminar-btn">Eliminar</button>
                        </div>
                    </div>
                </div>
            </form>


            <!-- Plantilla del producto guardado (oculta) -->
            <div id="product-saved-template" style="display: none;">
                <div class="product-card">
                    <!-- Imagen del producto -->
                    <img src="imagenes/pan.jpeg" alt="Nombre del producto" class="product-img">
                    <input type="file" class="product-img-input" accept="image/*" style="display: none;">

                    <!-- Nombre del producto -->
                    <h4 class="product-name">Nombre del Producto</h4>
                    <input type="text" class="product-name-input" style="display: none;">

                    <!-- Precio del producto -->
                    <h6 class="product-price">Precio: $10.00</h6>
                    <input type="text" class="product-price-input" style="display: none;">

                    <!-- Stock del producto -->
                    <h6 class="product-stock">Stock: Disponible</h6>
                    <input type="text" class="product-stock-input" style="display: none;">

                    <!-- Acompañantes del producto -->
                    <h6 class="product-accompaniments">Acompañantes: </h6>
                    <input type="text" class="product-accompaniments-input" style="display: none;">

                    <!-- Botones -->
                    <div class="botones">
                        <button type="button" class="change-image-button" style="display: none;">Cambiar
                            Imagen</button>
                        <button type="button" class="save-button" onclick="handleSave()">Guardar</button>
                        <button type="button" class="edit-button" onclick="toggleEdit()">Editar</button>
                        <button type="button" class="delete-button" onclick="handleDelete()">Eliminar</button>
                    </div>

                    <!-- Atributo data-id para identificar el producto -->
                    <input type="hidden" class="product-id" value="">
                </div>
            </div>


        </section>





        <!-- Pedidos registrados -->
        <section id="pedidos" class="content hidden">
            <div class="container">
                <h1 class="header">Gestión de Pedidos</h1>
                <input type="text" id="search" class="search-input" placeholder="Buscar por número de cédula">
                <div id="new-orders">
                    <h2 class="section-title">Pedidos Recientes</h2>
                    <ul id="recent-orders-list" class="order-list"></ul>
                </div>
                <div id="in-process">
                    <h2 class="section-title">Pedidos en Proceso</h2>
                    <ul id="in-process-list" class="order-list"></ul>
                </div>
                <div id="ready-orders">
                    <h2 class="section-title">Pedidos Listos</h2>
                    <ul id="ready-orders-list" class="order-list"></ul>
                </div>
            </div>

            <div id="order-details-modal" class="modal">
                <div class="modal-content">
                    <span class="close-btn">&times;</span>
                    <h2>Detalles del Pedido</h2>
                    <p id="order-details"></p>
                    <button id="status-btn" class="status-btn"></button>
                </div>
            </div>

    </main>

    <!-- <script>
        const orders = [{
                orderCode: "001",
                userName: "Juan Pérez",
                items: ["Café", "Empanada"],
                total: 5.00,
                paymentMethod: "Efectivo"
            },
            {
                orderCode: "002",
                userName: "María García",
                items: ["Sandwich", "Jugo"],
                total: 8.00,
                paymentMethod: "Tarjeta"
            },
            {
                orderCode: "003",
                userName: "Carlos Ruiz",
                items: ["Café", "Torta"],
                total: 6.50,
                paymentMethod: "Pago Móvil"
            },
            {
                orderCode: "004",
                userName: "Ana López",
                items: ["Tequeños", "Refresco"],
                total: 7.00,
                paymentMethod: "Efectivo"
            },
            {
                orderCode: "005",
                userName: "Luis Méndez",
                items: ["Panini", "Agua"],
                total: 4.50,
                paymentMethod: "Tarjeta"
            },
        ];

        function displayOrders() {
            const orderList = document.getElementById('orderList');
            orderList.innerHTML = '';

            orders.forEach(order => {
                const link = document.createElement('a');
                link.href = '#';
                link.innerText = order.orderCode;
                link.onclick = () => showDetails(order.orderCode);
                orderList.appendChild(link);
            });
        }

        function showDetails(orderCode) {
            const order = orders.find(o => o.orderCode === orderCode);
            document.getElementById('orderUserName').innerText = `Nombre del usuario: ${order.userName}`;
            document.getElementById('orderItems').innerText = `Pedido: ${order.items.join(', ')}`;
            document.getElementById('orderTotal').innerText = `Total: $${order.total.toFixed(2)}`;
            document.getElementById('orderPaymentMethod').innerText = `Método de pago: ${order.paymentMethod}`;
            document.getElementById('orderDetails').classList.remove('hidden');
            document.getElementById('orderDetails').style.display = 'block';
        }

        function closeDetails() {
            document.getElementById('orderDetails').classList.add('hidden');
            document.getElementById('orderDetails').style.display = 'none';
        }

        function searchOrders() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const filteredOrders = orders.filter(order => order.orderCode.toLowerCase().includes(searchInput));
            const orderList = document.getElementById('orderList');
            orderList.innerHTML = '';

            filteredOrders.forEach(order => {
                const link = document.createElement('a');
                link.href = '#';
                link.innerText = order.orderCode;
                link.onclick = () => showDetails(order.orderCode);
                orderList.appendChild(link);
            });
        }

        // Mostrar los pedidos al cargar la página
        displayOrders();
    </script> -->

    <!-- <script>
        let productosGuardados = [];

        function guardarProducto(id) {
            const nombre = document.getElementById(`nombre${id}`).value;
            const precio = document.getElementById(`precio${id}`).value;
            const stock = document.getElementById(`stock${id}`).value;
            const imagenSrc = document.getElementById(`imagen${id}`).src;
            const acompanamientos = Array.from(document.querySelectorAll(`#acompanamientos${id} .acompanamiento input`))
                .map(input => input.value);

            const producto = {
                id,
                nombre,
                precio,
                stock,
                imagenSrc,
                acompanamientos
            };

            // Si el producto ya existe en productosGuardados, lo actualizamos
            const index = productosGuardados.findIndex(producto => producto.id === id);
            if (index !== -1) {
                productosGuardados[index] = producto;
            } else {
                productosGuardados.push(producto);
            }

            mostrarProductosGuardados();

        }

        function eliminarProducto(id) {
            productosGuardados = productosGuardados.filter(producto => producto.id !== id);
            mostrarProductosGuardados();

        }

        function mostrarProductosGuardados() {
            const contenedor = document.getElementById('productosGuardados');
            contenedor.innerHTML = '';

            productosGuardados.forEach((producto, index) => {
                const div = document.createElement('div');
                div.className = 'producto-guardado';
                div.innerHTML = `
            <img id="imagenGuardado${producto.id}" src="${producto.imagenSrc}" alt="${producto.nombre}">
            <input type="file" class="edit-imagen hidden" id="cambiarImagenGuardado${producto.id}" onchange="cambiarImagenGuardado(event, ${producto.id})">
            <label for="cambiarImagenGuardado${producto.id}" class="image-label">Cambiar Imagen</label>
            <div class="info">
                <span><strong>Nombre:</strong> <input type="text" id="nombreGuardado${producto.id}" value="${producto.nombre}" disabled></span>
                <span><strong>Precio:</strong> <input type="number" id="precioGuardado${producto.id}" value="${producto.precio}" disabled></span>
                <span><strong>Stock:</strong> <input type="number" id="stockGuardado${producto.id}" value="${producto.stock}" disabled></span>
                <span><strong>Acompañamientos:</strong> <div id="acompanamientosGuardados${producto.id}">${producto.acompanamientos.map((acom, acomIndex) => `
                    <div class="acompanamiento">
                        <input type="text" value="${acom}" disabled>
                        <button type="button" class="hidden" onclick="quitarAcompanamientoGuardado(${producto.id}, ${acomIndex})">X</button>
                    </div>
                `).join('')}</div></span>
            </div>
            <div class="buttons">
                <button type="button" onclick="editarProducto(${producto.id})">Editar</button>
                <button type="button" class="hidden" id="guardarEdicionBtn${producto.id}" onclick="guardarEdicion(${producto.id})">Guardar</button>
                <button type="button" class="delete" onclick="eliminarProducto(${producto.id})">Eliminar</button>
            </div>
        `;
                contenedor.appendChild(div);
            });
        }

        function editarProducto(id) {
            document.getElementById(`nombreGuardado${id}`).disabled = false;
            document.getElementById(`precioGuardado${id}`).disabled = false;
            document.getElementById(`stockGuardado${id}`).disabled = false;
            document.getElementById(`cambiarImagenGuardado${id}`).classList.remove('hidden');
            document.getElementById(`guardarEdicionBtn${id}`).classList.remove('hidden');
            document.querySelector(`button[onclick="editarProducto(${id})"]`).classList.add('hidden');

            const acompanamientosDiv = document.getElementById(`acompanamientosGuardados${id}`);
            acompanamientosDiv.querySelectorAll('.acompanamiento input').forEach(input => input.disabled = false);
            acompanamientosDiv.querySelectorAll('.acompanamiento button').forEach(button => button.classList.remove(
                'hidden'));
        }

        function guardarEdicion(id) {
            const nombre = document.getElementById(`nombreGuardado${id}`).value;
            const precio = document.getElementById(`precioGuardado${id}`).value;
            const stock = document.getElementById(`stockGuardado${id}`).value;
            const imagenSrc = document.getElementById(`imagenGuardado${id}`).src;
            const acompanamientos = Array.from(document.querySelectorAll(
                `#acompanamientosGuardados${id} .acompanamiento input`)).map(input => input.value);

            const producto = {
                id,
                nombre,
                precio,
                stock,
                imagenSrc,
                acompanamientos
            };

            const index = productosGuardados.findIndex(producto => producto.id === id);
            if (index !== -1) {
                productosGuardados[index] = producto;
            }

            mostrarProductosGuardados();
            alert(`Producto ${id} actualizado.`);
        }

        function cambiarImagen(event, id) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.getElementById(`imagen${id}`);
                img.src = reader.result;
            };
            reader.readAsDataURL(input.files[0]);
        }

        function cambiarImagenGuardado(event, id) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.getElementById(`imagenGuardado${id}`);
                img.src = reader.result;

                const producto = productosGuardados.find(producto => producto.id === id);
                if (producto) {
                    producto.imagenSrc = reader.result;
                }
            };
            reader.readAsDataURL(input.files[0]);

            // Ocultar el nombre del archivo subido
            input.nextElementSibling.style.display = 'none';
        }

        function agregarAcompanamiento(id) {
            const div = document.createElement('div');
            div.className = 'acompanamiento';
            div.innerHTML = `
        <input type="text" placeholder="Escribe un acompañamiento">
        <button  onclick="quitarAcompanamiento(this)">X</button>
    `;
            document.getElementById(`acompanamientos${id}`).appendChild(div);
        }

        function agregarAcompanamientoGuardado(id) {
            const div = document.createElement('div');
            div.className = 'acompanamiento';
            div.innerHTML = `
        <input type="text" placeholder="Escribe un acompañamiento">
        <button type="button" onclick="quitarAcompanamiento(this)">X</button>
    `;
            document.getElementById(`acompanamientosGuardados${id}`).appendChild(div);
        }

        function quitarAcompanamiento(button) {
            button.parentElement.remove();
        }

        function quitarAcompanamientoGuardado(id, index) {
            productosGuardados = productosGuardados.map(producto => {
                if (producto.id === id) {
                    producto.acompanamientos.splice(index, 1);
                }
                return producto;
            });
            mostrarProductosGuardados();
        }

        function toggleAcompanamientos(id) {
            const select = document.getElementById(`tieneAcompanamiento${id}`);
            const acompanamientosDiv = document.getElementById(`acompanamientos${id}`);
            const agregarAcompanamientoBtn = document.getElementById(`agregarAcompanamientoBtn${id}`);

            if (select.value === 'si') {
                acompanamientosDiv.classList.remove('hidden');
                agregarAcompanamientoBtn.classList.remove('hidden');
            } else {
                acompanamientosDiv.classList.add('hidden');
                agregarAcompanamientoBtn.classList.add('hidden');
            }
        }
    </script> -->

    <x-footer>

    </x-footer>

    <!-- Script para manejar la navegación -->
    <!-- <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.content');
            sections.forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById(sectionId).classList.remove('hidden');
        }
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const recentOrdersList = document.getElementById('recent-orders-list');
            const inProcessList = document.getElementById('in-process-list');
            const readyOrdersList = document.getElementById('ready-orders-list');
            const orderDetailsModal = document.getElementById('order-details-modal');
            const orderDetails = document.getElementById('order-details');
            const statusBtn = document.getElementById('status-btn');
            const closeBtn = document.querySelector('.close-btn');

            const orders = [{
                    id: 1,
                    user: 'Gaby vivas',
                    cedula: '31288691',
                    metodoPago: 'Tarjeta de Crédito',
                    productos: ['Producto A', 'Producto B'],
                    montos: ['12$', '30$'],
                    fecha: '2025-02-09',
                    total: '42$'
                },
                {
                    id: 2,
                    user: 'juan perez',
                    cedula: '12345678',
                    metodoPago: 'Tarjeta de Crédito',
                    productos: ['Producto A', 'Producto B'],
                    montos: ['10$', '20$'],
                    fecha: '2025-02-09',
                    total: '30S$'
                },
                {
                    id: 3,
                    user: 'viki gudiño',
                    cedula: '32865156',
                    metodoPago: 'Tarjeta de Crédito',
                    productos: ['Producto A', 'Producto B'],
                    montos: ['10$', '20$'],
                    fecha: '2025-02-09',
                    total: '30$'
                },
                // Agrega más pedidos aquí
            ];

            function renderOrders() {
                recentOrdersList.innerHTML = '';
                orders.forEach(order => {
                    const orderItem = document.createElement('li');
                    orderItem.className = 'order-item';
                    orderItem.innerHTML =
                        `<h3>Orden: #${order.id}</h3><p>Cédula: ${order.cedula.slice(-3)}</p>`;
                    orderItem.addEventListener('click', function() {
                        showOrderDetails(order);
                    });
                    recentOrdersList.appendChild(orderItem);
                });
            }

            function showOrderDetails(order) {
                orderDetails.innerHTML = `
            <p>Nombre: ${order.user}</p>
            <p>Método de Pago: ${order.metodoPago}</p>
            <p>Productos: ${order.productos.join(', ')}</p>
            <p>Montos: ${order.montos.join(', ')}</p>
            <p>Fecha: ${order.fecha}</p>
            <p>Total: ${order.total}</p>
        `;
                if ([...inProcessList.children].some(item => item.textContent.includes(`Orden: #${order.id}`))) {
                    statusBtn.textContent = 'Marcar como Listo';
                    statusBtn.onclick = function() {
                        moveToReady(order);
                    };
                    statusBtn.classList.remove('hidden');
                } else if ([...readyOrdersList.children].some(item => item.textContent.includes(
                        `Orden: #${order.id}`))) {
                    statusBtn.classList.add('hidden');
                } else {
                    statusBtn.textContent = 'Marcar como En Proceso';
                    statusBtn.onclick = function() {
                        moveToInProcess(order);
                    };
                    statusBtn.classList.remove('hidden');
                }
                orderDetailsModal.style.display = 'block';
            }

            function moveToInProcess(order) {
                const orderItem = [...recentOrdersList.children].find(item => item.textContent.includes(
                    `Orden: #${order.id}`));
                if (orderItem) {
                    recentOrdersList.removeChild(orderItem);
                }
                const processItem = document.createElement('li');
                processItem.className = 'order-item';
                processItem.innerHTML = `<h3>Orden: #${order.id}</h3><p>Cédula: ${order.cedula.slice(-3)}</p>`;
                processItem.addEventListener('click', function() {
                    showOrderDetails(order);
                });
                inProcessList.appendChild(processItem);
                orderDetailsModal.style.display = 'none';
            }

            function moveToReady(order) {
                const orderItem = [...inProcessList.children].find(item => item.textContent.includes(
                    `Orden: #${order.id}`));
                if (orderItem) {
                    inProcessList.removeChild(orderItem);
                }
                const readyItem = document.createElement('li');
                readyItem.className = 'order-item';
                readyItem.innerHTML = `<h3>Orden: #${order.id}</h3><p>Cédula: ${order.cedula.slice(-3)}</p>`;
                readyItem.addEventListener('click', function() {
                    showOrderDetails(order);
                });
                readyOrdersList.appendChild(readyItem);
                orderDetailsModal.style.display = 'none';
                statusBtn.classList.add('hidden');
            }

            searchInput.addEventListener('input', function() {
                const searchValue = searchInput.value.toLowerCase();
                recentOrdersList.innerHTML = '';
                orders.filter(order => order.cedula.includes(searchValue)).forEach(order => {
                    const orderItem = document.createElement('li');
                    orderItem.className = 'order-item';
                    orderItem.innerHTML =
                        `<h3>Orden: #${order.id}</h3><p>Cédula: ${order.cedula.slice(-3)}</p>`;
                    orderItem.addEventListener('click', function() {
                        showOrderDetails(order);
                    });
                    recentOrdersList.appendChild(orderItem);
                });
            });

            closeBtn.onclick = function() {
                orderDetailsModal.style.display = 'none';
            };

            window.onclick = function(event) {
                if (event.target == orderDetailsModal) {
                    orderDetailsModal.style.display = 'none';
                }
            };

            renderOrders();
        });
    </script> -->
</body>

</html>