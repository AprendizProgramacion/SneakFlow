<div id="edit-popup" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl mb-4">Editar Producto</h2>
        <form id="edit-form" method="POST" action="editar-carrito">
            <input type="hidden" id="producto-id" name="producto_id">
            <input type="hidden" id="talla-id" name="talla_id">
            <div class="mb-4">
                <label for="talla" class="block text-sm font-medium text-gray-700">Talla</label>
                <select id="talla" name="talla" class="form-select mt-1 block w-full">
                    <?php if (!empty($tallas)): ?>
                        <?php foreach ($tallas as $talla): ?>
                            <option value="<?php echo htmlspecialchars($talla['id']); ?>">
                                <?php echo htmlspecialchars($talla['talla']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No hay tallas disponibles</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" class="form-input mt-1 block w-full" min="1" required>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeEditModal()" class="bg-gray-600 text-white px-4 py-2 rounded-lg mr-2">Cancelar</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Guardar</button>
            </div>
        </form>
    </div>
</div>