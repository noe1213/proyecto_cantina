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
        .catch((error) =>
            console.error("Error al obtener productos con stock bajo:", error)
        );
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
        if (
            stockCritico &&
            !notificacionesHistorial[`${producto.id_producto}_critico`]
        ) {
            notificacionesHistorial[producto.id_producto] =
                producto.nombre_producto;

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
                delete notificacionesHistorial[
                    `${producto.id_producto}_critico`
                ];
                guardarHistorialEnLocalStorage();
            });

            listItem.appendChild(removeButton);
            notificationList.appendChild(listItem);
        }

        // Generar notificación estándar para stock bajo
        if (!stockCritico && !notificacionesHistorial[producto.id_producto]) {
            notificacionesHistorial[producto.id_producto] =
                producto.nombre_producto;

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
    notificationBadge.style.display =
        notificacionesSinLeer.length > 0 ? "inline-block" : "none";
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
    const historialGuardado =
        JSON.parse(localStorage.getItem("notificacionesHistorial")) || {};
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
    localStorage.setItem(
        "notificacionesHistorial",
        JSON.stringify(notificacionesHistorial)
    );
}

function reproducirSonidoAlerta() {
    const audio = new Audio("ruta-del-sonido/alerta.mp3"); // Cambia "ruta-del-sonido/alerta.mp3" por la ruta real
    audio.play();
}

// Obtener productos y llenar la tabla
function fetchProducts() {
    fetch("/api/productos")
        .then((response) => {
            if (!response.ok) throw new Error("Error al obtener productos");

            return response.json();
        })
        .then((data) => populateTable(data))
        .catch((error) => console.error("Error al obtener productos:", error));
}

// Llenar la tabla con los productos
function populateTable(products) {
    const productList = document.getElementById("product-list");
    productList.innerHTML = "";

    products.forEach((product) => addProductToTable(product));
}

// Añadir producto a la tabla
function addProductToTable(product) {
    const productList = document.getElementById("product-list");
    const row = document.createElement("tr");
    row.setAttribute("data-id", product.id_producto);

    row.innerHTML = `
        <td>${product.nombre_producto}</td>
        <td>${product.precio_producto}</td>
        <td>${product.categoria_producto}</td>
        <td>${product.stock_producto}</td>
        <td>${product.stock_minimo}</td>
        <td>
            ${
                product.imagen
                    ? `<img src="${product.imagen}" alt="Imagen del Producto" width="50">`
                    : "Sin Imagen"
            }
        </td>
        <td>
            <button class="edit-button" onclick="editProduct(${
                product.id_producto
            })">Editar</button>
            <button class="delete-button" onclick="deleteProduct(${
                product.id_producto
            })">Eliminar</button>
        </td>
    `;
    productList.appendChild(row);
}

// Manejo del formulario de agregar productos
document
    .getElementById("product-form")
    .addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch("/api/productos", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then((response) => {
                if (!response.ok) {
                    return response.json().then((errorResponse) => {
                        if (errorResponse.errors) {
                            const validationMessages = Object.values(
                                errorResponse.errors
                            )
                                .flat()
                                .join("\n");
                            throw new Error(validationMessages);
                        }
                        if (errorResponse.error) {
                            throw new Error(errorResponse.error);
                        }
                        throw new Error(
                            "Error desconocido al guardar el producto."
                        );
                    });
                }
                return response.json();
            })
            .then((newProduct) => {
                Swal.fire({
                    title: "¡Producto Guardado!",
                    text: "El producto fue agregado exitosamente.",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                });

                addProductToTable(newProduct);
                clearForm();
            })
            .catch((error) => {
                console.error("Error al agregar producto:", error);
                Swal.fire({
                    title: "Error",
                    text: error.message,
                    icon: "error",
                });
            });
    });

// Limpiar el formulario después de agregar un producto
function clearForm() {
    const form = document.getElementById("product-form");
    form.reset();
    document.getElementById("image_preview").style.display = "none";
}

// Vista previa de la imagen al agregar
function previewImage(event) {
    const file = event.target.files[0];
    if (!file || !file.type.startsWith("image/")) {
        Swal.fire(
            "Error",
            "Por favor selecciona un archivo de imagen válido.",
            "error"
        );
        event.target.value = "";
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        const imagePreview = document.getElementById("image_preview");
        imagePreview.src = e.target.result;
        imagePreview.style.display = "block";
    };
    reader.readAsDataURL(file);
}

// Editar producto
function editProduct(id_producto) {
    fetch(`/api/productos/${id_producto}`)
        .then((response) => {
            if (!response.ok) throw new Error("Error al cargar el producto");
            return response.json();
        })
        .then((product) => openEditModal(product))
        .catch((error) => Swal.fire("Error", error.message, "error"));
}

// Abrir modal de edición
function openEditModal(product) {
    const modal = document.getElementById("edit-modal");
    document.getElementById("edit_product_id").value = product.id_producto;
    document.getElementById("edit_nombre_producto").value =
        product.nombre_producto;
    document.getElementById("edit_precio_producto").value =
        product.precio_producto;
    document.getElementById("edit_categoria_producto").value =
        product.categoria_producto;
    document.getElementById("edit_stock_producto").value =
        product.stock_producto;
    document.getElementById("edit_stock_minimo").value = product.stock_minimo;

    const imagePreview = document.getElementById("edit_image_preview");
    if (product.imagen) {
        imagePreview.src = `/storage/${product.imagen}`;
        imagePreview.style.display = "block";
    } else {
        imagePreview.style.display = "none";
    }

    modal.style.display = "block";
}

// Cerrar modal de edición
function closeModal() {
    const modal = document.getElementById("edit-modal");
    modal.style.display = "none";
}

// Guardar cambios desde el modal de edición
document
    .getElementById("edit-product-form")
    .addEventListener("submit", function (event) {
        event.preventDefault();

        Swal.fire({
            title: "¿Guardar cambios?",
            text: "¿Estás seguro de que deseas aplicar los cambios?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, guardar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(this);
                const productId =
                    document.getElementById("edit_product_id").value;

                fetch(`/api/productos/${productId}`, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                        "X-HTTP-Method-Override": "PUT",
                    },
                })
                    .then((response) => {
                        if (!response.ok) {
                            return response.json().then((errorResponse) => {
                                if (errorResponse.errors) {
                                    const validationMessages = Object.values(
                                        errorResponse.errors
                                    )
                                        .flat()
                                        .join("\n");
                                    throw new Error(validationMessages);
                                }
                                throw new Error(
                                    "Error desconocido al guardar los cambios."
                                );
                            });
                        }
                        return response.json();
                    })
                    .then((updatedProduct) => {
                        Swal.fire(
                            "¡Éxito!",
                            "Producto actualizado correctamente",
                            "success"
                        );
                        closeModal();
                        updateTableRow(updatedProduct);
                    })
                    .catch((error) =>
                        Swal.fire("Error", error.message, "error")
                    );
            }
        });
    });

// Actualizar fila de la tabla tras edición
function updateTableRow(updatedProduct) {
    const row = document.querySelector(
        `tr[data-id="${updatedProduct.id_producto}"]`
    );
    if (row) {
        row.innerHTML = `
            <td>${updatedProduct.nombre_producto}</td>
            <td>${updatedProduct.precio_producto}</td>
            <td>${updatedProduct.categoria_producto}</td>
            <td>${updatedProduct.stock_producto}</td>
            <td>${updatedProduct.stock_minimo}</td>
            <td>${
                updatedProduct.imagen
                    ? `<img src="/storage/${updatedProduct.imagen}" alt="Imagen del Producto" width="50">`
                    : "Sin Imagen"
            }</td>
            <td>
                <button class="edit-button" onclick="editProduct(${
                    updatedProduct.id_producto
                })">Editar</button>
                <button class="delete-button" onclick="deleteProduct(${
                    updatedProduct.id_producto
                })">Eliminar</button>
            </td>
        `;
    }
}

// Eliminar producto
function deleteProduct(id_producto) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡Esta acción no se puede deshacer!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/api/productos/${id_producto}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            })
                .then((response) => {
                    if (!response.ok)
                        throw new Error("Error al eliminar el producto");
                    const row = document.querySelector(
                        `tr[data-id="${id_producto}"]`
                    );
                    if (row) row.remove();
                    Swal.fire(
                        "¡Eliminado!",
                        "Producto eliminado correctamente",
                        "success"
                    );
                })
                .catch((error) => {
                    console.error("Error al eliminar el producto:", error);
                    Swal.fire("Error", error.message, "error");
                });
        }
    });
}

// Exponer funciones globalmente para los botones
window.editProduct = editProduct;
window.deleteProduct = deleteProduct;
window.closeModal = closeModal;
