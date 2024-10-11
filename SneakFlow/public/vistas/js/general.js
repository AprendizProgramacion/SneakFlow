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

function updateCartCount(count) {
    const cartCountElement = document.getElementById('cart-count');
    
    if (count > 0) {
        cartCountElement.textContent = count;
        cartCountElement.classList.add('show'); // Muestra el contador
    } else {
        cartCountElement.textContent = '';
        cartCountElement.classList.remove('show'); // Oculta el contador
    }
}

function toggleMenu() {
    const navbar = document.getElementById('navbar');
    navbar.classList.toggle('hidden');
}

function toggleProfileMenu(event) {
    event.stopPropagation();
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('hidden');
}

document.addEventListener('click', function() {
    const dropdown = document.getElementById('profileDropdown');
    if (!dropdown.classList.contains('hidden')) {
        dropdown.classList.add('hidden');
    }
});

