<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafetín Jesús Obrero</title>
    <link rel="icon" href="imagenes/cj.png" type="image/png"> <!-- Enlace al favicon -->
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/css/catalogo2.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Encabezado con elementos de navegación -->
    <x-header-cjo>
   
   
    </x-header-cjo>

    <!-- Contenido principal de la página -->
    <div id="contenido">

       

        <!-- Secciones de productos -->
       <!-- Secciones de productos con iconos -->
       <div class="product-section">
        
            
            <div class="almuerzos-filter">
            <h2 class="hola" ><i class="fas fa-utensils icon"></i> Almuerzos</h2>
            <div class="product-grid" id="almuerzos">
                
                <!-- Los productos se agregarán aquí dinámicamente -->
            </div>
        </div>
        <div class="product-section">
            <h2 class="hola" ><i class="fas fa-bread-slice icon"></i> Desayunos</h2>
            <div class="product-grid" id="desayunos">
                <!-- Los productos se agregarán aquí dinámicamente -->
            </div>
        </div>
        <div class="product-section">
            <h2 class="hola" ><i class="fas fa-coffee icon"></i> Bebidas</h2>
            <div class="product-grid" id="bebidas">
                <!-- Los productos se agregarán aquí dinámicamente -->
            </div>
        </div>
        <div class="product-section">
            <h2 class="hola" ><i class="fas fa-concierge-bell icon"></i> Combos</h2>
            <div class="product-grid" id="combos">
                <!-- Los productos se agregarán aquí dinámicamente -->
            </div>
        </div>
        <div class="product-section">
            <h2 class="hola" ><i class="fas fa-candy-cane icon"></i> Chucherias</h2>
            <div class="product-grid" id="chuches">
                <!-- Los productos se agregarán aquí dinámicamente -->
            </div>
        </div>
    </div>

    <x-footer>
        
    </x-footer>

    

    <!-- Ventana emergente del Carrito de Compras -->
    <div id="cartWindow" class="cart-window">
        <button class="close-btn" onclick="closeCart()">×</button>
        <h2>Carrito de compras</h2>
        <ul id="cartItems">
            <!-- Aquí se visualizarán los productos añadidos -->
        </ul>
        <div class="cart-actions">
            <button class="btn vaciar" onclick="emptyCart()">Vaciar carrito</button>
            <button class="btn confirmar"><a href="{{ route('confirmacion') }}">Confirmar pedido</a></button>
        </div>
    </div>

    <!-- Script para funcionalidad -->
    <script>
        let cartCount = 0;
        const products = [
            { name: "Coca-cola",  price: 2.00, image: "{{ asset('imagenes/coca_cola.png') }}", category: "bebidas" },
            { name: "Café", price: 1.50, image: "{{ asset('imagenes/cafe.jpeg') }}", category: "bebidas" },
            { name: "Frutea", price: 1.50, image: "{{ asset('imagenes/frutea.jpeg') }}", category: "bebidas" },
            { name: "Malta", price: 1.50, image: "{{ asset('imagenes/mal.jpeg') }}", category: "bebidas" },
            { name: "Refresco Glup", price: 1.50, image: "{{ asset('imagenes/glu.jpeg') }}", category: "bebidas" },
            { name: "Sandwich", description: "Delicioso sandwich con ingredientes frescos", price: 5.00, image: "{{ asset('imagenes/sa.jpeg') }}", category: "desayunos" },
            { name: "Cachito", description: "Ensalada fresca con aderezo", price: 4.00, image: "{{ asset('imagenes/cachito.jpeg') }}", category: "desayunos" },
            { name: "Pizza", description: "Delicioso sandwich con ingredientes frescos", price: 5.00, image: "{{ asset('imagenes/pi.jpeg') }}", category: "desayunos" },
            { name: "Empanada de carne", price: 4.00, image: "{{ asset('imagenes/cm.jpeg') }}", category: "desayunos" },
            { name: "Chiken tender", price: 8.00, image: "{{ asset('imagenes/chiken.jpeg') }}", category: "almuerzos", tipo: "estudiante" },
            { name: "Arroz con platano y carne molida", price: 8.00, image: "{{ asset('imagenes/arc.jpeg') }}", category: "almuerzos", tipo: "estudiante" },
            { name: "Pasta a la boloñesa",price: 8.00, image: "{{ asset('imagenes/bolona.jpeg') }}", category: "almuerzos", tipo: "estudiante" },
            { name: "Parrilla", price: 10.00, image: "{{ asset('imagenes/parrila.jpeg') }}", category: "almuerzos", tipo: "maestro" },
            { name: "Omelette", price: 10.00, image: "{{ asset('imagenes/omelette.jpeg') }}", category: "almuerzos", tipo: "maestro" },
            { name: "Pasta con milanesa", price: 10.00, image: "{{ asset('imagenes/mila.jpeg') }}", category: "almuerzos", tipo: "maestro" },
            { name: "Arroz con churrazco", price: 10.00, image: "{{ asset('imagenes/churras.jpeg') }}", category: "almuerzos", tipo: "maestro" },
            { name: "Ensalada Cesar",price: 10.00, image: "{{ asset('imagenes/en.jpeg') }}", category: "almuerzos", tipo: "maestro" },
            { name: "Salchipapas con bebida", price: 6.00, image: "{{ asset('imagenes/salcoca.jpeg') }}", category: "combos" },
            { name: "Pollo broaster con bebida" , price: 6.00, image: "{{ asset('imagenes/bros.jpeg') }}", category: "combos" },
            { name: "Perro caliente con bebida", price: 6.00, image: "{{ asset('imagenes/perro.jpeg') }}", category: "combos" },
            { name: "Cheesetris", price: 5.00, image: "{{ asset('imagenes/cheese_tris.png') }}", category: "chuches" },
            { name: "Cocosette", price: 4.00, image: "{{ asset('imagenes/cocosette.png') }}", category: "chuches" },
            { name: "Doritos", price: 5.00, image: "{{ asset('imagenes/doritos.png') }}", category: "chuches" },
            { name: "Nerds", price: 5.00, image: "{{ asset('imagenes/nerds.png') }}", category: "chuches" },
            { name: "Pepito",  price: 5.00, image: "{{ asset('imagenes/pepitos.png') }}", category: "chuches" },
            // Añadir más productos aquí
        ];

        function displayProducts(products) {
            const sections = {
                almuerzos: document.getElementById('almuerzos'),
                desayunos: document.getElementById('desayunos'),
                bebidas: document.getElementById('bebidas'),
                combos: document.getElementById('combos'),
                chuches: document.getElementById('chuches')
            };

            Object.values(sections).forEach(section => section.innerHTML = '');
            products.forEach(product => {
                const card = document.createElement('div');
                card.className = 'product';
                let productContent = `
                    <img src="${product.image}" alt="${product.name}">
                     <br>
                    <h4>${product.name}</h4>
                    <p>Precio: $${product.price.toFixed(2)}</p>
                     <br>
                    <b>Cantidad:</b>
                    <br>
                   <input style= border-radius:100px;padding:6px
                    type='number' min='1' value='1'
                     id='quantity-${product.name.replace(/\s+/g, '-')}' style='width:auto;'>
                `;

                if (product.category === 'almuerzos') {
                    productContent += `
                        <label for="acompanamiento-${product.name}">Acompañamiento:</label>
                        <select class="acompanamiento" id="acompanamiento-${product.name}">
                            <option value="Ninguno">Ninguno</option>
                            <option value="Papas Fritas">Papas Fritas</option>
                            <option value="Ensalada">Ensalada</option>
                            <option value="jugo">Jugo</option>
                        </select>
                    `;
                }

                productContent += `<button class="btn agregar" onclick='addToCart(${JSON.stringify(product)})'>Agregar al carrito</button>`;

                card.innerHTML = productContent;
                sections[product.category].appendChild(card);
            });
        }

       
function addToCart(product) {
    cartCount++;
    document.getElementById('cartCount').innerText = cartCount;

    const quantityInput = document.getElementById(`quantity-${product.name.replace(/\s+/g, '-')}`);
    const quantity = parseInt(quantityInput.value) || 1; // Captura la cantidad ingresada

    const cartItems = document.getElementById('cartItems');
    let cartItemText = `${product.name} - $${product.price.toFixed(2)} (Cantidad: ${quantity})`; // Incluye la cantidad en el texto

    if (product.category === 'almuerzos') {
        const acompanamiento = document.getElementById(`acompanamiento-${product.name}`).value;
        cartItemText += ` (Acompañamiento: ${acompanamiento})`;
    }

    const cartItem = document.createElement('li');
    cartItem.innerText = cartItemText;
    cartItems.appendChild(cartItem);
}
   
        
    

        function emptyCart() {
            const cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = '';
            cartCount = 0;
            document.getElementById('cartCount').innerText = cartCount;
        }

        function closeCart() {
            document.getElementById('cartWindow').style.right = '-320px';
        }

        function toggleCart() {
            const cartWindow = document.getElementById('cartWindow');
            const isOpen = cartWindow.style.right === '0px';
            cartWindow.style.right = isOpen ? '-320px' : '0px';
        }

        function filterProducts() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const filteredProducts = products.filter(product => product.name.toLowerCase().includes(query));
            displayProducts(filteredProducts);
        }

        function filterAlmuerzos() {
            const userType = document.getElementById('userTypeFilter').value;
            const filteredProducts = products.filter(product => {
                return (product.category !== 'almuerzos' || product.tipo === userType || userType === '');
            });
            displayProducts(filteredProducts);
        }
        // Inicializar los productos en la página
        displayProducts(products);
    </script>
</body>
</html>