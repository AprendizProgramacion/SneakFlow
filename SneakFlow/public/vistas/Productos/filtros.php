
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
                grid-template-columns: repeat(2, 1fr); /* 4 columnas */
                gap: 10px;
                padding: 0;
                list-style: none;
                margin: 0;
                align-items: start; /* Alinea los ítems al inicio de la fila */
            }

            .filter-item.open .filter-content ul li {
                display: flex;
                align-items: center; /* Centra el contenido verticalmente */
                justify-content: flex-start;
                padding: 8px;
                background-color: #f9f9f9;
                border-radius: 4px;
                transition: background-color 0.2s ease-in-out;
                min-height: 40px; /* Define una altura mínima uniforme para los ítems */
                box-sizing: border-box; /* Incluye padding y borde en el cálculo de la altura */
                margin: 0; /* Asegúrate de que no haya margen adicional */
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
            background: transparent; /* Fondo transparente */
            color: black; /* Texto negro */
            text-align: center;
            border: none;
            padding: 10px;
            border-bottom: 2px solid #ddd; /* Borde inferior sutil */
            border-radius: 0; /* Sin bordes redondeados */
            box-shadow: none; /* Sin sombra */
            transition: background-color 0.3s, border-color 0.3s;
        }

        .filter-btn:hover {
            background-color: #f0f0f0; /* Fondo ligero al pasar el ratón */
        }

        .filter-item.open .filter-btn {
            border-color: #4caf50; /* Cambia el borde cuando está abierto */
            background-color: #f9f9f9; /* Fondo claro cuando está abierto */
        }

        /* Estilo para el contenido del filtro */
        .filter-content {
            background: transparent; /* Fondo transparente */
            border: none; /* Sin borde */
            border-bottom: 1px solid #ddd; /* Borde inferior */
            box-shadow: none; /* Sin sombra */
            padding: 20px;
            transition: opacity 0.3s ease-in-out, transform 0.3s;
        }

        .filter-item.open .filter-content {
            border-bottom: 1px solid #4caf50; /* Cambia el borde cuando está abierto */
            background: white; /* Fondo blanco cuando está abierto */
        }

    </style>
<body class="bg-gray-100 p-6 font-sans leading-normal tracking-normal">
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
                            <?php foreach ($marcas as $marca): ?>
                                <li>
                                    <label>
                                        <input type="checkbox" name="marca[]" value="<?php echo htmlspecialchars($marca['marca']); ?>" class="mr-2">
                                        <?php echo htmlspecialchars($marca['marca']); ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
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
                            <?php
                            // Supongamos que $tallas es un array de tallas pasadas desde el controlador
                            $num_columns = 4; // Número de columnas que deseas en la tabla
                            $column_count = 0;

                            foreach ($tallas as $talla) {
                                if ($column_count % $num_columns == 0) {
                                    if ($column_count > 0) {
                                        echo '</tr>';
                                    }
                                    echo '<tr class="table-row">';
                                }

                                echo '<td class="py-2 px-3">';
                                echo '<input type="checkbox" name="talla[]" value="' . htmlspecialchars($talla['talla']) . '" class="tallas-checkbox">';
                                echo htmlspecialchars($talla['talla']);
                                echo '</td>';

                                $column_count++;
                            }

                            // Cierra la última fila si es necesario
                            if ($column_count % $num_columns != 0) {
                                while ($column_count % $num_columns != 0) {
                                    echo '<td class="py-2 px-3"></td>';
                                    $column_count++;
                                }
                                echo '</tr>';
                            }
                            ?>
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
                            <?php if (!empty($colores)): ?>
                                <?php foreach ($colores as $color): ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="color[]" value="<?php echo htmlspecialchars($color['color']); ?>" class="mr-2">
                                            <?php echo htmlspecialchars($color['color']); ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>No hay colores disponibles.</li>
                            <?php endif; ?>
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
                            <li><label><input type="checkbox" name="descuento[]" value="15" class="mr-2">15%</label></li>
                            <li><label><input type="checkbox" name="descuento[]" value="20" class="mr-2">20%</label></li>
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
