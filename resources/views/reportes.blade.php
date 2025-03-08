<x-head-reportes></x-head-reportes>

<body>
    <x-header-cjoae></x-header-cjoae>

    <main>
        <!-- Interfaz de Administración -->
        <x-menu-admin></x-menu-admin>

        <!-- Sección de Reportes -->
        <div class="content-section">
            <div class="report-container">
                <h2 class="section-title">Reportes</h2>

                <!-- Filtro de Reportes -->
                <div class="filter-container mb-4">
                    <label for="calendarFilter">Seleccionar fecha:</label>
                    <input type="date" id="calendarFilter" onchange="filterByDate()" class="form-control mx-2" />
                </div>

                <!-- Resumen de Reportes -->
                <div id="summaryReport" class="border p-3 rounded shadow hidden">
                    <h3>Resumen del reporte para el:</h3>
                    <p id="selectedDate" class="fw-bold"></p>

                    <!-- Reporte por categorías de productos -->
                    <div class="report hidden" id="mostOrderedReport">
                        <h4>Productos más pedidos:</h4>
                        <ul id="mostOrderedProducts" class="list-group"></ul>
                    </div>

                    <div class="report hidden" id="leastOrderedReport">
                        <h4>Productos menos pedidos:</h4>
                        <ul id="leastOrderedProducts" class="list-group"></ul>
                    </div>

                    <div class="report hidden" id="peakSalesReport">
                        <h4>Momentos de más ventas:</h4>
                        <ul id="peakSalesTimes" class="list-group"></ul>
                    </div>

                    <!-- Resumen de Ganancias -->
                    <div id="profitSummary" class="">
                        <h4>Resumen de ganancias:</h4>
                        <p id="profitText"></p>
                    </div>

                    <!-- Análisis del Reporte -->
                    <div id="analysisSummary" class="">
                        <h4>Análisis del reporte:</h4>
                        <p id="analysisText"></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-footeradmin></x-footeradmin>
    <script>
    function filterByDate() {
    const selectedDate = document.getElementById('calendarFilter').value;

    // Mostrar la fecha seleccionada
    document.getElementById('selectedDate').innerText = selectedDate;

    // Simulación de datos; reemplaza esto con tu lógica real para obtener datos según la fecha seleccionada.
    const mostOrderedProducts = [
        `Café: 30 pedidos en ${selectedDate}`,
        `Empanadas: 25 pedidos en ${selectedDate}`
    ];
    const leastOrderedProducts = [
        `Bebida Energética: 5 pedidos en ${selectedDate}`,
        `Chicles: 2 pedidos en ${selectedDate}`
    ];
    const peakSalesTimes = [
        `8:00 AM - 9:00 AM en ${selectedDate}`
    ];

    // Mostrar resultados en base a la fecha seleccionada
    document.getElementById('summaryReport').classList.remove('hidden');
    document.getElementById('mostOrderedReport').classList.remove('hidden');
    document.getElementById('leastOrderedReport').classList.remove('hidden');
    document.getElementById('peakSalesReport').classList.remove('hidden');

    // Resumen de ganancias (simulado)
    const totalSales = 1000; // Reemplaza con lógica real
    const totalCosts = 600; // Reemplaza con lógica real
    const profit = totalSales - totalCosts;

    // Mostrar el resumen de ganancias
    document.getElementById('profitText').innerText =
        `Total Ventas: $${totalSales}, Total Costos: $${totalCosts}, Ganancia: $${profit}`;

    // Análisis del reporte (simulado)
    const analysisText =
        `El día ${selectedDate} se observó un incremento en las ventas comparado con el día anterior, lo que sugiere una tendencia positiva.`;

    // Actualiza las listas con datos simulados (reemplaza con tus datos reales)
    document.getElementById('mostOrderedProducts').innerHTML = mostOrderedProducts.map(item =>
        `<li class="list-group-item">${item}</li>`).join('');
    document.getElementById('leastOrderedProducts').innerHTML = leastOrderedProducts.map(item =>
        `<li class="list-group-item">${item}</li>`).join('');
    document.getElementById('peakSalesTimes').innerHTML = peakSalesTimes.map(item =>
        `<li class="list-group-item">${item}</li>`).join('');

    // Mostrar el análisis del reporte
    document.getElementById('analysisText').innerText = analysisText;
}
</script>
</body>
</html>