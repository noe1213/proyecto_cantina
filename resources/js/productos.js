import Swal from "sweetalert2";

// Obtener productos y llenar la tabla
function fetchProducts() {
    fetch("/api/productos")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Error al obtener los productos");
            }
            return response.json();
        })
        .then((data) => populateTable(data)) // Llenar la tabla con los productos
        .catch((error) => console.error("Error al obtener productos:", error));
}

// Llenar la tabla con los productos
function populateTable(products) {
    const productList = document.getElementById("product-list");
    productList.innerHTML = ""; // Limpiar contenido anterior

    products.forEach((product) => addProductToTable(product));
}

// Agregar un producto a la tabla
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

// Cargar datos del producto en el formulario para editar
function editProduct(id_producto) {
    fetch(`/api/productos/${id_producto}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`Error al cargar el producto: ${response.statusText}`);
            }
            return response.json();
        })
        .then((producto) => {
            document.getElementById("nombre_producto").value = producto.nombre_producto;
            document.getElementById("precio_producto").value = producto.precio_producto;
            document.getElementById("categoria_producto").value = producto.categoria_producto;
            document.getElementById("stock_producto").value = producto.stock_producto;
            document.getElementById("stock_minimo").value = producto.stock_minimo;

            const imagePreview = document.getElementById("image_preview");
            if (producto.imagen) {
                imagePreview.src = `/storage/${producto.imagen}`;
                imagePreview.style.display = "block";
            } else {
                imagePreview.style.display = "none";
            }

            document.getElementById("product-form").setAttribute("data-id", id_producto);
        })
        .catch((error) => {
            console.error("Error al cargar el producto:", error);
            Swal.fire({
                title: "Error al cargar el producto",
                text: error.message,
                icon: "error",
            });
        });
}

// Guardar producto (nuevo o editado)
document.getElementById("product-form").addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    const productId = this.getAttribute("data-id");
    const method = productId ? "PUT" : "POST";
    const url = productId ? `/api/productos/${productId}` : "/api/productos";

    fetch(url, {
        method: method,
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Error al guardar el producto");
            }
            return response.json();
        })
        .then((data) => {
            Swal.fire({
                title: productId ? "Producto actualizado!" : "Producto guardado!",
                icon: "success",
            });

            if (productId) {
                updateTableRow(data);
            } else {
                addProductToTable(data);
            }

            clearForm();
        })
        .catch((error) => {
            console.error("Error al guardar el producto:", error);
            Swal.fire({
                title: "Error al guardar el producto",
                text: error.message,
                icon: "error",
            });
        });
});


// Limpiar el formulario después de agregar o editar un producto
function clearForm() {
    const form = document.getElementById("product-form");
    form.reset();
    form.removeAttribute("data-id");
    document.getElementById("image_preview").style.display = "none";
}

// Eliminar un producto
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
                    if (!response.ok) {
                        throw new Error("Error al eliminar el producto");
                    }
                    const row = document.querySelector(`tr[data-id="${id_producto}"]`);
                    if (row) {
                        row.remove(); // Eliminar la fila de la tabla
                    }
                    Swal.fire({ title: "Producto eliminado!", icon: "success" });
                })
                .catch((error) => {
                    console.error("Error al eliminar el producto:", error);
                    Swal.fire({
                        title: "Error al eliminar el producto",
                        text: error.message,
                        icon: "error",
                    });
                });
        }
    });
}

// Inicializar y cargar productos al inicio
window.onload = fetchProducts;

// Exponer las funciones de edición y eliminación globalmente
window.editProduct = editProduct;
window.deleteProduct = deleteProduct;
