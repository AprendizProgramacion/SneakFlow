<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function verificarSesionAdmin() {

    // Verifica si la sesión del usuario está iniciada y si el rol es 'administrador'
    if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
        // Establece una variable de sesión para mostrar el popup
        $_SESSION['necesita_login'] = true;
    } else {
        // Borra el indicador si el usuario está autenticado y es administrador
        unset($_SESSION['necesita_login']);
    }
}
?>  
