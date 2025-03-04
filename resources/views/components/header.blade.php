<!-- resources/views/components/header.blade.php -->
<header style="background-color: #002366; color: white; padding: 10px; display: flex; align-items: center; justify-content: space-between;">
    <div class="logo" style="display: flex; align-items: center;">
        <img src="{{ asset('imagenes/cj.png') }}" alt="Logo Cafetería Jesús Obrero" style="height: 120px; margin-right: 10px;">
        <h1 style="margin: 0;">Cafetín Jesús Obrero</h1>
    </div>
    <nav>
        <ul style="list-style: none; padding: 0; display: flex;">
            {{ $slot }}
        </ul>
    </nav>
</header>
