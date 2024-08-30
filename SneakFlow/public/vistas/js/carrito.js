function openEditModal(productId, tallaId, cantidad) {
    // Mostrar el popup
    document.getElementById('edit-popup').classList.remove('hidden');

    // Rellenar el formulario con los datos del producto
    document.getElementById('producto-id').value = productId;
    document.getElementById('talla-id').value = tallaId;
    document.getElementById('cantidad').value = cantidad;

    // Obtener y mostrar las tallas en el select
    fetch('obtener-tallas?producto_id=' + productId)
        .then(response => response.json())
        .then(tallas => {
            const tallaSelect = document.getElementById('talla');
            tallaSelect.innerHTML = '';
            tallaSelect.innerHTML = '<option value="">Seleccione una talla</option>';
            tallas.forEach(talla => {
                const option = document.createElement('option');
                option.value = talla.id;
                option.textContent = talla.talla;
                tallaSelect.appendChild(option);
            });
        });
}

function closeEditModal() {
    document.getElementById('edit-popup').classList.add('hidden');
}
