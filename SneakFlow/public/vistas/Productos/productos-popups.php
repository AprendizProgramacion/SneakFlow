<script src="https://cdn.tailwindcss.com"></script>
    <style>
        .size-button.selected {
            background-color: #007bff;
            color: white;
        }
    </style>
    <div class="products-preview grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        <?php foreach ($productos as $producto): ?>
            <div class="preview bg-white rounded-lg shadow-lg overflow-hidden relative" data-target="p-<?php echo htmlspecialchars($producto['id']); ?>">
                <i class="fas fa-times absolute top-2 right-2 text-gray-600 cursor-pointer" onclick="closePreview()"></i>
                <div class="preview-image">
                    <img src="/SneakFlow/public/vistas/img/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                </div>
                <div class="info">
                    <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                    <p><?php echo htmlspecialchars($producto['descripcion']); ?>.</p>
                    <div class="features">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2" class="features-title">Características</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Marca</th>
                                    <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                                </tr>
                                <tr>
                                    <th>Género</th>
                                    <td><?php echo htmlspecialchars($producto['genero']); ?></td>
                                </tr>
                                <tr>
                                    <th>Color</th>
                                    <td><?php echo htmlspecialchars($producto['color']); ?></td>
                                </tr>
                                <tr>
                                    <th>Descuento</th>
                                    <td><?php echo htmlspecialchars($producto['descuento']); ?>%</td>
                                </tr>
                                <tr>
                                    <th>Precio</th>
                                    <td>$<?php echo htmlspecialchars($producto['precio'])?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <form action="agregar-al-carrito" method="post">
                        <div class="flex items-center mt-4 space-x-2">
                            <label for="cantidad" class="text-lg font-medium text-gray-700">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" min="1" value="1" class="border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                        </div>

                        <!-- Hidden inputs for product_id and precio -->
                        <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                        <input type="hidden" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>">

                        <?php if (!empty($producto['tallas_assoc'])): ?>
                            <div class="filtro-tallas">
                                <label for="talla_id_<?php echo htmlspecialchars($producto['id']); ?>" class="block text-sm font-medium text-gray-700 mb-2">
                                </label>
                                <select id="talla_id_<?php echo htmlspecialchars($producto['id']); ?>" name="talla_id" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                    <option value="">Seleccione una talla</option>
                                    <?php foreach ($producto['tallas_assoc'] as $id => $talla): ?>
                                        <option value="<?php echo htmlspecialchars($id); ?>">
                                            <?php echo htmlspecialchars($talla); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <p class="text-red-600 font-medium">No hay tallas disponibles para este producto.</p>
                        <?php endif; ?>


                        <div class="buttons mt-4">
                            <a href="#" class="buy">Comprar Ahora</a>
                            <button type="submit" class="cart">Agregar al carrito</button>
                            <a href="#" class="favorite"><i class="fas fa-heart"></i> Añadir a Favoritos</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<script src="/SneakFlow/public/vistas/js/producto.js"> </script>
