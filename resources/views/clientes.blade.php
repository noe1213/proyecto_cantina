<x-head-admin></x-head-admin>


<body>
    <x-header-cjoae></x-header-cjoae>


    <main>
        <!-- Interfaz de Administración -->
        <x-menu-admin></x-menu-admin>

        <!-- Tabla de Clientes -->
        <div class="table-container">
            <h2 class="section-title">Clientes Registrados</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="client-list">
                    <!-- Aquí se agregarán los clientes dinámicamente -->
                </tbody>
            </table>
        </div>

        <script>

        </script>


    </main>

    
    <x-footeradmin></x-footeradmin>
    @vite(['resources/css/clientes.css','resources/js/clientes.js'])
    <script>
    // Función para obtener los clientes al cargar la página
    function fetchClients() {
        fetch("/api/clientes") // Asegúrate de que esta ruta esté definida en tu API
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error al obtener clientes");
                }
                return response.json(); // Convertir la respuesta a JSON
            })
            .then((data) => {
                data.forEach((client) => {
                    addClientToTable(client); // Agregar cada cliente a la tabla
                });
            })
            .catch((error) => {
                console.error("Error al obtener clientes:", error);
            });
    }

    // Función para agregar un cliente a la tabla
    function addClientToTable(client) {
        const clientList = document.getElementById("client-list");
        const row = document.createElement("tr");
        row.innerHTML = `
        <td>${client.ci}</td>
        <td>${client.nombre}</td>
        <td>${client.apellido}</td>
        <td>${client.correo}</td>
        <td>${client.telefono}</td>
        <td>
            <button class="edit-button" onclick="editClient(${client.ci})">Editar</button>
            <button class="delete-button" onclick="deleteClient(${client.ci})">Eliminar</button>
        </td>
    `;
        clientList.appendChild(row); // Agregar la fila a la tabla
    }

    // Llamar a la función para obtener los clientes al cargar la página
    window.onload = fetchClients;
    // Función para editar un cliente
    function editClient(ci) {
        // Lógica para editar el cliente
        console.log("Editar cliente con CI:", ci);
        // Aquí puedes implementar la lógica para cargar los datos del cliente en un formulario
    }

    // Función para eliminar un cliente
    function deleteClient(ci) {
        fetch(`/api/clientes/${ci}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                        .value, // Incluir el token CSRF
                },
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error al eliminar el cliente");
                }
                // Eliminar la fila de la tabla
                const row = document.querySelector(`tr[data-id="${ci}"]`);
                if (row) {
                    row.remove();
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }

    // Llamar a la función para obtener los clientes al cargar la página
    window.onload = fetchClients;
    </script>

    </html>