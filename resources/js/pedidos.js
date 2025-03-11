document.addEventListener("DOMContentLoaded", () => {
    // Cargar el historial de notificaciones desde localStorage
    cargarHistorialNotificaciones();

    obtenerStockBajo(); // Llama al backend para obtener los productos con stock bajo

    // Maneja el clic en la campanita para mostrar/ocultar notificaciones
    const notificationButton = document.getElementById("notification-button");
    notificationButton.addEventListener("click", () => {
        const notificationList = document.getElementById("notification-list");
        notificationList.style.display =
            notificationList.style.display === "none" ? "block" : "none";

        // Marca las notificaciones nuevas como leídas
        marcarNotificacionesComoLeidas();
    });
});

let notificacionesHistorial = []; // Historial completo de notificaciones
let notificacionesSinLeer = []; // Array para almacenar notificaciones nuevas no leídas

function obtenerStockBajo() {
    fetch("http://127.0.0.1:8000/api/productos/stock-bajo")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Error en el servidor: " + response.statusText);
            }
            return response.json();
        })
        .then((productos) => {
            agregarHistorialNotificaciones(productos);
            if (productos.length > 0) {
                reproducirSonidoAlerta(); // Reproduce el sonido de alerta si hay productos con stock bajo
            }
        })
        .catch((error) => console.error("Error al obtener productos con stock bajo:", error));
}

function agregarHistorialNotificaciones(productos) {
    const notificationBadge = document.getElementById("notification-badge");
    const notificationList = document.getElementById("notification-list");

    productos.forEach((producto) => {
        const mensaje = `${producto.nombre_producto} está bajo el límite de stock`;

        // Si no está ya en el historial, lo añadimos
        if (!notificacionesHistorial.some((notificacion) => notificacion === mensaje)) {
            notificacionesHistorial.push(mensaje); // Añade al historial completo
            notificacionesSinLeer.push(mensaje); // Añade solo las nuevas no leídas

            // Crear el elemento visual de la notificación y agregarlo al área blanca
            const listItem = document.createElement("li");
            listItem.textContent = mensaje;
            listItem.className = "notificacion-item";
            notificationList.appendChild(listItem);
        }
    });

    // Guarda el historial actualizado en localStorage
    guardarHistorialEnLocalStorage();

    // Actualiza el contador de la campanita con las nuevas notificaciones sin leer
    notificationBadge.textContent = notificacionesSinLeer.length;
    notificationBadge.style.display = notificacionesSinLeer.length > 0 ? "inline-block" : "none";
}

function marcarNotificacionesComoLeidas() {
    const notificationBadge = document.getElementById("notification-badge");

    // Vacía las notificaciones no leídas, pero conserva el historial
    notificacionesSinLeer = [];
    notificationBadge.style.display = "none"; // Oculta el badge rojo
}

function cargarHistorialNotificaciones() {
    const notificationList = document.getElementById("notification-list");

    // Carga el historial desde localStorage
    const historialGuardado = JSON.parse(localStorage.getItem("notificacionesHistorial")) || [];
    notificacionesHistorial = historialGuardado;

    // Renderiza las notificaciones guardadas en la lista
    notificacionesHistorial.forEach((mensaje) => {
        const listItem = document.createElement("li");
        listItem.textContent = mensaje;
        listItem.className = "notificacion-item";
        notificationList.appendChild(listItem);
    });
}

function guardarHistorialEnLocalStorage() {
    // Guarda el historial completo en localStorage
    localStorage.setItem("notificacionesHistorial", JSON.stringify(notificacionesHistorial));
}

function reproducirSonidoAlerta() {
    const audio = new Audio("ruta-del-sonido/alerta.mp3"); // Reemplaza con la ruta de tu archivo de sonido
    audio.play();
}

    

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
            body: JSON.stringify({ estado: estado }), // Enviar el nuevo estado en el cuerpo de la solicitud
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
