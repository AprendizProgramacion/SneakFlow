<style>
    #popup {
        display: <?php echo $mostrarPopup ? 'flex' : 'none'; ?>;
        background: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        position: fixed;
        inset: 0;
        align-items: center;
        justify-content: center;
        transition: opacity 0.5s ease-in-out;
    }

    .popup-container {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        max-width: 400px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .popup-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
        position: relative;
        height: 100px; /* Ajusta según sea necesario */
    }

    .popup-icon svg {
        width: 80px;
        height: 80px;
        transition: opacity 0.5s ease-in-out, transform 1s ease-in-out;
    }

    .popup-icon .sneaker-icon {
        opacity: 1;
        color: #007bff; /* Color inicial de la zapatilla */
        position: absolute;
        transform: translate(-50%, -50%);
        transition: transform 2s ease-in-out, color 2s ease-in-out, opacity 2s ease-in-out;
    }

    .popup-icon .warning-icon {
        opacity: 0;
        transform: scale(0.8);
        transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    }

    .move-to-center .sneaker-icon {
        transform: translate(0%, 0%) scale(0.8); /* Mueve al centro */
        color: blue; /* Color final de la zapatilla */
        opacity: 0;
    }

    .show-warning .warning-icon {
        opacity: 1;
        transform: scale(1);
    }

    .popup-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .popup-message {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .popup-button {
        display: inline-flex;
        align-items: center;
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }
</style>

<?php if ($mostrarPopup): ?>
    <!-- Popup de acceso restringido -->
    <div id="popup">
        <div class="popup-container">
            <div class="popup-icon">
                <!-- Contenedor de iconos con animación -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 sneaker-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M4 5a1 1 0 011-1h1.5a1 1 0 011 1v2h5V5a1 1 0 011-1h1.5a1 1 0 011 1v6h1a1 1 0 011 1v1a1 1 0 01-1 1h-1v1a1 1 0 01-1 1H9a1 1 0 01-1-1v-1H7v1a1 1 0 01-1 1H5a1 1 0 01-1-1v-1H3a1 1 0 01-1-1v-1a1 1 0 011-1h1V5zm2 6v3a1 1 0 001 1h6a1 1 0 001-1v-3H6z"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 warning-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.366-.654 1.31-.654 1.676 0l7.5 13.5A1 1 0 0116.5 18H3.5a1 1 0 01-.933-1.401l7.5-13.5zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-2a.75.75 0 01-.75-.75v-3.5a.75.75 0 011.5 0v3.5A.75.75 0 0110 12z" clip-rule="evenodd" />
                </svg>
            </div>
            <p class="popup-title">¡Atención!</p>
            <p class="popup-message">Necesitas una cuenta para acceder al carrito. ¡Regístrate y asegura tus zapatillas favoritas!</p>
            <a href="login" class="popup-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a6 6 0 00-4.472 10.161c.329.19.695.278 1.055.278.82 0 1.597-.45 2.042-1.194l.328-.55A2.5 2.5 0 1111.5 10h1.587a5 5 0 11-.152 2H11.5a1.5 1.5 0 110-3h1.268a1 1 0 10-.036-2h-.46l-.3.5c-.309.515-.862.8-1.442.8-.82 0-1.496-.568-1.678-1.375A4 4 0 1110 2zm-.493 13.917a1 1 0 111.414 0 1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                Iniciar Sesión
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var popupIcon = document.querySelector('.popup-icon');
            if (popupIcon) {
                setTimeout(function() {
                    popupIcon.classList.add('move-to-center');
                    setTimeout(function() {
                        popupIcon.classList.add('show-warning');
                    }, 2000); // Tiempo para que la zapatilla se mueva y desaparezca
                }, 1000); // Tiempo antes de empezar el movimiento
            }
        });
    </script>

<?php endif; ?>
