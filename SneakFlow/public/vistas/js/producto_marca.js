function updateMinValue(value) {
    document.getElementById('min_value').innerText = formatCurrency(value);
    // Asegúrate de que el valor máximo no sea menor que el mínimo
    const maxInput = document.getElementById('precio_max');
    if (parseInt(value) > parseInt(maxInput.value)) {
        maxInput.value = value;
        updateMaxValue(value);
    }
}

function updateMaxValue(value) {
    document.getElementById('max_value').innerText = formatCurrency(value);
}

function formatCurrency(value) {
    // Formato de número a moneda
    return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
}