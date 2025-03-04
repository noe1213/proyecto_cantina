<x-head-admin></x-head-admin>
<meta name="csrf-token" content="{{ csrf_token() }}">

<body>
    <x-header-cjoae></x-header-cjoae>

    <main>
        <!-- Interfaz de Administración -->
        <x-menu-admin></x-menu-admin>

        <div class="main-container">
            <div class="content_">
                <h2 class="section-title">Nuevos</h2>
                <div class="contenedor-productos" id="pedido-cards-nuevos">
                    <!-- Aquí se agregarán las tarjetas de pedidos nuevos dinámicamente -->
                </div>
            </div>
            <div class="content_">
                <h2 class="section-title">En Proceso</h2>
                <div class="contenedor-productos" id="pedido-cards-proceso">
                    <!-- Aquí se agregarán las tarjetas de pedidos en proceso dinámicamente -->
                </div>
            </div>
            <div class="content_">
                <h2 class="section-title">Listos</h2>
                <div class="contenedor-productos" id="pedido-cards-listos">
                    <!-- Aquí se agregarán las tarjetas de pedidos listos dinámicamente -->
                </div>
            </div>
        </div>

        <!-- Modal para mostrar detalles del pedido -->
        <div class="modal" id="pedidoModal" style="display:none;">
            <div class="modal-content">
                <span class="close-btn" style="cursor: pointer;">&times;</span>
                <h2>Detalles del Pedido</h2>
                <p><strong>ID del Pedido:</strong> <span id="modal-id-pedido"></span></p>
                <p><strong>CI del Cliente:</strong> <span id="modal-ci-cliente"></span></p>
                <p><strong>Método de Pago:</strong> <span id="modal-metodo-pago"></span></p>
                <p><strong>Productos:</strong> <span id="modal-productos"></span></p>
                <p><strong>Monto Total:</strong> <span id="modal-monto"></span></p>
                <p><strong>Fecha:</strong> <span id="modal-fecha"></span></p>
                <button class="mark-as-button" id="mark-as-in-progress"
                    onclick="markAsStatus(document.getElementById('modal-id-pedido').innerText, 1)">Marcar como en
                    Proceso</button>
                <button class="mark-as-button_" id="mark-as-ready"
                    onclick="markAsStatus(document.getElementById('modal-id-pedido').innerText, 2)">Marcar como
                    Listo</button>
            </div>
        </div>

        <!-- Modal para mostrar detalles del pedido en proceso -->
        <div class="modal" id="pedidoModalProceso" style="display:none;">
            <div class="modal-content">
                <span class="close-btn" style="cursor: pointer;">&times;</span>
                <h2>Detalles del Pedido en Proceso</h2>
                <p><strong>ID del Pedido:</strong> <span id="modal-id-pedido-proceso"></span></p>
                <p><strong>CI del Cliente:</strong> <span id="modal-ci-cliente-proceso"></span></p>
                <p><strong>Método de Pago:</strong> <span id="modal-metodo-pago-proceso"></span></p>
                <p><strong>Productos:</strong> <span id="modal-productos-proceso"></span></p>
                <p><strong>Monto Total:</strong> <span id="modal-monto-proceso"></span></p>
                <p><strong>Fecha:</strong> <span id="modal-fecha-proceso"></span></p>

            </div>
        </div>

        <!-- Modal para mostrar detalles del pedido listo -->
        <div class="modal" id="pedidoModalListo" style="display:none;">
            <div class="modal-content">
                <span class="close-btn" style="cursor: pointer;" data-modal="pedidoModalListo">&times;</span>
                <h2>Detalles del Pedido Listo</h2>
                <p><strong>ID del Pedido:</strong> <span id="modal-id-pedido-listo"></span></p>
                <p><strong>CI del Cliente:</strong> <span id="modal-ci-cliente-listo"></span></p>
                <p><strong>Método de Pago:</strong> <span id="modal-metodo-pago-listo"></span></p>
                <p><strong>Productos:</strong> <span id="modal-productos-listo"></span></p>
                <p><strong>Monto Total:</strong> <span id="modal-monto-listo"></span></p>
                <p><strong>Fecha:</strong> <span id="modal-fecha-listo"></span></p>
            </div>
        </div>
    </main>

    
    <x-footeradmin></x-footeradmin>
    @vite(['resources/css/pedidos.css', 'resources/js/pedidos.js'])
    <script>
        // Función para cerrar cualquier modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none"; // Ocultar el modal
        }

        // Agregar el event listener al botón de cerrar cuando el DOM esté completamente cargado
        document.addEventListener("DOMContentLoaded", () => {
            const closeButtons = document.querySelectorAll(".close-btn");
            closeButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    closeModal(button.closest(".modal").id); // Usar el ID del modal padre
                });
            });
        });
        // Función para obtener todos los pedidos al cargar la página
        function fetchPedidos() {
            fetch("/api/pedidos") // Asegúrate de que esta ruta esté definida en tu API
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Error al obtener pedidos");
                    }
                    return response.json(); // Convertir la respuesta a JSON
                })
                .then((data) => {
                    // Limpiar la lista de pedidos antes de agregar nuevos
                    const pedidoCardsNuevos = document.getElementById(
                        "pedido-cards-nuevos"
                    );
                    const pedidoCardsProceso = document.getElementById(
                        "pedido-cards-proceso"
                    );
                    const pedidoCardsListos = document.getElementById(
                        "pedido-cards-listos"
                    );

                    pedidoCardsNuevos.innerHTML = ""; // Limpiar el contenido existente
                    pedidoCardsProceso.innerHTML = ""; // Limpiar el contenido existente
                    pedidoCardsListos.innerHTML = ""; // Limpiar el contenido existente

                    // Agregar cada pedido a la tarjeta
                    data.forEach((pedido) => {
                        if (pedido.estado_pedido == 0) {
                            addPedidoToCard(pedido, pedidoCardsNuevos);
                        } else if (pedido.estado_pedido == 1) {
                            addPedidoToCard(pedido, pedidoCardsProceso);
                        } else if (pedido.estado_pedido == 2) {
                            addPedidoToCard(pedido, pedidoCardsListos);
                        }
                    });
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        }

        // Función para marcar el pedido como en un estado específico
        function markAsStatus(pedidoId, estado) {
            if (pedidoId) {
                fetch(`/api/pedidos/${pedidoId}/mark-as-status`, {
                        method: "PUT", // Cambiar el estado del pedido
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        body: JSON.stringify({
                            estado: estado
                        }), // Enviar el nuevo estado en el cuerpo de la solicitud
                    })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("Error al actualizar el estado del pedido");
                        }
                        return response.json(); // Convertir la respuesta a JSON
                    })
                    .then((data) => {
                        alert(data.message); // Mostrar mensaje de éxito
                        closeModal("pedidoModal"); // Cerrar el modal

                        fetchPedidos(); // Volver a cargar los pedidos
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
            }
        }

        // Hacer que la función esté disponible globalmente
        window.markAsStatus = markAsStatus;

        // Función para agregar un pedido a la tarjeta
        function addPedidoToCard(pedido, container) {
            const card = document.createElement("div");
            card.className = "producto-card";
            card.onclick = () => showModal(pedido.id_pedido); // Llamar a showModal con el ID del pedido
            card.innerHTML = `
        <h5>ID del Pedido: ${pedido.id_pedido}</h5>
        <p>CI del Cliente: ${pedido.cliente_ci}</p>
    
    `;
            container.appendChild(card); // Agregar la tarjeta a la sección
        }

        // Función para mostrar el modal con detalles del pedido
        function showModal(pedidoId) {
            fetch(`/api/pedidos/${pedidoId}`) // Asegúrate de que esta ruta esté definida en tu API
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Error al obtener detalles del pedido");
                    }
                    return response.json(); // Convertir la respuesta a JSON
                })
                .then((data) => {
                    // Llenar el modal con los datos del pedido
                    document.getElementById("modal-id-pedido").innerText =
                        data.id_pedido;
                    document.getElementById("modal-ci-cliente").innerText =
                        data.cliente_ci;
                    document.getElementById("modal-metodo-pago").innerText =
                        data.metodo_pago;
                    document.getElementById("modal-productos").innerText =
                        data.productos
                        .map((producto) => producto.nombre_producto)
                        .join(", ");
                    document.getElementById("modal-monto").innerText =
                        data.productos.reduce(
                            (total, producto) => total + producto.precio_producto,
                            0
                        );
                    document.getElementById(
                        "modal-fecha"
                    ).innerText = `${data.dia_pedido}/${data.mes_pedido}/${data.anio_pedido}`;

                    // Limpiar botones anteriores para evitar duplicados
                    const modalContent = document.getElementById("pedidoModal");
                    const buttonContainer = document.createElement("div");
                    buttonContainer.className = "modal-buttons"; // Clase para los botones

                    // Agregar botones para cambiar el estado en el modal
                    const buttonInProgress = document.createElement("button");
                    buttonInProgress.innerText = "Marcar como en Proceso";
                    buttonInProgress.onclick = () => markAsStatus(data.id_pedido, 1);
                    buttonInProgress.className = "mark-as-button"; // Clase para el estilo

                    const buttonReady = document.createElement("button");
                    buttonReady.innerText = "Marcar como Listo";
                    buttonReady.onclick = () => markAsStatus(data.id_pedido, 2);
                    buttonReady.className = "mark-as-button"; // Clase para el estilo

                    // Mostrar el modal
                    modalContent.style.display = "block";
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        }

        // Llamar a la función para obtener los pedidos al cargar la página
        window.onload = fetchPedidos;
    </script>

    </html>