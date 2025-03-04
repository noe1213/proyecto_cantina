<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafetín Jesús Obrero</title>
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/css/st.css', 'resources/css/indexlog.css'])
    <link rel="icon" href="imagenes/cj.png" type="image/png"> <!-- Enlace al favicon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<x-header>
        <nav>
            <ul>
                <li><a href="{{ route('login') }}" class="btn-login">Iniciar sesion <i class="fas fa-sign-in-alt"></i></a></li>
            </ul>
    </x-header>


    <main >
        <section class="slider">
            <div class="slides">
            <img src="{{ asset('imagenes/pan.jpeg') }}" alt="Foto 1">
               
                <img src="{{ asset('imagenes/omelette.jpeg') }}" alt="Foto 4">
            </div>
            <button id="prevBtn" class="slider-btn">❮</button>
            <button id="nextBtn" class="slider-btn">❯</button>
        </section>
    <main>
    <section id="bienvenida" class="info">
    <div class="welcome-container">
        <h1 class="title">¡Bienvenidos a Cafetería Jesús Obrero!</h1>
        <p class="welcome-text">Tu lugar para disfrutar de deliciosos desayunos y almuerzos.</p>
        <p class="welcome-text"><strong>¡Haz tu pedido en línea y evita las colas!</strong></p>
        
      


        <section id="categorias">
    <h1  class="title"> Redes sociales</h1>
    <div class="category-list">
        <div class="category-item">
            <button onclick="window.location.href='https://www.instagram.com/cafetin.jo?igsh=MTFrdjdxc2YxNG82dA=='" class="icon-button">
            <i class="fab fa-instagram  icon "></i>
            </button>
            <span>instagram</span>
        </div>
        <div class="category-item">
            <button onclick="window.location.href='https://www.tiktok.com/@cafetin.jesus.obr'" class="icon-button">
            <i class="fab fa-tiktok icon"></i>
            </button>
            <span>Tik Tok</span>
        </div>
    </div>
</section>
    </div>

</section>
    </main>

    
    <x-footer>
        
        </x-footer>
    

    <script>
        let currentIndex = 0;

const slides = document.querySelectorAll('.slides img');
const totalSlides = slides.length;

document.getElementById('nextBtn').addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % totalSlides; // Mueve al siguiente
    updateSlides();
});

document.getElementById('prevBtn').addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides; // Mueve al anterior
    updateSlides();
});

function updateSlides() {
    slides.forEach((slide, index) => {
        slide.style.display = index === currentIndex ? 'block' : 'none';
        slide.style.marginRight = '10px'; // Espacio entre imágenes
        slide.style.transition = 'transform 0.5s ease'; // Transición suave
        slide.style.transform = index === currentIndex ? 'scale(1)' : 'scale(0.9)'; // Efecto de escala
    });
}

// Inicializa el slider mostrando solo la primera imagen
updateSlides();
    </script>
</body>
</html>