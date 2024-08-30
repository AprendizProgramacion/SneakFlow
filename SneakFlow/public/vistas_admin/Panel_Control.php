<?php
    require_once __DIR__ . '/../../app/seguridad/verificarSesion.php'; // Incluye el archivo de verificación

    verificarSesionAdmin(); // Llama a la función de verificació
    
    // Depura el contenido de la sesión
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';

    // Verifica el rol del usuario
    echo "Rol del usuario: " . $_SESSION['rol'];
?>

<h1>Soy admin</h1>
