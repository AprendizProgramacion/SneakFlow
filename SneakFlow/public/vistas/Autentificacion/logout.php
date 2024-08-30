<?php
    session_unset();
    session_destroy();
    header("Location: login"); // Redirige al login después de cerrar sesión
    exit();
?>
