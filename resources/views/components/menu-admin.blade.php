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
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <!-- Token CSRF para seguridad -->
                    <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </button>
                </form>
            </li>
        </ul>
    </aside>
</div>