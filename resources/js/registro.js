fetch("/api/clientes", {
    method: "POST",
    body: formData,
    headers: {
        "X-CSRF-TOKEN": document.querySelector(
            'input[name="_token"]'
        ).value, // Incluir el token CSRF
    },
})
    .then((response) => {
        if (!response.ok) {
            throw new Error(`Error ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then((data) => {
        console.log("Cliente registrado:", data);
        alert("Cliente registrado exitosamente."); // Mensaje de éxito
        document.getElementById("registration-form").reset(); // Limpiar el formulario
    })
    .catch((error) => {
        if (error.message.includes('422')) {
            // Manejar errores de validación
            fetch(error.message.split(' ')[1])
                .then(response => response.json())
                .then(data => {
                    Object.keys(data.errors).forEach(key => {
                        alert(`${key}: ${data.errors[key][0]}`);
                    });
                });
        } else {
            console.error("Error:", error);
            alert("Error al registrar el cliente."); // Mensaje de error
        }
    });
