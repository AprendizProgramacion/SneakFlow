<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilo para mostrar/ocultar el contenido del filtro */
        .filter-content {
            display: none;
        }

        .filter-item {
            margin-bottom: 16px; /* Espaciado inferior para cada filtro */
        }

        .filter-item.open .filter-content {
            display: block;
        }

        .filter-item.open .filter-content ul {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
            padding: 0;
            list-style: none;
            margin: 0;
        }

        .filter-item.open .filter-content ul li {
            display: flex;
            padding: 8px;
            background-color: #f9f9f9;
            border-radius: 4px;
            transition: background-color 0.2s ease-in-out;
        }
        
        .filter-item.open .filter-content ul li:hover {
            background-color: #f0f0f0;
        }
        .filter-item.open .filter-content ul li input[type="checkbox"] {
            margin-right: 8px;
            accent-color: #4caf50;
            transform: scale(1.2);
            transition: transform 0.2s ease-in-out;
        }
        .filter-item.open .filter-content ul li input[type="checkbox"]:hover {
            transform: scale(1.3);
        }
        /* Estilos para el rango de precios */
        .range-slider {
            height: 8px;
            background: #ddd;
            border-radius: 4px;
            position: relative;
            margin-top: 8px;
        }
        .range-slider::before {
            content: "";
            display: block;
            height: 100%;
            background: #4caf50;
            border-radius: 4px;
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            transition: width 0.3s;
        }

        /* Estilos para los checkboxes ocultos */
        .tallas-checkbox {
            display: none;
        }
        #tallas-table td {
            cursor: pointer;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        #tallas-table td:hover {
            background-color: #f0f0f0;
            color: #333;
        }
        /* Estilo visual para las celdas seleccionadas */
        td.selected {
            background-color: #4caf50; /* Cambiado el color de fondo a verde */
            color: #fff; /* Color de texto blanco para contraste */
            font-weight: bold;
            border-radius: 4px;
        }

        /* Estilos personalizados para el filtro de botones */
        .filter-btn {
            background: linear-gradient(135deg, #6b73ff 0%, #000dff 100%);
            color: white;
            text-align: center;
            border: none;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .filter-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Estilos para el contenido de los filtros */
        .filter-content {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s, transform 0.3s;
        }

        .filter-item.open .filter-content {
            opacity: 1;
            transform: translateY(0);
        }

        /* Estilos personalizados para el botón de aplicar filtros */
        .apply-filters-btn {
            background: linear-gradient(135deg, #f09433 0%, #e6683c 50%, #dc2743 100%);
            color: white;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .apply-filters-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(    0, 0, 0, 0.2);
        }


    </style>
</head>
<body class="bg-gray-100 p-6 font-sans leading-normal tracking-normal">

    <!-- Formulario de Filtros -->
    <form id="filter-form" method="GET" action="productos" class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex flex-wrap items-start gap-4">
            <!-- Contenedor de Filtros -->
            <div class="flex flex-wrap gap-4 flex-grow">
                <!-- Filtro de Marca -->
                <div class="relative flex-grow filter-item">
                    <button type="button" class="filter-btn bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-300 transition-all w-full text-left" onclick="toggleFilter(this)">
                        Marca
                    </button>
                    <div class="filter-content bg-white border border-gray-300 rounded-lg p-4 shadow-lg mt-2">
                        <ul class="space-y-2">
                            <li><label><input type="checkbox" name="marca[]" value="Fila" class="mr-2">Fila</label></li>
                            <li><label><input type="checkbox" name="marca[]" value="Nike" class="mr-2">Nike</label></li>
                            <li><label><input type="checkbox" name="marca[]" value="Adidas" class="mr-2">Adidas</label></li>
                            <li><label><input type="checkbox" name="marca[]" value="Puma" class="mr-2">Puma</label></li>
                        </ul>
                    </div>
                </div>

                <!-- Filtro de Género -->
                <div class="relative flex-grow filter-item">
                    <button type="button" class="filter-btn bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-300 transition-all w-full text-left" onclick="toggleFilter(this)">
                        Género
                    </button>
                    <div class="filter-content bg-white border border-gray-300 rounded-lg p-4 shadow-lg mt-2">
                        <ul class="space-y-2">
                            <li><label><input type="checkbox" name="genero[]" value="Hombre" class="mr-2">Hombre</label></li>
                            <li><label><input type="checkbox" name="genero[]" value="Mujer" class="mr-2">Mujer</label></li>
                            <li><label><input type="checkbox" name="genero[]" value="Unisex" class="mr-2">Unisex</label></li>
                        </ul>
                    </div>
                </div>

                 <!-- Filtro de Talla -->
                <div class="relative flex-grow filter-item">
                    <button type="button" class="filter-btn bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-300 transition-all w-full text-left" onclick="toggleFilter(this)">
                        Talla
                    </button>
                    <div class="filter-content bg-white border border-gray-300 rounded-lg p-4 shadow-lg mt-2">
                        <table id="tallas-table" class="w-full">
                            <tr class="table-row">
                                <td class="py-2 px-3">
                                    <input type="checkbox" name="talla[]" value="36" class="tallas-checkbox">
                                    36
                                </td>
                                <td class="py-2 px-3">
                                    <input type="checkbox" name="talla[]" value="37" class="tallas-checkbox">
                                    37
                                </td>
                                <td class="py-2 px-3">
                                    <input type="checkbox" name="talla[]" value="38" class="tallas-checkbox">
                                    38
                                </td>
                            </tr>
                            <tr class="table-row">
                                <td class="py-2 px-3">
                                    <input type="checkbox" name="talla[]" value="39" class="tallas-checkbox">
                                    39
                                </td>
                                <td class="py-2 px-3">
                                    <input type="checkbox" name="talla[]" value="40" class="tallas-checkbox">
                                    40
                                </td>
                                <td class="py-2 px-3">
                                    <input type="checkbox" name="talla[]" value="41" class="tallas-checkbox">
                                    41
                                </td>
                            </tr>
                            <!-- Añade más filas según sea necesario -->
                        </table>
                    </div>
                </div>


                <!-- Filtro de Color -->
                <div class="relative flex-grow filter-item">
                    <button type="button" class="filter-btn bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-300 transition-all w-full text-left" onclick="toggleFilter(this)">
                        Color
                    </button>
                    <div class="filter-content bg-white border border-gray-300 rounded-lg p-4 shadow-lg mt-2">
                        <ul class="space-y-2">
                            <li><label><input type="checkbox" name="color[]" value="Blanco" class="mr-2">Blanco</label></li>
                            <li><label><input type="checkbox" name="color[]" value="Rosado" class="mr-2">Rosado</label></li>
                        </ul>
                    </div>
                </div>

                <!-- Filtro de Descuento -->
                <div class="relative flex-grow filter-item">
                    <button type="button" class="filter-btn bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-300 transition-all w-full text-left" onclick="toggleFilter(this)">
                        Descuento
                    </button>
                    <div class="filter-content bg-white border border-gray-300 rounded-lg p-4 shadow-lg mt-2">
                        <ul class="space-y-2">
                            <li><label><input type="checkbox" name="descuento[]" value="5" class="mr-2">5%</label></li>
                            <li><label><input type="checkbox" name="descuento[]" value="10" class="mr-2">10%</label></li>
                        </ul>
                    </div>
                </div>

                <!-- Filtro de Precio -->
                <div class="relative flex-grow filter-item">
                    <button type="button" class="filter-btn bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-300 transition-all w-full text-left" onclick="toggleFilter(this)">
                        Precio
                    </button>
                    <div class="filter-content bg-white border border-gray-300 rounded-lg p-6 shadow-lg mt-2">
                        <div class="flex flex-col gap-4">
                            <div class="flex justify-between text-lg font-semibold">
                                <span>$</span>
                                <span id="min-label">50,000</span>
                                <span>~~</span>
                                <span>$</span>
                                <span id="max-label">500,000</span>
                            </div>
                            <input type="range" id="precio-min" name="precio_min" min="50000" max="500000" value="50000" step="1000" class="w-full">
                            <input type="range" id="precio-max" name="precio_max" min="50000" max="500000" value="500000" step="1000" class="w-full">
                            <div class="range-slider" id="slider-range"></div>
                        </div>
                    </div>
                </div>

                <!-- Botón de Aplicar Filtros -->
                <div class="flex-grow">
                    <button type="submit" class="bg-gradient-to-r from-gray-700 via-gray-900 to-black text-white font-semibold py-3 rounded-lg hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-700 hover:to-blue-900 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 shadow-lg hover:shadow-xl w-full">
                        Aplicar Filtros
                    </button>         
                </div>
            </div>
        </div>
    </form>

    <script>
        // Función para mostrar/ocultar el contenido del filtro
        function toggleFilter(button) {
            const filterItem = button.parentElement;
            filterItem.classList.toggle('open');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const cells = document.querySelectorAll('#tallas-table td');
            const hiddenInput = document.getElementById('tallas-seleccionadas');

            cells.forEach(cell => {
                const checkbox = cell.querySelector('input.tallas-checkbox');

                cell.addEventListener('click', () => {
                    if (checkbox) {
                        checkbox.checked = !checkbox.checked; // Alterna el estado del checkbox
                        cell.classList.toggle('selected', checkbox.checked);
                        updateSelectedValues();
                    }
                });
            });

            function updateSelectedValues() {
                const selectedValues = [];
                document.querySelectorAll('#tallas-table td.selected input.tallas-checkbox:checked').forEach(checkbox => {
                    selectedValues.push(checkbox.value);
                });
                hiddenInput.value = selectedValues.join(',');
            }
        });


        // Actualizar el rango del slider de precio
        function updateSliderRange() {
            const min = parseInt(document.getElementById('precio-min').value);
            const max = parseInt(document.getElementById('precio-max').value);
            const slider = document.getElementById('slider-range');
            slider.style.width = ((max - min) / 500000) * 100 + '%';
            document.getElementById('min-label').textContent = min.toLocaleString();
            document.getElementById('max-label').textContent = max.toLocaleString();
        }

        // Inicializar los valores del slider
        updateSliderRange();

        // Escuchar eventos de cambio en los rangos
        document.getElementById('precio-min').addEventListener('input', updateSliderRange);
        document.getElementById('precio-max').addEventListener('input', updateSliderRange);
    </script>
</body>
</html>
