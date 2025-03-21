<x-head-admin></x-head-admin>

<body>
    <x-header-cjoae>

    </x-header-cjoae>
    <main>
        <x-menu-admin></x-menu-admin>

        <!-- Contenedor de la tabla de productos -->
        <div class="table-container">
            <h2 class="section-title">Productos</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Stock Mínimo</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <!-- Los productos serán generados dinámicamente -->
                </tbody>
            </table>
        </div>

        <!-- Formulario para agregar producto -->
        <div class="content">
            <h2 class="section-title">Agregar Producto</h2>
            <form id="product-form" class="product-form" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <label for="nombre_producto">Nombre</label>
                    <input type="text" id="nombre_producto" name="nombre_producto" required>
                </div>
                <div class="input-group">
                    <label for="precio_producto">Precio</label>
                    <input type="number" id="precio_producto" name="precio_producto" step="0.01" required>
                </div>
                <div class="input-group">
                    <label for="categoria_producto">Categoría</label>
                    <select id="categoria_producto" name="categoria_producto" required>
                        <option value="" disabled selected>Selecciona una categoría</option>
                        <option value="Combos">Combos</option>
                        <option value="Bebidas">Bebidas</option>
                        <option value="Almuerzos">Almuerzos</option>
                        <option value="Desayunos">Desayunos</option>
                        <option value="Chuches">Chuches</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="stock_producto">Stock</label>
                    <input type="number" id="stock_producto" name="stock_producto" required>
                </div>
                <div class="input-group">
                    <label for="stock_minimo">Stock Mínimo</label>
                    <input type="number" id="stock_minimo" name="stock_minimo" required>
                </div>
                <div class="input-group">
                    <label for="imagen_producto">Imagen</label>
                    <button type="button" class="upload-button"
                        onclick="document.getElementById('imagen_producto').click();">Subir Imagen</button>
                    <input type="file" id="imagen_producto" name="imagen_producto" accept="image/*"
                        onchange="previewImage(event)" style="display:none;">
                    <img id="image_preview" src="" alt="Vista previa"
                        style="display:none; margin-top:10px; max-width:100%; border-radius:4px;">
                </div>
                <div class="botones">
                    <button type="submit" class="guardar-btn">Guardar Producto</button>
                    <button type="reset" class="eliminar-btn" onclick="clearForm()">Limpiar</button>
                </div>
            </form>
        </div>


        <!-- Modal para editar producto -->
        <div id="edit-modal" class="modal">
            <div class="modal-content">
                <span class="close-button" onclick="closeModal()">×</span>
                <h2>Editar Producto</h2>
                <form id="edit-product-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_product_id" name="id_producto">
                    <div class="input-group">
                        <label for="edit_nombre_producto">Nombre</label>
                        <input type="text" id="edit_nombre_producto" name="nombre_producto" required>
                    </div>
                    <div class="input-group">
                        <label for="edit_precio_producto">Precio</label>
                        <input type="number" id="edit_precio_producto" name="precio_producto" step="0.01" required>
                    </div>
                    <div class="input-group">
                        <label for="edit_categoria_producto">Categoría</label>
                        <select id="edit_categoria_producto" name="categoria_producto" required>
                            <option value="Combos">Combos</option>
                            <option value="Bebidas">Bebidas</option>
                            <option value="Almuerzos">Almuerzos</option>
                            <option value="Desayunos">Desayunos</option>
                            <option value="Chuches">Chuches</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="edit_stock_producto">Stock</label>
                        <input type="number" id="edit_stock_producto" name="stock_producto" required>
                    </div>
                    <div class="input-group">
                        <label for="edit_stock_minimo">Stock Mínimo</label>
                        <input type="number" id="edit_stock_minimo" name="stock_minimo" required>
                    </div>
                    <div class="input-group">
                        <label for="edit_imagen_producto">Imagen</label>
                        <button type="button" class="upload-button"
                            onclick="document.getElementById('edit_imagen_producto').click();">Subir Imagen</button>
                        <input type="file" id="edit_imagen_producto" name="imagen_producto" accept="image/*"
                            onchange="previewEditImage(event)" style="display:none;">
                        <!-- Vista previa de la imagen -->
                        <img id="edit_image_preview" src="" alt="Vista previa"
                            style="margin-top:10px; max-width:100%; border-radius:4px; display:none;">
                    </div>
                    <button type="submit" class="guardar-btn">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </main>
    <x-footeradmin></x-footeradmin>

    @vite(['resources/css/productos.css', 'resources/js/productos.js'])
</body>