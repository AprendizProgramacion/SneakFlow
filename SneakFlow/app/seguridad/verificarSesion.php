<?php
    function verificarSesionAdmin() {
        // Verifica si la sesión del usuario está iniciada y si el rol es 'administrador'
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            // Redirige a la página de inicio de sesión si no está autenticado o no es administrador
            header("Location: inicio");
            exit(); // Asegura que no se ejecute más código después de la redirección
        }
    }
?>
