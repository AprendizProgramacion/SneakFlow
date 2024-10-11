<style>
  /* Estilo para tallas agotadas */
  .agotada {
    background-color: #1a202c; /* Gris oscuro, cercano al negro */
    color: #fff; /* Texto en blanco para contraste */
    cursor: not-allowed; /* Cursor de no permitido */
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem; /* Bordes redondeados */
  }

  .agotada::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 140%;
    height: 2px;
    background: #e2e8f0; /* Blanco para el tachado */
    transform: rotate(-45deg);
    transform-origin: center;
    z-index: 1;
    animation: strike 1s infinite;
  }

  .agotada::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 140%;
    height: 2px;
    background: #e2e8f0; /* Blanco para el tachado */
    transform: rotate(45deg);
    transform-origin: center;
    z-index: 1;
    animation: strike 1s infinite;
  }

  @keyframes strike {
    0% {
      transform: rotate(-45deg) translateX(-100%);
    }
    50% {
      transform: rotate(-45deg) translateX(0);
    }
    100% {
      transform: rotate(-45deg) translateX(100%);
    }
  }
 
</style>

<div class="products-preview grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
    <?php foreach ($productos as $producto): ?>
        <div class="preview bg-white rounded-lg shadow-lg overflow-hidden relative" data-target="p-<?php echo htmlspecialchars($producto['id']); ?>">
            <i class="fas fa-times absolute top-2 right-2 text-gray-600 cursor-pointer" onclick="closePreview()"></i>
            <div class="preview-image">
                <img src="/SneakFlow/public/vistas/img/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                <?php if (!empty($producto['tallas_assoc'])): ?>
                    <div class="filtro-tallas mt-2">
                        <label class="block text-lg font-semibold text-black mb-3 tracking-wide"></label>
                        <table id="tallas-table-<?php echo htmlspecialchars($producto['id']); ?>" class="w-full border border-gray-200 rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                            <tbody class="divide-y divide-gray-300">
                                <?php
                                $count = 0;
                                $columns = 5; // Número de columnas deseadas
                                foreach ($producto['tallas_assoc'] as $id => $talla): 
                                    $isAgotada = ($talla['cantidad'] <= 0) ? 'agotada' : '';
                                    if ($count % $columns === 0): ?>
                                        <tr>
                                    <?php endif; ?>
                                    <td class="py-1 px-2 text-center <?php echo $isAgotada; ?>">
                                        <div class="talla-row w-full h-full cursor-pointer py-0.5 px-2 bg-white text-black font-medium rounded-md shadow-sm 
                                                    transition-transform duration-300 ease-in-out 
                                                    hover:scale-105 hover:shadow-md hover:text-blue-600
                                                    <?php echo $isAgotada; ?>"
                                            data-talla-id="<?php echo htmlspecialchars($id); ?>" 
                                            data-cantidad="<?php echo htmlspecialchars($talla['cantidad']); ?>"
                                            onclick="<?php echo $isAgotada ? 'return false;' : 'selectTalla(this, \'' . htmlspecialchars($producto['id']) . '\')'; ?>">
                                            <?php echo htmlspecialchars($talla['nombre']); ?>
                                        </div>
                                    </td>
                                    <?php if ($count % $columns === $columns - 1): ?>
                                        </tr>
                                    <?php endif; ?>
                                    <?php $count++; ?>
                                <?php endforeach; ?>
                                <!-- Completa la última fila si es necesario -->
                                <?php if ($count % $columns !== 0): ?>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-red-600 font-medium">No hay tallas disponibles para este producto.</p>
                <?php endif; ?>
            </div>

            <div class="info">
                <h3 class="text-2xl font-bold"><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                <?php
                // Dividir la descripción en palabras
                $descripcionCompleta = htmlspecialchars($producto['descripcion']);
                $palabras = explode(' ', $descripcionCompleta);

                // Obtener solo las primeras 20 palabras
                $primerasPalabras = array_slice($palabras, 0, 23);

                // Unir las palabras en una cadena
                $descripcionCorta = implode(' ', $primerasPalabras);

                // Mostrar la descripción corta
                ?>
                <p class="text-gray-700"><?php echo $descripcionCorta . (count($palabras) > 23 ? '...' : ''); ?></p>

                <!-- Tabla de características del producto -->
                <div class="features overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead class="bg-blue-600">
                            <tr>
                                <th colspan="4" class="features-title text-lg font-semibold text-black p-3 text-left">Características</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-blue-50">
                                <th class="py-2 px-4 text-gray-600">Marca</th>
                                <td class="py-2 px-4 text-center text-gray-800 shadow-md" data-label="Marca"><?php echo htmlspecialchars($producto['marca']); ?></td>
                                <th class="py-2 px-4 text-gray-600">Género</th>
                                <td class="py-2 px-4 text-center text-gray-800 shadow-md" data-label="Género"><?php echo htmlspecialchars($producto['genero']); ?></td>
                            </tr>
                            <tr class="hover:bg-blue-50">
                                <th class="py-2 px-4 text-gray-600">Color</th>
                                <td class="py-2 px-4 text-center text-gray-800 shadow-md" data-label="Color"><?php echo htmlspecialchars($producto['color']); ?></td>
                                <th class="py-2 px-4 text-gray-600">Descuento</th>
                                <td class="py-2 px-4 text-center text-gray-800 shadow-md" data-label="Descuento"><?php echo htmlspecialchars($producto['descuento']); ?>%</td>
                            </tr>
                            <tr class="hover:bg-blue-50">
                                <th class="py-2 px-4 text-gray-600">Precio</th>
                                <td class="py-2 px-4 text-center text-gray-800 shadow-md" data-label="Precio">$<?php echo htmlspecialchars($producto['precio']); ?></td>
                                <th class="py-2 px-4 text-gray-600">Talla Seleccionada</th>
                                <td class="py-2 px-4 text-center text-gray-800 shadow-md" data-label="Talla Seleccionada">
                                    <div id="selected-talla-display-<?php echo htmlspecialchars($producto['id']); ?>" class="py-2 px-4 rounded-lg text-center text-gray-800 shadow-md">Ninguna</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="cantidad-container mt-4">
                    <label for="cantidad-<?php echo htmlspecialchars($producto['id']); ?>" class="text-lg font-semibold text-gray-800 mr-4 flex-shrink-0 transition-all duration-300 hover:translate-x-1 hover:text-blue-500">
                        Cantidad:
                    </label>
                    <input type="number" id="cantidad-<?php echo htmlspecialchars($producto['id']); ?>" min="1" value="1"
                        class="w-16 p-1 text-md text-center border border-gray-300 rounded bg-white text-gray-800 font-medium shadow-inner focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 ease-[cubic-bezier(0.65, 0, 0.35, 1)] hover:scale-105 hover:border-gray-400" max="1"
                        oninput="actualizarCantidad(<?php echo htmlspecialchars($producto['id']); ?>)">
                </div>
                <div class="mt-3">
                    <div class="flex justify-between">
                        <!-- Formulario para agregar al carrito -->
                        <form action="agregar-al-carrito" method="post" id="carrito-form-<?php echo htmlspecialchars($producto['id']); ?>" class="carrito-form flex-1 mr-2">
                            <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                            <input type="hidden" id="cantidad-carrito-<?php echo htmlspecialchars($producto['id']); ?>" name="cantidad" value="1">
                            <input type="hidden" id="talla-<?php echo htmlspecialchars($producto['id']); ?>" name="talla_id" value="">
                            <button type="submit" class="w-full px-3 py-1 bg-gradient-to-r from-green-500 to-green-700 text-white font-medium rounded-md shadow transform transition duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1 flex items-center justify-center">
                                <i class='bx bx-cart text-white mr-1'></i> <!-- Icono de carrito -->
                                Añadir al carrito
                            </button>
                        </form>

                        <!-- Formulario para agregar a favoritos -->
                        <form class="favorito-form flex-1" id="favorito-form-<?php echo $producto['id']; ?>">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                            <button type="submit" class="w-full px-3 py-1 bg-gradient-to-r from-green-500 to-green-700 text-white font-medium rounded-md shadow transform transition duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1 flex items-center justify-center">
                                <i class='bx bx-heart text-white mr-1'></i> <!-- Icono de favoritos -->
                                Añadir a Favoritos
                            </button>
                        </form>
                    </div>

                    <!-- Formulario para comprar ahora -->
                    <form action="comprar-ahora" method="post" id="comprar-form-<?php echo htmlspecialchars($producto['id']); ?>" class="comprar-form mt-3">
                        <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                        <input type="hidden" id="cantidad-comprar-<?php echo htmlspecialchars($producto['id']); ?>" name="cantidad" value="1">
                        <input type="hidden" id="talla-<?php echo htmlspecialchars($producto['id']); ?>" name="talla_id" value="">
                        <button type="submit" class="w-full px-3 py-3 bg-gradient-to-r from-blue-700 to-blue-800 text-white font-medium rounded-md shadow transform transition duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 flex items-center justify-center text-sm active:bg-blue-900">
                            <i class='bx bx-purchase-tag-alt text-white mr-1'></i> <!-- Icono de comprar -->
                            Comprar Ahora
                        </button>
                    </form>
                </div>

                <div id="message-<?php echo htmlspecialchars($producto['id']); ?>" class="mt-3"></div>

            </div>

        </div>
    <?php endforeach; ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
        // Maneja el envío de todos los formularios con la clase 'carrito-form'
        $('.carrito-form').on('submit', function(event) {
            event.preventDefault(); // Evita el envío tradicional del formulario

            var form = $(this);
            var formData = form.serialize(); // Serializa los datos del formulario
            var productId = form.find('input[name="producto_id"]').val(); // Obtén el ID del producto
            var messageDiv = $('#message-' + productId); // Selecciona el contenedor de mensajes específico

            $.ajax({
                url: 'http://localhost/SneakFlow/public/agregar-al-carrito', 
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    var messageHtml = `<div class='p-2 ${data.status === 'success' ? 'bg-green-200 text-green-800 border-green-400' : 'bg-red-200 text-red-800 border-red-400'} rounded'>${data.message}</div>`;
                    messageDiv.html(messageHtml);
                    
                    if (data.status === 'success') {
                        // Actualiza el contador del carrito en el menú
                        $('#cart-count').text(data.cart_count); // Suponiendo que data.cart_count es el nuevo conteo
                        $('#cart-count').toggle(data.cart_count > 0); // Muestra u oculta el contador según el valor
                    }

                    // Configura un temporizador para ocultar el mensaje después de 5 segundos
                    setTimeout(function() {
                        messageDiv.empty(); // Vacía el contenido del contenedor de mensajes
                    }, 2000); // 2000 milisegundos = 5 segundos
                },
                error: function() {
                    var messageHtml = `<div class='p-2 bg-red-200 text-red-800 border-red-400 rounded'>Error al procesar la solicitud.</div>`;
                    messageDiv.html(messageHtml);
                    
                    // Configura un temporizador para ocultar el mensaje después de 5 segundos
                    setTimeout(function() {
                        messageDiv.empty(); // Vacía el contenido del contenedor de mensajes
                    }, 2000); // 2000 milisegundos = 5 segundos
                }
            });
        });

        // Maneja el envío de todos los formularios con la clase 'favorito-form'
        $('.favorito-form').on('submit', function(event) {
            event.preventDefault(); // Evita el envío tradicional del formulario

            var form = $(this);
            var formData = form.serialize(); // Serializa los datos del formulario
            var productId = form.find('input[name="producto_id"]').val(); // Obtén el ID del producto
            var messageDiv = $('#message-' + productId); // Selecciona el contenedor de mensajes específico

            $.ajax({
                url: 'http://localhost/SneakFlow/public/agregar-favorito', // Reemplaza con la ruta correcta
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    var messageHtml = `<div class='p-2 ${data.status === 'success' ? 'bg-green-200 text-green-800 border-green-400' : data.status === 'info' ? 'bg-yellow-200 text-yellow-800 border-yellow-400' : 'bg-red-200 text-red-800 border-red-400'} rounded'>${data.message}</div>`;
                    messageDiv.html(messageHtml);
                    
                    if (data.status === 'success') {
                        // Actualiza el contador de favoritos en el menú
                        $('#fav-count').text(data.fav_count); // Suponiendo que data.fav_count es el nuevo conteo
                        $('#fav-count').toggle(data.fav_count > 0); // Muestra u oculta el contador según el valor
                    }

                    // Configura un temporizador para ocultar el mensaje después de 5 segundos
                    setTimeout(function() {
                        messageDiv.empty(); // Vacía el contenido del contenedor de mensajes
                    }, 2000); // 2000 milisegundos = 5 segundos
                },
                error: function() {
                    var messageHtml = `<div class='p-2 bg-red-200 text-red-800 border-red-400 rounded'>Error al procesar la solicitud.</div>`;
                    messageDiv.html(messageHtml);
                    
                    // Configura un temporizador para ocultar el mensaje después de 5 segundos
                    setTimeout(function() {
                        messageDiv.empty(); // Vacía el contenido del contenedor de mensajes
                    }, 2000); // 2000 milisegundos = 5 segundos
                }
            });
        });
    });

    // Función para actualizar la cantidad permitida en función del stock disponible
    function actualizarCantidad(productId) {
        // Obtener el input de cantidad y el stock máximo disponible
        const cantidadInput = document.getElementById(`cantidad-${productId}`);
        const tallaSeleccionada = document.getElementById(`talla-${productId}`).value;
        const cantidadDisponible = tallaSeleccionada ? parseInt(cantidadInput.getAttribute('max')) : 1;

        // Verificar si la cantidad ingresada es mayor que la disponible
        if (parseInt(cantidadInput.value) > cantidadDisponible) {
            // Ajustar la cantidad al máximo disponible
            cantidadInput.value = cantidadDisponible;
        }
    }

    // Función que se llama al seleccionar una talla para ajustar el max disponible en el input de cantidad
    function selectTalla(element, productId) {
        const tallaId = element.getAttribute('data-talla-id');
        const cantidadDisponible = parseInt(element.getAttribute('data-cantidad'));

        // Actualiza el campo oculto de la talla seleccionada
        document.getElementById(`talla-${productId}`).value = tallaId;

        // Actualiza el valor máximo permitido en el input de cantidad basado en la talla seleccionada
        const cantidadInput = document.getElementById(`cantidad-${productId}`);
        cantidadInput.max = cantidadDisponible;

        // Si la cantidad seleccionada actualmente es mayor que la disponible, ajusta al máximo
        if (parseInt(cantidadInput.value) > cantidadDisponible) {
            cantidadInput.value = cantidadDisponible;
        }

        // Actualiza la visualización de la talla seleccionada
        document.getElementById(`selected-talla-display-${productId}`).innerText = element.innerText;

        // Hacer algo más si es necesario cuando se selecciona una talla
    }

    // Event listeners para ajustar automáticamente la cantidad
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', function() {
            actualizarCantidad(this.id.split('-')[1]); // Obtener el id del producto desde el id del input
        });
    });

    function actualizarCantidad(productoId) {
        const cantidadInput = document.getElementById(`cantidad-${productoId}`);
        const cantidadCarrito = document.getElementById(`cantidad-carrito-${productoId}`);
        const cantidadComprar = document.getElementById(`cantidad-comprar-${productoId}`);

        // Actualizar los campos ocultos con el valor actual del input
        cantidadCarrito.value = cantidadInput.value;
        cantidadComprar.value = cantidadInput.value;
    }
    

</script>
