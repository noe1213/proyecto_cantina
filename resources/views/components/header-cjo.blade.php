<!-- resources/views/components/header-cjo.blade.php -->
<header style="background-color: #002366; color: white; padding: 10px; display: flex; align-items: center; justify-content: space-between;">
    <div class="logo" style="display: flex; align-items: center;">
        <img src="{{ asset('imagenes/cj.png') }}" alt="Logo Cafetería Jesús Obrero" style="height: 120px;  margin-right: 10px;">
        <h1 style="font-size: 44px; margin-left: 10px; margin-right: 150px;">CJO</h1>
    </div>
    <nav style="display: flex; align-items: center;margin-left: 59px;margin-right: 450px;">
       
        <div class="search" style="margin-left: 1px; margin-right: 50px;">
            {{ $slot }}
            <input type="text" id="searchInput" placeholder="Buscar productos..." onkeyup="filterProducts()" style="padding:8px 46px;">
            <button type="button" style="padding: 8px 10px; margin-right: 50px;  background-color: #004080; color: white; border: none; border-radius: 5px;"><i class="fas fa-search"></i></button>
            </div>
          
            
       
            <ul class="header-nav">
        <a href="{{ route('historial') }}" style="color: white; text-decoration: none; font-size: 20px; display: flex; align-items: center; padding: 10px 20px; border-radius: 5px;">
                    <i class= "fas fa-history" style="margin-right: 5px;"></i> Historial
                </a> 
               
</ul>
<ul class="header-nav">
<a  href="{{ route('index') }}" style="color: white; text-decoration: none; font-size: 20px; display: flex; align-items: center; padding: 10px 20px; border-radius: 5px;">
<i class="fas fa-sign-out-alt"> </i>  Salir

                </a> 
                </ul>
        <div class="cart-container " onclick="toggleCart()" style="margin-left: 20px;font-size: 44%; display: flex; align-items: center; cursor: pointer;">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count" id="cartCount" style="margin-left: 2px;">0</span>
        </div>
       
    </nav>
</header>

