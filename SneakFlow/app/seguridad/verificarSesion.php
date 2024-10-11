<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function verificarSesion() {

    // Verifica si la sesión del usuario está iniciada y si el rol es 'administrador'
    if (!isset($_SESSION['usuario'])){
        // Establece una variable de sesión para mostrar el popup
        $_SESSION['no_registrado'] = true;
    } else {
        // Borra el indicador si el usuario está autenticado y es administrador
        unset($_SESSION['no_registrado']);
    }
}
?>  
