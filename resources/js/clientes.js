import Swal from "sweetalert2";

// Ejecutar funciones después de que el DOM esté cargado
document.addEventListener("DOMContentLoaded", () => {
    fetchClients(); // Cargar clientes en la tabla
});

// Función para obtener los clientes al cargar la página
function fetchClients() {
    fetch("/api/clientes") // Ruta de tu API para listar clientes
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
    if (!clientList) {
        console.error("El elemento client-list no existe en el DOM.");
        return;
    }

    const row = document.createElement("tr");
    row.setAttribute("data-ci", client.ci); // Usar "ci" como identificador único
    row.innerHTML = `
        <td>${client.ci}</td>
        <td>${client.nombre}</td>
        <td>${client.apellido}</td>
        <td>${client.correo}</td>
        <td>${client.telefono}</td>
        <td>
            <button class="edit-button" onclick="editClient('${client.ci}')">Editar</button>
        </td>
    `;
    clientList.appendChild(row); // Agregar la fila a la tabla
}

// Función para cargar datos de un cliente para edición
window.editClient = function(ci) {
    fetch(`/api/clientes/${ci}`) // Buscar cliente por "ci"
        .then((response) => {
            if (!response.ok) throw new Error("Error al cargar el cliente");
            return response.json();
        })
        .then((client) => openEditPopup(client))
        .catch((error) => Swal.fire("Error", error.message, "error"));
};

// Abrir popup de edición
function openEditPopup(client) {
    Swal.fire({
        title: 'Editar Cliente',
        html: `
            <input type="hidden" id="edit_client_ci" value="${client.ci}">
            
            <label for="edit_nombre">Nombre:</label>
            <input type="text" id="edit_nombre" class="swal2-input" value="${client.nombre}">

            <label for="edit_apellido">Apellido:</label>
            <input type="text" id="edit_apellido" class="swal2-input" value="${client.apellido}">
            
            <label for="edit_correo">Correo:</label>
            <input type="email" id="edit_correo" class="swal2-input" value="${client.correo}">
            
            <label for="edit_telefono">Teléfono:</label>
            <input type="text" id="edit_telefono" class="swal2-input" value="${client.telefono}">
            
            <label for="edit_municipio">Municipio:</label>
            <input type="text" id="edit_municipio" class="swal2-input" value="${client.municipio || ''}">
            
            <label for="edit_parroquia">Parroquia:</label>
            <input type="text" id="edit_parroquia" class="swal2-input" value="${client.parroquia || ''}">
            
            <label for="edit_calle">Calle:</label>
            <input type="text" id="edit_calle" class="swal2-input" value="${client.calle || ''}">
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar Cambios',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            // Recoger los valores del formulario
            const editedClient = {
                ci: document.getElementById("edit_client_ci").value,
                nombre: document.getElementById("edit_nombre").value,
                apellido: document.getElementById("edit_apellido").value,
                correo: document.getElementById("edit_correo").value,
                telefono: document.getElementById("edit_telefono").value,
                municipio: document.getElementById("edit_municipio").value,
                parroquia: document.getElementById("edit_parroquia").value,
                calle: document.getElementById("edit_calle").value
            };

            return editedClient;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Llamar a la función para guardar los cambios
            saveClientChanges(result.value);
        }
    });
}

// Guardar los cambios del cliente
function saveClientChanges(client) {
    fetch(`/api/clientes/${client.ci}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "X-HTTP-Method-Override": "PUT",
        },
        body: JSON.stringify(client)
    })
        .then((response) => {
            if (!response.ok) {
                return response.json().then((errorResponse) => {
                    if (errorResponse.errors) {
                        const validationMessages = Object.values(errorResponse.errors)
                            .flat()
                            .join("\n");
                        throw new Error(validationMessages);
                    }
                    throw new Error("Error desconocido al guardar los cambios.");
                });
            }
            return response.json();
        })
        .then((updatedClient) => {
            Swal.fire("¡Éxito!", "Cliente actualizado correctamente", "success");
            updateTableRow(updatedClient); // Actualizar fila en la tabla
        })
        .catch((error) => Swal.fire("Error", error.message, "error"));
}

// Actualizar fila de la tabla tras editar cliente
function updateTableRow(updatedClient) {
    const row = document.querySelector(`tr[data-ci="${updatedClient.ci}"]`);
    if (row) {
        row.innerHTML = `
            <td>${updatedClient.ci}</td>
            <td>${updatedClient.nombre}</td>
            <td>${updatedClient.apellido}</td>
            <td>${updatedClient.correo}</td>
            <td>${updatedClient.telefono}</td>
            <td>
                <button class="edit-button" onclick="editClient('${updatedClient.ci}')">Editar</button>
                <button class="delete-button" onclick="deleteClient('${updatedClient.ci}')">Eliminar</button>
            </td>
        `;
    } else {
        console.error(`No se encontró una fila para el cliente con CI ${updatedClient.ci}`);
    }
}

//clientes

////////////////////////////////////////////////////////////////////////////////



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