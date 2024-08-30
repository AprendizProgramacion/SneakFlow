function toggleMenu(event) {
    event.preventDefault(); // Evita el comportamiento por defecto del enlace
    const profileMenu = document.querySelector('.profile-menu');
    profileMenu.classList.toggle('active'); // Alterna la clase 'active' en el contenedor del menú

    // Cierra el menú si haces clic fuera de él
    document.addEventListener('click', function(event) {
        if (!profileMenu.contains(event.target)) {
            profileMenu.classList.remove('active');
        }
    });
}
