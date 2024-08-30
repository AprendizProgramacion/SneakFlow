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

document.addEventListener('DOMContentLoaded', function() {
    var selected = document.querySelector('.select-selected');
    var items = document.querySelector('.select-items');
    
    selected.addEventListener('click', function() {
        items.classList.toggle('select-hide');
    });
    
    items.addEventListener('click', function(e) {
        var value = e.target.getAttribute('data-value');
        selected.textContent = e.target.textContent;
        items.classList.add('select-hide');
        
        // Actualiza la URL con el filtro seleccionado
        updateFilter('color', value);
    });
    
    document.addEventListener('click', function(e) {
        if (!e.target.matches('.select-selected')) {
            items.classList.add('select-hide');
        }
    });
});

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

    priceSelect.addEventListener('change', function () {
        if (priceSelect.value === 'custom') {
            filterContent.style.display = 'block';
            updateSlider();
        } else {
            filterContent.style.display = 'none';
            // Reset the slider values if needed
            minPriceInput.value = 50000;
            maxPriceInput.value = 500000;
            updateSlider();
        }
    });

    minPriceInput.addEventListener('input', updateSlider);
    maxPriceInput.addEventListener('input', updateSlider);

    // Close the filter content if user clicks outside
    document.addEventListener('click', function (event) {
        if (!filterContent.contains(event.target) && event.target !== priceSelect) {
            filterContent.style.display = 'none';
        }
    });

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

