        <?php require_once '../public/vistas/header.php'; ?>
        <link rel="stylesheet" href="/SneakFlow/public/vistas/css/product_marca.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <div class="container mx-auto mt-20"> <!-- Contenedor principal -->
            <h1 class="text-4xl font-bold mb-2 text-center shadow-title"><?php echo htmlspecialchars($producto_marca['marca']); ?></h1> <!-- Título con el nombre de la marca -->
            <p class="mb-4 ml-6 text-description"><?php echo htmlspecialchars($producto_marca['descripcion']); ?></p> <!-- Descripción de la marca -->

            <div class="flex items-start"> <!-- Contenedor flexible para los filtros y productos -->
                <div class="filtros w-1/5 p-4 rounded-lg shadow-lg ml-4 bg-white"> <!-- Contenedor para los filtros -->
                    <form action="marca" method="GET"> <!-- Agregar el formulario aquí -->
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_marca); ?>"> <!-- Campo oculto para el ID de la marca -->

                        <!-- Filtro de Género -->
                        <div class="filtro border border-gray-300 p-4 rounded-lg mb-4">
                            <h3 class="font-semibold mb-2">Género</h3>
                            <hr class="mb-2">
                            <div class="max-h-32 overflow-y-auto">
                                <ul>
                                    <li class="flex items-center mb-2">
                                        <input type="checkbox" name="genero[]" value="Hombre" id="genero_hombre" class="h-5 w-5 text-blue-600 border-gray-300 rounded mr-2">
                                        <label for="genero_hombre" class="text-gray-700">Hombre</label>
                                    </li>
                                    <li class="flex items-center mb-2">
                                        <input type="checkbox" name="genero[]" value="Mujer" id="genero_mujer" class="h-5 w-5 text-blue-600 border-gray-300 rounded mr-2">
                                        <label for="genero_mujer" class="text-gray-700">Mujer</label>
                                    </li>
                                    <li class="flex items-center mb-2">
                                        <input type="checkbox" name="genero[]" value="Unisex" id="genero_unisex" class="h-5 w-5 text-blue-600 border-gray-300 rounded mr-2">
                                        <label for="genero_unisex" class="text-gray-700">Unisex</label>
                                    </li>
                                </ul>
                            </div>
                            <button type="submit" class="mt-4 w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-300">Aplicar</button>
                        </div>

                        <!-- Filtro de Talla -->
                        <div class="filtro border border-gray-300 p-4 rounded-lg mb-4">
                            <h3 class="font-semibold mb-2">Talla</h3>
                            <hr class="mb-2">
                            <div class="max-h-32 overflow-y-auto">
                                <ul>
                                    <?php foreach ($tallas as $talla): ?>
                                        <li class="flex items-center mb-2">
                                            <input type="checkbox" name="talla[]" value="<?php echo htmlspecialchars($talla['talla']); ?>" id="talla_<?php echo htmlspecialchars($talla['talla']); ?>" class="h-5 w-5 text-blue-600 border-gray-300 rounded mr-2">
                                            <label for="talla_<?php echo htmlspecialchars($talla['talla']); ?>" class="text-gray-700"><?php echo htmlspecialchars($talla['talla']); ?></label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <button type="submit" class="mt-4 w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-300">Aplicar</button>
                        </div>

                        <!-- Filtro de Color -->
                        <div class="filtro border border-gray-300 p-4 rounded-lg mb-4">
                            <h3 class="font-semibold mb-2">Color</h3>
                            <hr class="mb-2">
                            <div class="max-h-32 overflow-y-auto">
                                <ul>
                                    <?php if (!empty($colores)): ?>
                                        <?php foreach ($colores as $color): ?>
                                            <li class="flex items-center mb-2">
                                                <input type="checkbox" name="color[]" value="<?php echo htmlspecialchars($color['color']); ?>" id="color_<?php echo htmlspecialchars($color['color']); ?>" class="h-5 w-5 text-blue-600 border-gray-300 rounded mr-2">
                                                <label for="color_<?php echo htmlspecialchars($color['color']); ?>" class="text-gray-700"><?php echo htmlspecialchars($color['color']); ?></label>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li class="text-gray-500">No hay colores disponibles.</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <button type="submit" class="mt-4 w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-300">Aplicar</button>
                        </div>

                        <!-- Filtro de Descuento -->
                        <div class="filtro border border-gray-300 p-4 rounded-lg mb-4">
                            <h3 class="font-semibold mb-2">Descuento</h3>
                            <hr class="mb-2">
                            <div class="max-h-32 overflow-y-auto">
                                <ul>
                                    <li class="flex items-center mb-2">
                                        <input type="checkbox" name="descuento[]" value="5" id="descuento_5" class="h-5 w-5 text-blue-600 border-gray-300 rounded mr-2">
                                        <label for="descuento_5" class="text-gray-700">5%</label>
                                    </li>
                                    <li class="flex items-center mb-2">
                                        <input type="checkbox" name="descuento[]" value="10" id="descuento_10" class="h-5 w-5 text-blue-600 border-gray-300 rounded mr-2">
                                        <label for="descuento_10" class="text-gray-700">10%</label>
                                    </li>
                                    <li class="flex items-center mb-2">
                                        <input type="checkbox" name="descuento[]" value="15" id="descuento_15" class="h-5 w-5 text-blue-600 border-gray-300 rounded mr-2">
                                        <label for="descuento_15" class="text-gray-700">15%</label>
                                    </li>
                                    <li class="flex items-center mb-2">
                                        <input type="checkbox" name="descuento[]" value="20" id="descuento_20" class="h-5 w-5 text-blue-600 border-gray-300 rounded mr-2">
                                        <label for="descuento_20" class="text-gray-700">20%</label>
                                    </li>
                                </ul>
                            </div>
                            <button type="submit" class="mt-4 w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-300">Aplicar</button>
                        </div>

                        <!-- Filtro de Precio -->
                        <div class="filtro border border-gray-300 p-4 rounded-lg mb-4">
                            <h3 class="font-semibold mb-2">Precio</h3>
                            <hr class="mb-2">
                            <div class="max-h-32 overflow-y-auto">
                                <label for="precio_min" class="block text-gray-700">Mínimo: <span id="min_value" class="font-semibold">50,000</span></label>
                                <input type="range" id="precio_min" name="precio_min" class="mb-2 w-full" min="50000" max="500000" step="1000" value="50000" oninput="updateMinValue(this.value)">
                                
                                <label for="precio_max" class="block text-gray-700">Máximo: <span id="max_value" class="font-semibold">500,000</span></label>
                                <input type="range" id="precio_max" name="precio_max" class="w-full" min="50000" max="500000" step="1000" value="500000" oninput="updateMaxValue(this.value)">
                            </div>
                            <button type="submit" class="mt-4 w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-300">Aplicar</button>
                        </div>
                    </form> <!-- Cierre del formulario -->
                </div> 
                <div class="productos w-4/5 p-4"> <!-- Sección de productos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php if (!empty($productos)): ?>
                            <?php foreach ($productos as $producto): ?>
                                <div class="producto bg-white rounded-lg p-4 shadow-lg h-auto relative"> <!-- Contenedor del producto -->
                                    <img src="/SneakFlow/public/vistas/img/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="w-full object-cover rounded-md">
                                    
                                    <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                                    <p>
                                        <?php
                                        // Dividir la descripción en palabras
                                        $palabras = explode(' ', htmlspecialchars($producto['descripcion']));
                                        
                                        // Obtener solo las primeras 11 palabras
                                        $primerasPalabras = array_slice($palabras, 0, 11);
                                        
                                        // Unir las palabras en una cadena
                                        $descripcionCorta = implode(' ', $primerasPalabras);
                                        
                                        // Mostrar la descripción corta
                                        echo $descripcionCorta . (count($palabras) > 11 ? '...' : '');
                                        ?>
                                    </p>
                                    <p class="font-bold">$<?php echo htmlspecialchars($producto['precio']); ?></p>
                                    
                                    <!-- Menú desplegable para tallas -->
                                    <div class="detalles mt-4 bg-white shadow-lg rounded-lg p-4 transition-transform duration-300 hover:shadow-xl">
                                        <form class="agregar-carrito" data-producto-id="<?php echo htmlspecialchars($producto['id']); ?>">
                                            <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                                            <select name="talla_id" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                                                <option value="" disabled selected>Selecciona una talla:</option>
                                                <?php if (!empty($producto['tallaproducto'])): ?>
                                                    <?php foreach ($producto['tallaproducto'] as $talla): ?>
                                                        <option value="<?= htmlspecialchars($talla['id']); ?>"><?= htmlspecialchars($talla['talla']); ?></option>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <option value="">No hay tallas disponibles</option>
                                                <?php endif; ?>
                                            </select>
                                            <input type="hidden" name="cantidad" value="1"> <!-- Cantidad fija en 1 -->
                                            <button type="submit" class="w-full bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-300 transform hover:scale-105 mt-3">
                                                Agregar al carrito
                                            </button>
                                            <div class="respuesta" style="display:none;"></div>

                                        </form>                                
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay productos disponibles para esta marca.</p>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.querySelectorAll('.agregar-carrito').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevenir el envío normal del formulario

                    const formData = new FormData(this); // Obtener datos del formulario
                    const productoId = this.getAttribute('data-producto-id'); // Obtener el ID del producto

                    fetch('agregar-al-carrito', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Mostrar el mensaje por unos segundos
                        const respuestaDiv = this.querySelector('.respuesta');
                        if (respuestaDiv) {
                            respuestaDiv.style.display = 'block'; // Mostrar el área de respuesta
                            respuestaDiv.innerHTML = `<div class='p-2 ${data.status === 'success' ? 'bg-green-200 text-green-800 border-green-400' : 'bg-red-200 text-red-800 border-red-400'} rounded'>${data.message}</div>`;
                        }

                        // Mostrar el mensaje por 2 segundos y luego recargar la página
                        setTimeout(() => {
                            if (respuestaDiv) {
                                respuestaDiv.style.display = 'none'; // Ocultar el área de respuesta
                                respuestaDiv.innerHTML = ''; // Limpiar el contenido del mensaje
                            }
                            // Recargar la página para reflejar el nuevo estado del carrito
                            if (data.status === 'success') {
                                window.location.reload(); // Recargar solo si la operación fue exitosa
                            }
                        }, 1500); // 2000 milisegundos = 2 segundos
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const respuestaDiv = this.querySelector('.respuesta');
                        if (respuestaDiv) {
                            respuestaDiv.style.display = 'block'; // Mostrar el área de respuesta
                            respuestaDiv.innerHTML = "<div class='p-2 bg-red-200 text-red-800 border-red-400 rounded'>Error al procesar la solicitud.</div>";
                        }

                        // Ocultar el mensaje de error después de 5 segundos
                        setTimeout(() => {
                            if (respuestaDiv) {
                                respuestaDiv.style.display = 'none'; // Ocultar el área de respuesta
                                respuestaDiv.innerHTML = ''; // Limpiar el contenido del mensaje
                            }
                        }, 1500); // Ocultar después de 5 segundos
                    });
                });
            });


            </script>
    <?php require_once '../public/vistas/footer.php'; ?>
    <script src="/SneakFlow/public/vistas/js/producto_marca.js"></script> <!-- Script de productos marcas -->
