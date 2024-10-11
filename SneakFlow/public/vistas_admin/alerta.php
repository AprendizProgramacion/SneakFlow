<?php
// Verifica si se necesita mostrar el popup
$mostrarPopup = isset($_SESSION['necesita_login']) && $_SESSION['necesita_login'];

if ($mostrarPopup) {
    // Limpia la sesión para que no se muestre el popup en la siguiente página
    unset($_SESSION['necesita_login']);
}
?>
<?php if ($mostrarPopup): ?>
    <!-- Popup de acceso restringido -->
    <div id="popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm text-center">
            <div class="flex justify-center mb-4">
                <!-- Icono de advertencia -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.366-.654 1.31-.654 1.676 0l7.5 13.5A1 1 0 0116.5 18H3.5a1 1 0 01-.933-1.401l7.5-13.5zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-2a.75.75 0 01-.75-.75v-3.5a.75.75 0 011.5 0v3.5A.75.75 0 0110 12z" clip-rule="evenodd" />
                </svg>
            </div>
            <p class="text-gray-800 font-semibold">Acceso restringido</p>
            <p class="text-gray-600 mt-2">Debes ser un administrador para acceder a esta página.</p>
            <a href="inicio" class="mt-4 inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a6 6 0 00-4.472 10.161c.329.19.695.278 1.055.278.82 0 1.597-.45 2.042-1.194l.328-.55A2.5 2.5 0 1111.5 10h1.587a5 5 0 11-.152 2H11.5a1.5 1.5 0 110-3h1.268a1 1 0 10-.036-2h-.46l-.3.5c-.309.515-.862.8-1.442.8-.82 0-1.496-.568-1.678-1.375A4 4 0 1110 2zm-.493 13.917a1 1 0 111.414 0 1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                Volver al inicio
            </a>
        </div>
    </div>
<?php endif; ?>
