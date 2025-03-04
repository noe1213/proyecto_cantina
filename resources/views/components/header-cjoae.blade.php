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
        <div class="notification-icon" onclick="mostrarAlertas()">
                <i class="bi bi-bell-fill" style="font-size: 2rem;"></i>
                <span class="badge rounded-pill bg-danger notification-badge">3</span> <!-- Número de notificaciones -->
            </div>
        </div>
    </nav>
    <div>
    <div class="alertas-container">
    <div id="alertas" class="hidden">
        <p>Alerta: Empanadas - Stock bajo (Actual: 3, Mínimo: 4)</p>
        <p>Alerta: Galletas - Stock bajo (Actual: 8, Mínimo: 10)</p>
        <p>Alerta: Bebidas - Stock bajo (Actual: 4, Mínimo: 5)</p>
    </div>
    </div> 
    </nav>
  
    
</header>
