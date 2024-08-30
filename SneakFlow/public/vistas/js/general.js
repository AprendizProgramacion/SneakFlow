document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.profile-icon').forEach(icon => {
        icon.addEventListener('click', function(event) {
            event.preventDefault(); // Evita el comportamiento por defecto del enlace
            const profileDropdown = this.nextElementSibling;
            profileDropdown.classList.toggle('active'); // Alterna la clase 'active' en el menú desplegable
        });
    });

    document.addEventListener('click', function(event) {
        const profileDropdowns = document.querySelectorAll('#profileDropdown');
        profileDropdowns.forEach(profileDropdown => {
            if (!profileDropdown.contains(event.target) && !event.target.closest('.profile-icon')) {
                profileDropdown.classList.remove('active');
            }
        });
    });
});

function showDropdown() {
    document.getElementById('marcasDropdown').classList.remove('hidden');
}

function hideDropdown() {
    document.getElementById('marcasDropdown').classList.add('hidden');
}

const marcasDropdown = document.getElementById('marcasDropdown');
marcasDropdown.addEventListener('mouseover', showDropdown);
marcasDropdown.addEventListener('mouseout', hideDropdown);