<!-- resources/views/components/header-cjo.blade.php -->
<header style="background-color: #002366; color: white; padding: 10px; display: flex; align-items: center; justify-content: space-between;">
    <div class="logo" style="display: flex; align-items: center;">
        <img src="{{ asset('imagenes/cj.png') }}" alt="Logo CJO" style="height: 120px; margin-right: 10px;">
        <h1 style="font-size: 44px; margin-left: 10px; margin-right: 650px;">CJO</h1>
        <nav style="margin-left: 50px; display: flex; align-items: center;">
        <ul class="header-nav" style="list-style: none; padding: 0; margin: 0; display: flex;">
            <li>
                <a href="{{ route('catalogo') }}" style="color: white; text-decoration: none; font-size: 26px; display: flex; align-items: center; padding: 10px 20px; border-radius: 5px;">
                    <i class="fas fa-concierge-bell" style="margin-right: 5px;"></i>Menú
                </a>
            </li>
        
        
<a  href="{{ route('index') }}" style="color: white; text-decoration: none; font-size: 26px; display: flex; align-items: center; padding: 10px 20px; border-radius: 5px;">
<i class="fas fa-sign-out-alt"></i> Salir

                </a> 
                </ul>
    </nav>
    </div>
    
</header>
