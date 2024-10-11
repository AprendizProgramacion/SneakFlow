// Función para inicializar los filtros
function initializeFilter() {
    // Selecciona los elementos del botón de filtro, popup de filtro, y los elementos de cierre
    const filterBtn = document.querySelector('.filter-btn');
    const filterPopup = document.querySelector('.filter-popup');
    const closePopup = document.querySelector('.close-popup');


    document.querySelectorAll('.filter-select').forEach(select => {
        select.addEventListener('focus', () => {
            select.classList.add('open');
        });
        
        select.addEventListener('blur', () => {
            select.classList.remove('open');
        });
    });
    
    // Evento para abrir el popup de filtro al hacer clic en el botón
    filterBtn.addEventListener('click', function() {
        toggleFilterPopup(true);
    });

    // Evento para cerrar el popup de filtro al hacer clic en el ícono de cierre
    closePopup.addEventListener('click', function() {
        toggleFilterPopup(false);
    });

    // Evento para cerrar el popup de filtro al hacer clic fuera del popup
    document.addEventListener('click', function(event) {
        if (!filterBtn.contains(event.target) && !filterPopup.contains(event.target)) {
            toggleFilterPopup(false);
        }
    });

    // Añadir eventos a los títulos de los filtros
    document.querySelectorAll('.filter-title').forEach(function(title) {
        title.addEventListener('click', toggleOptions);
    });
}


function updateFilter(name, value) {
    const url = new URL(window.location.href);
    if (value) {
        url.searchParams.set(name, value);
    } else {
        url.searchParams.delete(name);
    }
    window.location.href = url.toString();
}


document.addEventListener('DOMContentLoaded', function () {
    const priceSelect = document.getElementById('precio-select');
    const filterContent = document.getElementById('precio-menu');
    const minPriceInput = document.getElementById('precio-min');
    const maxPriceInput = document.getElementById('precio-max');
    const minLabel = document.getElementById('min-label');
    const maxLabel = document.getElementById('max-label');
    const sliderRange = document.getElementById('slider-range');

    function updateSlider() {
        const minVal = parseFloat(minPriceInput.value);
        const maxVal = parseFloat(maxPriceInput.value);

        minLabel.textContent = minVal.toLocaleString();
        maxLabel.textContent = maxVal.toLocaleString();

        const minPercent = ((minVal - 50000) / (500000 - 50000)) * 100;
        const maxPercent = ((maxVal - 50000) / (500000 - 50000)) * 100;

        sliderRange.style.left = `${minPercent}%`;
        sliderRange.style.width = `${maxPercent - minPercent}%`;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const priceSelect = document.querySelector('#priceSelect'); // Ajusta el selector según el elemento
        const filterContent = document.querySelector('.filter-content'); // Ajusta según tu clase o id
        const minPriceInput = document.querySelector('#minPriceInput'); // Ajusta el selector según el elemento
        const maxPriceInput = document.querySelector('#maxPriceInput'); // Ajusta el selector según el elemento
    
        // Verifica si los elementos existen
        if (priceSelect && filterContent && minPriceInput && maxPriceInput) {
            priceSelect.addEventListener('change', function () {
                if (priceSelect.value === 'custom') {
                    filterContent.style.display = 'block';
                    updateSlider();
                } else {
                    filterContent.style.display = 'none';
                    // Resetear los valores del slider si es necesario
                    minPriceInput.value = 50000;
                    maxPriceInput.value = 500000;
                    updateSlider();
                }
            });
        } else {
            console.error('Uno o más elementos no encontrados. Verifica los selectores y la estructura del DOM.');
        }
    });
    

    minPriceInput.addEventListener('input', updateSlider);
    maxPriceInput.addEventListener('input', updateSlider);

    // Initialize the slider position on page load
    updateSlider();
});


function toggleOptions(menuId) {
    var menu = document.getElementById(menuId);
    var filterTitle = menu.previousElementSibling;

    // Alterna la visibilidad del menú y actualiza el título
    if (menu.style.display === "block") {
        menu.style.display = "none";
        filterTitle.classList.remove("active");
    } else {
        menu.style.display = "block";
        filterTitle.classList.add("active");
    }
}

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


document.querySelectorAll('.size-table-table .selectable').forEach(cell => {
    cell.addEventListener('click', function() {
        document.querySelectorAll('.size-table-table .selectable').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
    });
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
    tallaRows.forEach(row => row.classList.remove('bg-blue-100', 'text-blue-500'));
    element.classList.add('bg-blue-100', 'text-blue-500');
}
   

