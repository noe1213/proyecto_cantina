<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Cafetín Jesús Obrero</title>
    <link rel="icon" href="imagenes/cj.png" type="image/png">
    @vite(['resources/css/indexlog.css',
    'resources/js/app.js','resources/css/general-admin.css','resources/css/template/menu-admin.css'])
    <!-- Asegúrate de tener un archivo CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script>
        function mostrarAlertas() {
            const alertas = document.getElementById("alertas");
            alertas.style.display =
                alertas.style.display === "block" ? "none" : "block";
        }
    </script>
</head>