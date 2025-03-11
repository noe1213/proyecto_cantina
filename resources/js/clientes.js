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

    
// Función para obtener los clientes al cargar la página
function fetchClients() {
    fetch("/api/clientes") // Asegúrate de que esta ruta esté definida en tu API
        .then((response) => {
            if (!response.ok) {
                throw new Error("Error al obtener clientes");
            }
            return response.json(); // Convertir la respuesta a JSON
        })
        .then((data) => {
            data.forEach((client) => {
                addClientToTable(client); // Agregar cada cliente a la tabla
            });
        })
        .catch((error) => {
            console.error("Error al obtener clientes:", error);
        });
}

// Función para agregar un cliente a la tabla
function addClientToTable(client) {
    const clientList = document.getElementById("client-list");
    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${client.ci}</td>
        <td>${client.nombre}</td>
        <td>${client.apellido}</td>
        <td>${client.correo}</td>
        <td>${client.telefono}</td>
        <td>
            <button class="edit-button" onclick="editClient(${client.ci})">Editar</button>
            <button class="delete-button" onclick="deleteClient(${client.ci})">Eliminar</button>
        </td>
    `;
    clientList.appendChild(row); // Agregar la fila a la tabla
}

// Llamar a la función para obtener los clientes al cargar la página
window.onload = fetchClients;
// Función para editar un cliente
function editClient(ci) {
    // Lógica para editar el cliente
    console.log("Editar cliente con CI:", ci);
    // Aquí puedes implementar la lógica para cargar los datos del cliente en un formulario
}

// Función para eliminar un cliente
function deleteClient(ci) {
    fetch(`/api/clientes/${ci}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                .value, // Incluir el token CSRF
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Error al eliminar el cliente");
            }
            // Eliminar la fila de la tabla
            const row = document.querySelector(`tr[data-id="${ci}"]`);
            if (row) {
                row.remove();
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

// Llamar a la función para obtener los clientes al cargar la página
window.onload = fetchClients;
