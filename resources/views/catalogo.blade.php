<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafetín Jesús Obrero - Catálogo</title>
    <link rel="icon" href="imagenes/cj.png" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/catalogo2.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <x-header-cjo>
</x-header-cjo>
    <!-- Contenido principal del catálogo -->
    <div id="contenido">
        <div class="product-section">
            <div class="almuerzos-filter">
                <h2 class="hola"><i class="fas fa-utensils icon"></i> Almuerzos</h2>
                <div class="product-grid" id="almuerzos">
                    <!-- Los productos de almuerzos se agregarán aquí dinámicamente -->
                </div>
            </div>
        </div>
        <div class="product-section">
            <h2 class="hola"><i class="fas fa-bread-slice icon"></i> Desayunos</h2>
            <div class="product-grid" id="desayunos">
                    <!-- Los productos de desayunos se agregarán aquí dinámicamente -->
            </div>
        </div>
        <div class="product-section">
            <h2 class="hola"><i class="fas fa-coffee icon"></i> Bebidas</h2>
            <div class="product-grid" id="bebidas">
                    <!-- Los productos de bebidas se agregarán aquí dinámicamente -->
            </div>
        </div>
        <div class="product-section">
            <h2 class="hola"><i class="fas fa-concierge-bell icon"></i> Combos</h2>
            <div class="product-grid" id="combos">
                    <!-- Los productos de combos se agregarán aquí dinámicamente -->
            </div>
        </div>
        <div class="product-section">
            <h2 class="hola"><i class="fas fa-candy-cane icon"></i> Chuches</h2>
            <div class="product-grid" id="chuches">
                    <!-- Los productos de chuches se agregarán aquí dinámicamente -->
            </div>
        </div>
    </div>

    <x-footer></x-footer>

    <script src="resources/js/catalogo2.js" defer></script>


    <!-- Carga del archivo JavaScript para el catálogo -->
    @vite(['resources/css/catalogo2.css','resources/js/catalogo.js'])
</body>
</html>
