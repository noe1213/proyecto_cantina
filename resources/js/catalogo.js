console.log("Archivo JavaScript cargado correctamente.");
import Swal from "sweetalert2";
// Inicializar el documento
document.addEventListener("DOMContentLoaded", () => {
    // Obtener productos al cargar la página
    obtenerProductosParaCatalogo();

    // Configuración de eventos para el carrito
    const cartIcon = document.getElementById("cartIcon");
    if (cartIcon) {
        cartIcon.addEventListener("click", toggleCart);
    }

    const emptyCartButton = document.getElementById("emptyCartButton");
    if (emptyCartButton) {
        emptyCartButton.addEventListener("click", emptyCart);
    }

    const confirmOrderButton = document.getElementById("confirmOrderButton");
    if (confirmOrderButton) {
        confirmOrderButton.addEventListener("click", confirmarPedido);
    }
});

// Función para obtener productos desde el backend
function obtenerProductosParaCatalogo() {
    fetch("http://127.0.0.1:8000/api/productos")
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error al obtener los productos: ${response.statusText}`);
            }
            return response.json();
        })
        .then(productos => {
            console.log("Productos obtenidos del backend:", productos);
            renderizarCatalogoPorCategoria(productos);
        })
        .catch(error => console.error("Error al cargar el catálogo:", error));
}

// Función para renderizar el catálogo por categoría
function renderizarCatalogoPorCategoria(productos) {
    const categorias = ["Desayunos", "Bebidas", "Combos", "Almuerzos", "Chuches"];
    categorias.forEach(categoria => {
        const contenedor = document.getElementById(categoria.toLowerCase());
        if (!contenedor) {
            console.warn(`No se encontró el contenedor para la categoría: ${categoria}`);
            return;
        }

        const productosCategoria = productos.filter(
            producto => producto.categoria_producto === categoria
        );

        productosCategoria.forEach(producto => {
            const imgURL = producto.imagen || "http://127.0.0.1:8000/storage/imagenes/default.png";

            const productCard = document.createElement("div");
            productCard.className = "product";

            productCard.innerHTML = `
                <img src="${imgURL}" alt="${producto.nombre_producto}" class="product-image">
                <h4>${producto.nombre_producto}</h4>
                <p>Precio: $${producto.precio_producto.toFixed(2)}</p>
                <label for="cantidad-${producto.id_producto}">Cantidad:</label>
                <input type="number" id="cantidad-${producto.id_producto}" min="1" value="1">
            `;

            const boton = document.createElement("button");
            boton.textContent = "Agregar al carrito";
            boton.addEventListener("click", () => {
                agregarAlCarrito(producto.id_producto, producto.nombre_producto, producto.precio_producto, imgURL);
            });

            productCard.appendChild(boton);
            contenedor.appendChild(productCard);
        });
    });
}

// Carrito global
let carrito = [];

// Función para agregar un producto al carrito
function agregarAlCarrito(id, nombre, precio, imagen) {
    console.log("Agregar al carrito llamado con:", { id, nombre, precio, imagen });

    const cantidadInput = document.getElementById(`cantidad-${id}`);
    const cantidad = parseInt(cantidadInput.value);

    if (isNaN(cantidad) || cantidad < 1) {
        Swal.fire({
            icon: "error",
            title: "Cantidad inválida",
            text: "Por favor, ingresa una cantidad válida.",
        });
        return;
    }

    const productoExistente = carrito.find(producto => producto.id === id);
    if (productoExistente) {
        productoExistente.cantidad += cantidad;
    } else {
        carrito.push({ id, nombre, precio, imagen, cantidad });
    }

    console.log("Carrito actualizado:", carrito);
    actualizarCarritoVisual();

    Swal.fire({
        icon: "success",
        title: "Producto agregado",
        text: `${nombre} (${cantidad} unidades) se agregó al carrito.`,
        showConfirmButton: false,
        timer: 2000,
    });
}

// Función para actualizar la visualización del carrito
function actualizarCarritoVisual() {
    const cartItems = document.getElementById("cartItems");
    const cartCount = document.getElementById("cartCount");
    const totalPriceElement = document.getElementById("totalPrice");

    cartItems.innerHTML = "";

    let totalItems = 0;
    let totalPrice = 0;

    carrito.forEach(producto => {
        totalItems += producto.cantidad;
        totalPrice += producto.precio * producto.cantidad;

        const li = document.createElement("li");
        li.innerHTML = `
            ${producto.nombre} - $${producto.precio.toFixed(2)} x ${producto.cantidad}
        `;

        const botonEliminar = document.createElement("button");
        botonEliminar.textContent = "✖";
        botonEliminar.style = "margin-left: 10px; background: transparent; border: none; color: red; font-size: 16px; cursor: pointer;";
        botonEliminar.addEventListener("click", () => {
            eliminarDelCarrito(producto.id);
        });

        li.appendChild(botonEliminar);
        cartItems.appendChild(li);
    });

    cartCount.textContent = totalItems;
    totalPriceElement.textContent = `Total: $${totalPrice.toFixed(2)}`;
}

// Función para eliminar un producto del carrito
function eliminarDelCarrito(id) {
    Swal.fire({
        title: "¿Eliminar producto?",
        text: "El producto será eliminado del carrito.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then(result => {
        if (result.isConfirmed) {
            carrito = carrito.filter(producto => producto.id !== id);
            actualizarCarritoVisual();

            Swal.fire({
                icon: "success",
                title: "Producto eliminado",
                text: "El producto ha sido eliminado del carrito.",
            });
        }
    });
}

// Función para alternar la ventana del carrito
function toggleCart() {
    const cartWindow = document.getElementById("cartWindow");
    if (!cartWindow) {
        console.error("No se encontró la ventana del carrito.");
        return;
    }

    cartWindow.style.display =
        cartWindow.style.display === "none" || cartWindow.style.display === ""
            ? "block"
            : "none";
}

// Función para vaciar el carrito
function emptyCart() {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esto vaciará todo el carrito. Esta acción no puede deshacerse.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, vaciar carrito",
        cancelButtonText: "Cancelar",
    }).then(result => {
        if (result.isConfirmed) {
            carrito = [];
            actualizarCarritoVisual();

            Swal.fire({
                icon: "success",
                title: "Carrito vaciado",
                text: "El carrito ha sido vaciado con éxito.",
            });
        }
    });
}

// Función para confirmar el pedido
function confirmarPedido() {
    if (carrito.length === 0) {
        Swal.fire({
            icon: "info",
            title: "Carrito vacío",
            text: "No tienes productos en el carrito.",
        });
        return;
    }

    let totalPrice = 0;
    carrito.forEach(producto => {
        totalPrice += producto.precio * producto.cantidad;
    });

    Swal.fire({
        title: "¿Confirmar pedido?",
        text: `El precio total es de $${totalPrice.toFixed(2)}.`,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
    }).then(result => {
        if (result.isConfirmed) {
            carrito = [];
            actualizarCarritoVisual();

            Swal.fire({
                icon: "success",
                title: "Pedido confirmado",
                text: `¡Gracias por tu compra! Total pagado: $${totalPrice.toFixed(2)}.`,
            });

            toggleCart();
        }
    });
}
