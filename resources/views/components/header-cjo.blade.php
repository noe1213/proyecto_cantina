<!-- resources/views/components/header-cjo.blade.php -->
<header
    style="background-color: #002366; color: white; padding: 10px; display: flex; align-items: center; justify-content: space-between;">
    <div class="logo" style="display: flex; align-items: center;">
        <img src="{{ asset('imagenes/cj.png') }}" alt="Logo Cafetería Jesús Obrero"
            style="height: 120px;  margin-right: 10px;">
        <h1 style="font-size: 44px; margin-left: 10px; margin-right: 150px;">CJO</h1>
    </div>
    <nav style="display: flex; align-items: center;margin-left: 59px;margin-right: 450px;">

        <div class="search" style="margin-left: 1px; margin-right: 50px;">
            {{ $slot }}
            <input type="text" id="searchInput" placeholder="Buscar productos..." onkeyup="filterProducts()"
                style="padding:8px 46px;">
            <button type="button"
                style="padding: 8px 10px; margin-right: 50px;  background-color: #004080; color: white; border: none; border-radius: 5px;"><i
                    class="fas fa-search"></i></button>
        </div>



        <ul class="header-nav">
            <a href="{{ route('historial') }}"
                style="color: white; text-decoration: none; font-size: 20px; display: flex; align-items: center; padding: 10px 20px; border-radius: 5px;">
                <i class="fas fa-history" style="margin-right: 5px;"></i> Historial
            </a>

        </ul>
        <ul class="header-nav">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <!-- Token CSRF para seguridad -->
                <button type="submit"
                    style="background: none; border: none; color: white; font-size: 20px; cursor: pointer; display: flex; align-items: center;">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </button>
            </form>
        </ul>
        <!-- Ícono del Carrito en el header -->
        <div id="cartIcon" class="cart-container">
            <i class="fas fa-shopping-cart"></i>
            <span id="cartCount" class="cart-count">0</span>
        </div>
    </nav>
</header>
<div id="cartWindow" class="cart-window" style="display: none;">
    <h2>Carrito de Compras</h2>
    <ul id="cartItems"></ul>
    <p id="totalPrice">Total: $0.00</p>
    <div class="cart-actions">
        <button id="emptyCartButton">Vaciar Carrito</button>
        <button id="confirmOrderButton">Confirmar Pedido</button>
    </div>
</div>