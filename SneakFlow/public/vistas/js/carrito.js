function openEditModal(productoId) {
    // Selecciona el modal específico por el productoId
    const modal = document.getElementById(`edit-popup-${productoId}`);
    if (modal) {
        modal.classList.remove('hidden'); // Muestra el modal
    } else {
        console.error(`No se encontró el modal con ID: edit-popup-${productoId}`);
    }
}

function closeEditModal() {
    // Lógica para cerrar el modal
    const modal = document.getElementById(`edit-popup-${productoId}`);
    if (modal) {
        modal.classList.add('hidden'); // Muestra el modal
    } else {
        console.error(`No se encontró el modal con ID: edit-popup-${productoId}`);
    }
}
function closeEditModal(productoId) {
    // Lógica para cerrar el modal
    const modal = document.getElementById(`edit-popup-${productoId}`);
    if (modal) {
        modal.classList.add('hidden'); // Oculta el modal
    } else {
        console.error(`No se encontró el modal con ID: edit-popup-${productoId}`);
    }
}