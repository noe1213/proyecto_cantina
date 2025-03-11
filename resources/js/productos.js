import Swal from "sweetalert2";

// Inicializar la tabla de productos y verificar notificaciones al cargar la página
window.onload = () => {
    fetchProducts();
     
};
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
                    ? `<img src="/storage/${product.imagen}" alt="Imagen del Producto" width="50">`
                    : "Sin Imagen"
            }
        </td>
        <td>
            <button class="edit-button" onclick="editProduct(${product.id_producto})">Editar</button>
            <button class="delete-button" onclick="deleteProduct(${product.id_producto})">Eliminar</button>
        </td>
    `;
    productList.appendChild(row);
}

// Manejo del formulario de agregar productos
document.getElementById("product-form").addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch("/api/productos", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
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
                    if (errorResponse.error) {
                        throw new Error(errorResponse.error);
                    }
                    throw new Error("Error desconocido al guardar el producto.");
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

    if (!file.type.startsWith("image/")) {
        Swal.fire("Error", "Por favor selecciona un archivo de imagen válido.", "error");
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
    document.getElementById("edit_nombre_producto").value = product.nombre_producto;
    document.getElementById("edit_precio_producto").value = product.precio_producto;
    document.getElementById("edit_categoria_producto").value = product.categoria_producto;
    document.getElementById("edit_stock_producto").value = product.stock_producto;
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
document.getElementById("edit-product-form").addEventListener("submit", function (event) {
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
            const productId = document.getElementById("edit_product_id").value;

            fetch(`/api/productos/${productId}`, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "X-HTTP-Method-Override": "PUT",
                },
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
                .then((updatedProduct) => {
                    Swal.fire("¡Éxito!", "Producto actualizado correctamente", "success");
                    closeModal();
                    updateTableRow(updatedProduct);
                })
                .catch((error) => Swal.fire("Error", error.message, "error"));
        }
    });
});

// Actualizar fila de la tabla tras edición
function updateTableRow(updatedProduct) {
    const row = document.querySelector(`tr[data-id="${updatedProduct.id_producto}"]`);
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
                <button class="edit-button" onclick="editProduct(${updatedProduct.id_producto})">Editar</button>
                <button class="delete-button" onclick="deleteProduct(${updatedProduct.id_producto})">Eliminar</button>
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
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
            })
                .then((response) => {
                    if (!response.ok) throw new Error("Error al eliminar el producto");
                    const row = document.querySelector(`tr[data-id="${id_producto}"]`);
                    if (row) row.remove();
                    Swal.fire("¡Eliminado!", "Producto eliminado correctamente", "success");
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
