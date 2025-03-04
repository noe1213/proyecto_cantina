<div class="admin-interface">
    <aside class="sidebar">
        <h2>Menú del administrador</h2>
        <ul class="admin-menu">
            <li><a href="{{ route('reportes') }}"><i class="fas fa-chart-line"></i>
                    Reportes</a></li>
            <li><a href="{{ route('clientes') }}"><i class="fas fa-users"></i> Gestionar
                    clientes</a></li>
            <li><a href="{{ route('productos') }}"><i class="fas fa-utensils"></i> Actualizar/Editar
                    menú</a></li>
            <li><a href="{{ route('pedidos') }}"><i class="fas fa-utensils"></i> Pedidos
                    registrados</a></li>
            <li><a href="{{ route('index') }}"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
        </ul>
    </aside>
</div>