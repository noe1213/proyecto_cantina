import Swal from "sweetalert2";
document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");
    const errorMessage = document.getElementById("errorMessage");

    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario

            const correo = document.getElementById("correo").value;
            const contrasena = document.getElementById("contrasena").value;

            // Enviar los datos al servidor
            fetch("/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({ correo, password: contrasena }),
            })
                .then((response) => {
                    if (!response.ok) {
                        // Si la respuesta no es exitosa, lanzar un error
                        return response.json().then((errorData) => {
                            Swal.fire({
                                title: "Error",
                                text: errorData.errors,
                                icon: "error",
                            });
                            console.error(
                                "Errores de validación:",
                                errorData.errors
                            ); // Imprimir errores en la consola
                            throw new Error(
                                errorData.error || "Error en el servidor"
                            );
                        });
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        // Redirigir al usuario si el login es exitoso
                        window.location.href = data.redirect;
                    } else {
                        // Mostrar mensaje de error si las credenciales son incorrectas
                        Swal.fire({
                            title: "Error",
                            text: data.error,
                            icon: "error",
                        });
                        errorMessage.textContent =
                            data.error || "Credenciales incorrectas";
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        title: "Error",
                        text: error,
                        icon: "error",
                    });
                    console.error("Error:", error);
                    errorMessage.textContent =
                        "Ocurrió un error al intentar iniciar sesión";
                });
        });
    }
});
