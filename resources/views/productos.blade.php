<x-head-admin></x-head-admin>

<body>
    <x-header-cjoae></x-header-cjoae>


    <main>
        <!-- Interfaz de Administración -->
        <x-menu-admin></x-menu-admin>
        <!-- Tabla de Productos -->
        <div class="table-container">
            <h2 class="section-title">Productos Creado</h2>
            <table class="table table-striped">
                <thead>
                    <tr>

                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Stock minimo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <!-- Aquí se agregarán los productos dinámicamente -->
                </tbody>
            </table>
        </div>

        <!-- Formulario para agregar un nuevo producto -->
        <div class="content">
            <h2 class="section-title">Agregar Nuevo Producto</h2>
            <form id="product-form" class="product-form" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <div class="input-half">
                        <label for="nombre_producto">Nombre del Producto</label>
                        <input type="text" id="nombre_producto" name="nombre_producto" required>
                    </div>
                    <div class="input-half">
                        <label for="precio_producto">Precio del Producto</label>
                        <input type="number" id="precio_producto" name="precio_producto" step="0.01" required>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-half">
                        <label for="categoria_producto">Categoría del Producto</label>
                        <select id="categoria_producto" name="categoria_producto" required>
                            <option value="" disabled selected>Selecciona una categoría</option>
                            <option value="Combos">Combos</option>
                            <option value="Bebidas">Bebidas</option>
                            <option value="Almuerzos">Almuerzos</option>
                            <option value="Desayunos">Desayunos</option>
                            <option value="Chuches">Chuches</option>
                        </select>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-half">
                        <label for="stock_producto">Stock del Producto</label>
                        <input type="number" id="stock_producto" name="stock_producto" required>
                    </div>
                    <div class="input-half">
                        <label for="stock_minimo">Stock Mínimo</label>
                        <input type="number" id="stock_minimo" name="stock_minimo" required>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-half">
                        <label for="imagen_producto">Imagen del Producto</label>
                        <button type="button" class="upload-button"
                            onclick="document.getElementById('imagen_producto').click();">Subir Imagen</button>
                        <input type="file" id="imagen_producto" name="imagen_producto" accept="image/*"
                            onchange="storeImage(event)" style="display:none;">
                        <img id="image_preview" src="" alt="Vista previa"
                            style="display:none; margin-top:10px; max-width:100%; border-radius: 4px;">
                    </div>
                </div>
                <div class="botones">
                    <button type="submit" class="guardar-btn">Guardar Producto</button>
                    <button type="reset" class="eliminar-btn">Limpiar</button>
                </div>
            </form>
        </div>
    </main>


    <x-footeradmin></x-footeradmin>
    @vite(entrypoints: ['resources/css/productos.css','resources/js/productos.js'])
    <!-- <script src="{{ asset('productos.js') }}"></script> -->


    </html>