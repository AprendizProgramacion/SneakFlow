<?php foreach ($productos as $producto): ?>

<div id="edit-popup-<?php echo htmlspecialchars($producto['producto_id']); ?>" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-70">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full sm:w-1/2 lg:w-1/3">
        <h2 class="text-2xl mb-6 font-bold text-gray-900 border-b border-gray-300 pb-2">Editar Producto</h2>
        <form id="edit-form" method="POST" action="actualizar-carrito">
            <input type="hidden" id="producto-id" name="producto_id" value="<?php echo htmlspecialchars($producto['producto_id'] ?? ''); ?>">
            <input type="hidden" id="talla-id" name="talla_id" value="<?php echo htmlspecialchars($producto['talla_id'] ?? ''); ?>">
            <input type="hidden" name="cantidad_original" value="<?php echo htmlspecialchars($producto['cantidad'] ?? ''); ?>">

          <!-- Selector de tallas -->
            <div class="mb-6">
                <label for="talla_id" class="block text-base font-medium text-black">Talla</label>
                <select name="talla_id" id="talla_id" class="form-select mt-1 block w-full text-gray-900 border-gray-300 rounded-lg shadow-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-base p-2">
                    <?php foreach ($producto['tallas'] as $talla): ?>
                        <option value="<?php echo htmlspecialchars($talla['id'] ?? ''); ?>" <?php echo $talla['id'] == $producto['talla_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($talla['talla'] ?? ''); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>



            <!-- Campo para la nueva cantidad -->
            <div class="mb-6">
                <label for="cantidad-<?php echo htmlspecialchars($producto['producto_id']); ?>" class="text-lg font-semibold text-gray-800 mr-4 flex-shrink-0 transition-all duration-300 hover:translate-x-1 hover:text-blue-500">
                    Cantidad:
                </label>
                
                <?php 
                    // Inicializar cantidad máxima
                    $cantidad_max = 1; // Valor por defecto

                    // Buscar la talla seleccionada y su cantidad disponible
                    foreach ($producto['tallas'] as $talla) {
                        if ($talla['id'] == $producto['talla_id']) {
                            // Verifica si la clave 'cantidad_disponible' está definida
                            $cantidad_max = isset($talla['cantidad']) ? $talla['cantidad'] : 1;
                            break;
                        }
                    }
                ?>

                <input type="number" id="cantidad-<?php echo htmlspecialchars($producto['producto_id']); ?>" 
                       name="cantidad" 
                       min="1" 
                       max="<?php echo htmlspecialchars($cantidad_max); ?>" 
                       value="<?php echo htmlspecialchars($producto['cantidad'] ?? '1'); ?>" 
                       class="w-16 p-1 text-md text-center border border-gray-300 rounded bg-white text-gray-800 font-medium shadow-inner focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 ease-[cubic-bezier(0.65, 0, 0.35, 1)] hover:scale-105 hover:border-gray-400" 
                       required>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end space-x-4">
                <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-black focus:ring-opacity-50 transition">Guardar</button>
                <button type="button" onclick="closeEditModal(<?php echo htmlspecialchars($producto['producto_id'] ?? ''); ?>)" class="bg-gray-800 text-white px-6 py-3 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50 transition">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>
