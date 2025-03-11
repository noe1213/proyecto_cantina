<!-- resources/views/components/header-cjo.blade.php -->
<header style="background-color: #002366; color: white; padding: 10px; display: flex; align-items: center; justify-content: space-between;">
    <div class="logo" style="display: flex; align-items: center;">
        <img src="{{ asset('imagenes/cj.png') }}" alt="Logo Cafetería Jesús Obrero" style="height: 120px; margin-right: 20px;">
        <h1 style="margin: 0;">CJO</h1>
        <nav>
        <ul style="list-style: none; padding: 0; display: flex;">
            {{ $slot }}
        </ul>
        </div>
        <div id="notification-container" class="notification-container">
    <span id="notification-badge" class="badge"> </span> <!-- Contador -->
    <button id="notification-button" class="bell-icon">🔔</button> <!-- Icono de campanita -->
    <ul id="notification-list" class="notification-list" style="display:none;">
        
        <!-- Aquí se mostrarán las notificaciones -->
    </ul>
</div>




    
    </nav>
  
    
</header>
