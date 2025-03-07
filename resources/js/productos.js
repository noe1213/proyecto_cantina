import Swal from "sweetalert2";
// Función para obtener los productos al cargar la página
function fetchProducts() {
    fetch("/api/productos")
        .then((response) => response.json())
        .then((data) => {
            data.forEach((product) => {
                addProductToTable(product);
            });
        })
        .catch((error) => {
            console.error("Error al obtener productos:", error);
        });
}

// Función para agregar un producto a la tabla
function addProductToTable(product) {
    const productList = document.getElementById("product-list");
    const row = document.createElement("tr");
    row.innerHTML = `
        
        <td>${product.nombre_producto}</td>
        <td>${product.precio_producto}</td>
        <td>${product.categoria_producto}</td>
        <td>${product.stock_producto}</td>
        <td>${product.stock_minimo}</td>
        <td>
            <button class="edit-button" onclick="editProduct(${product.id_producto})">Editar</button>
            <button class="delete-button" onclick="deleteProduct(${product.id_producto})">Eliminar</button>
        </td>
    `;
    productList.appendChild(row);
}

// Función para editar un producto
function editProduct(id) {
    // Lógica para editar el producto
    console.log("Editar producto con ID:", id);
    // Aquí puedes implementar la lógica para cargar los datos del producto en el formulario
}

// Función para eliminar un producto
function deleteProduct(id) {
    fetch(`/api/productos/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                .value, // Incluir el token CSRF
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Error al eliminar el producto");
            }
            // Eliminar la fila de la tabla
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if (row) {
                row.remove();
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

function storeImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
        const imageBase64 = e.target.result; // Obtener la imagen en base64
        console.log(imageBase64);
        localStorage.setItem("imagen_producto", imageBase64); // Almacenar en localStorage
        const imagePreview = document.getElementById("image_preview");
        imagePreview.src = imageBase64; // Mostrar la imagen en la vista previa
        imagePreview.style.display = "block"; // Hacer visible la vista previa
    };

    if (file) {
        reader.readAsDataURL(file); // Leer el archivo como URL de datos
    }
}

document
    .getElementById("product-form")
    .addEventListener("submit", function (event) {
        event.preventDefault(); // Evitar el envío normal del formulario

        const formData = new FormData(this); // Crear un objeto FormData con los datos del formulario
        const imageBase64 = localStorage.getItem("imagen_producto");
        console.log(imageBase64); // Obtener la imagen del localStorage
        formData.append("imagen_producto", imageBase64); // Agregar la imagen al FormData
        // Crear un objeto FormData con los datos del formulario

        fetch("/api/productos", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                    .value, // Incluir el token CSRF
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error en la solicitud");
                }
                return response.json();
            })
            .then((data) => {
                Swal.fire({ title: "Producto guardado!", icon: "success" });
                console.log("Producto guardado:", data);
                // Aquí puedes agregar lógica para mostrar un mensaje de éxito o limpiar el formulario
                document.getElementById("product-form").reset(); // Limpiar el formulario
                document.getElementById("image_preview").style.display = "none"; // Ocultar la vista previa
            })
            .catch((error) => {
                console.error("Error:", error);
                // Aquí puedes agregar lógica para mostrar un mensaje de error
            });
    });

function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
        const imagePreview = document.getElementById("image_preview");
        imagePreview.src = e.target.result;
        imagePreview.style.display = "block";
    };

    if (file) {
        reader.readAsDataURL(file);
    }
}

// Llamar a la función para obtener los productos al cargar la página
window.onload = fetchProducts;
