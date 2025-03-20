import Swal from "sweetalert2";

// Inicializar la tabla de productos y verificar notificaciones al cargar la página
window.onload = () => {
    fetchProducts();
     
};
document.addEventListener("DOMContentLoaded", () => {
    // Cargar el historial de notificaciones desde localStorage
    cargarHistorialNotificaciones();

    // Comenzar el polling: llama al backend cada 25 segundos
    setInterval(() => {
        obtenerStockBajo(); // Llama al backend periódicamente
    }, 25000); // Intervalo de 25 segundos

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

let notificacionesHistorial = {}; // Historial completo de notificaciones (basado en IDs y estados)
let notificacionesSinLeer = []; // Array para manejar las notificaciones no leídas

function obtenerStockBajo() {
    fetch("http://127.0.0.1:8000/api/productos/stock-bajo") // Cambia la URL según tu API
        .then((response) => {
            if (!response.ok) {
                throw new Error("Error en el servidor: " + response.statusText);
            }
            return response.json();
        })
        .then((productos) => {
            procesarProductosConStockBajo(productos); // Procesa los productos recibidos
        })
        .catch((error) => console.error("Error al obtener productos con stock bajo:", error));
}

function procesarProductosConStockBajo(productos) {
    const notificationBadge = document.getElementById("notification-badge");
    const notificationList = document.getElementById("notification-list");

    if (productos.length === 0) {
        // Notificación si no hay productos con stock bajo
        if (!notificacionesHistorial["sin_stock_bajo"]) {
            notificacionesHistorial["sin_stock_bajo"] = true;

            const mensaje = "No hay productos con stock bajo";
            const listItem = document.createElement("li");
            listItem.textContent = mensaje;
            listItem.className = "notificacion-item normalizado";

            const removeButton = document.createElement("button");
            removeButton.textContent = "✖";
            removeButton.className = "remove-notification-button";
            removeButton.addEventListener("click", () => {
                listItem.remove();
                delete notificacionesHistorial["sin_stock_bajo"];
                guardarHistorialEnLocalStorage();
            });

            listItem.appendChild(removeButton);
            notificationList.appendChild(listItem);
        }
        guardarHistorialEnLocalStorage();
        actualizarContadorNotificaciones(); // Asegura que el contador refleje las notificaciones
        return; // Detén el procesamiento si no hay productos con stock bajo
    }

    productos.forEach((producto) => {
        // Verifica si el producto y el nombre del producto tienen datos válidos
        if (!producto || !producto.nombre_producto) {
            console.error("Producto inválido detectado:", producto);
            return; // Salta este producto si no tiene datos válidos
        }

        // Estado crítico: stock igual a 1
        const stockCritico = producto.stock_producto === 1;
        const mensajeCritico = `${producto.nombre_producto} está en estado CRÍTICO de stock (solo queda 1 unidad)`;

        // Notificación estándar: stock bajo pero no crítico
        const mensaje = `${producto.nombre_producto} está bajo el límite de stock`;

        // Generar notificación para stock crítico
        if (stockCritico && !notificacionesHistorial[`${producto.id_producto}_critico`]) {
            notificacionesHistorial[producto.id_producto] = producto.nombre_producto;

            Swal.fire({
                title: "⚠️ ¡Stock Crítico!",
                text: mensajeCritico,
                icon: "warning", // Usa el ícono de advertencia
                confirmButtonText: "Entendido",
            });

            notificacionesSinLeer.push(mensajeCritico); // Contabiliza como nueva notificación crítica

            // Añadir al historial visual
            const listItem = document.createElement("li");
            listItem.textContent = mensajeCritico;
            listItem.className = "notificacion-item critico";

            const removeButton = document.createElement("button");
            removeButton.textContent = "✖";
            removeButton.className = "remove-notification-button";
            removeButton.addEventListener("click", () => {
                listItem.remove();
                delete notificacionesHistorial[`${producto.id_producto}_critico`];
                guardarHistorialEnLocalStorage();
            });

            listItem.appendChild(removeButton);
            notificationList.appendChild(listItem);
        }

        // Generar notificación estándar para stock bajo
        if (!stockCritico && !notificacionesHistorial[producto.id_producto]) {
            notificacionesHistorial[producto.id_producto] = producto.nombre_producto;

            notificacionesSinLeer.push(mensaje); // Contabiliza como nueva notificación estándar

            const listItem = document.createElement("li");
            listItem.textContent = mensaje;
            listItem.className = "notificacion-item";

            const removeButton = document.createElement("button");
            removeButton.textContent = "✖";
            removeButton.className = "remove-notification-button";
            removeButton.addEventListener("click", () => {
                listItem.remove();
                delete notificacionesHistorial[producto.id_producto];
                guardarHistorialEnLocalStorage();
            });

            listItem.appendChild(removeButton);
            notificationList.appendChild(listItem);
        }
    });

    // Guarda el historial actualizado en localStorage
    guardarHistorialEnLocalStorage();
    actualizarContadorNotificaciones(); // Asegura que el contador sea correcto
}

function actualizarContadorNotificaciones() {
    const notificationBadge = document.getElementById("notification-badge");
    notificationBadge.textContent = notificacionesSinLeer.length;
    notificationBadge.style.display = notificacionesSinLeer.length > 0 ? "inline-block" : "none";
}

function marcarNotificacionesComoLeidas() {
    const notificationBadge = document.getElementById("notification-badge");

    // Vacía las notificaciones no leídas, pero conserva el historial
    notificacionesSinLeer = [];
    notificationBadge.style.display = "none"; // Oculta el contador
}

function cargarHistorialNotificaciones() {
    const notificationList = document.getElementById("notification-list");

    // Cargar el historial desde localStorage
    const historialGuardado = JSON.parse(localStorage.getItem("notificacionesHistorial")) || {};
    notificacionesHistorial = historialGuardado;

    // Renderiza las notificaciones guardadas
    for (const id in notificacionesHistorial) {
        const nombreProducto = notificacionesHistorial[id];
        let mensaje;

        // Determina si es una notificación crítica o estándar
        if (id.endsWith("_critico")) {
            mensaje = `${nombreProducto} está en estado CRÍTICO de stock (solo queda 1 unidad)`;
        } else if (id === "sin_stock_bajo") {
            mensaje = "No hay productos con stock bajo";
        } else {
            mensaje = `${nombreProducto} está bajo el límite de stock`;
        }

        const listItem = document.createElement("li");
        listItem.textContent = mensaje;
        listItem.className = id.endsWith("_critico")
            ? "notificacion-item critico"
            : "notificacion-item normalizado";

        const removeButton = document.createElement("button");
        removeButton.textContent = "✖";
        removeButton.className = "remove-notification-button";
        removeButton.addEventListener("click", () => {
            listItem.remove();
            delete notificacionesHistorial[id];
            guardarHistorialEnLocalStorage();
        });

        listItem.appendChild(removeButton);
        notificationList.appendChild(listItem);
    }
}

function guardarHistorialEnLocalStorage() {
    // Guarda el historial completo en localStorage
    localStorage.setItem("notificacionesHistorial", JSON.stringify(notificacionesHistorial));
}

function reproducirSonidoAlerta() {
    const audio = new Audio("ruta-del-sonido/alerta.mp3"); // Cambia "ruta-del-sonido/alerta.mp3" por la ruta real
    audio.play();
}
