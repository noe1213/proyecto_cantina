import Swal from "sweetalert2";

// Obtener el formulario
const form = document.getElementById("registration-form");

// Validación del formulario en el frontend
const validateForm = () => {
    const email = form.querySelector('input[name="correo"]').value;
    const password = form.querySelector('input[name="contrasena"]').value;
    const confirmPassword = form.querySelector(
        'input[name="confir_contra"]'
    ).value;

    if (!email || !password || !confirmPassword) {
        Swal.fire({
            title: "Error",
            text: "Todos los campos son obligatorios.",
            icon: "error",
            confirmButtonText: "Aceptar",
        });
        return false;
    }

    if (password !== confirmPassword) {
        Swal.fire({
            title: "Error",
            text: "Las contraseñas no coinciden.",
            icon: "error",
            confirmButtonText: "Aceptar",
        });
        return false;
    }

    return true;
};

// Manejar el envío del formulario
form.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevenir el envío automático del formulario

    // Validar el formulario en el frontend
    if (!validateForm()) {
        return; // Detener el envío si la validación falla
    }

    // Obtener el token CSRF
    const token = document.querySelector('input[name="_token"]').value;

    // Enviar el formulario
    fetch("/api/clientes", {
        method: "POST",
        body: new FormData(form), // Usar FormData para enviar los datos del formulario
        headers: {
            "X-CSRF-TOKEN": token, // Incluir el token CSRF
        },
    })
        .then((response) => {
            if (!response.ok) {
                // Si la respuesta no es exitosa, lanzar un error con el código de estado
                return response.json().then((errorData) => {
                    throw { status: response.status, data: errorData };
                });
            }
            return response.json(); // Si la respuesta es exitosa, devolver los datos JSON
        })
        .then((data) => {
            console.log("Cliente registrado:", data);
            Swal.fire({
                title: "¡Cliente registrado!",
                text: "El cliente se ha registrado exitosamente.",
                icon: "success",
                confirmButtonText: "Aceptar",
            });
            form.reset(); // Limpiar el formulario
        })
        .catch((error) => {
            if (error.status === 422) {
                // Manejar errores de validación
                const errors = error.data.errors;
                Object.keys(errors).forEach((key) => {
                    Swal.fire({
                        title: "Error de validación",
                        text: `${key}: ${errors[key][0]}`, // Mostrar el primer mensaje de error para cada campo
                        icon: "error",
                        confirmButtonText: "Aceptar",
                    });
                });
            } else {
                // Manejar otros errores (por ejemplo, errores 500)
                console.error("Error:", error);
                Swal.fire({
                    title: "Error",
                    text: "Ocurrió un error al registrar el cliente. Por favor, inténtalo de nuevo.",
                    icon: "error",
                    confirmButtonText: "Aceptar",
                });
            }
        });
<<<<<<< HEAD
});
=======
});
>>>>>>> 86a2021f577fd31c6d1a217dbdcddc4f39302260
