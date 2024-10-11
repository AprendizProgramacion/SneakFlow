// Función para alternar la previsualización del producto
function toggleProductPreview(productId) {
    let previewContainer = document.querySelector('.products-preview');
    let previewBoxes = previewContainer.querySelectorAll('.preview');

    previewContainer.style.display = 'flex';

    previewBoxes.forEach(preview => {
        let targetId = preview.getAttribute('data-target');
        if (productId === targetId) {
            preview.classList.add('active');
        } else {
            preview.classList.remove('active');
        }
    });
}

// Función para cerrar la previsualización del producto
function closePreview() {
    let previewContainer = document.querySelector('.products-preview');
    let previewBoxes = previewContainer.querySelectorAll('.preview');

    // Oculta la previsualización activa
    previewBoxes.forEach(preview => {
        preview.classList.remove('active');
    });

    // Oculta el contenedor de previsualización
    previewContainer.style.display = 'none';
}

// Asigna la función closePreview al icono de cerrar en cada tarjeta de previsualización
document.querySelectorAll('.preview .fa-times').forEach(closeIcon => {
    closeIcon.addEventListener('click', closePreview);
});



function selectTalla(element, productoId) {
    var tallaId = element.getAttribute('data-talla-id');
    var cantidad = element.getAttribute('data-cantidad');
    var displayElement = document.getElementById('selected-talla-display-' + productoId);
    var tallaInput = document.getElementById('talla-' + productoId);
    var cantidadInput = document.getElementById('cantidad-' + productoId);

    // Actualiza el display y el input con el ID de la talla seleccionada
    displayElement.textContent = element.textContent; // Mostrar solo el nombre de la talla
    tallaInput.value = tallaId;
    cantidadInput.setAttribute('max', cantidad); // Establece el valor máximo

    //  Marca la talla seleccionada como activa
    var tallaRows = document.querySelectorAll('[data-target="p-' + productoId + '"] .talla-row');
    tallaRows.forEach(row => row.classList.remove('bg-blue-900', 'text-blue-500'));
    element.classList.add('bg-blue-100', 'text-blue-500');
}
   

