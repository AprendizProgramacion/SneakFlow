<?php
    require_once '../public/vistas/header.php';
    require_once __DIR__ . '/../../app/seguridad/verificarAdmin.php'; // Incluye la función de verificación
    
    verificarSesionAdmin(); // Llama a la función de verificación

?>

    <?php include 'alerta.php'; // Incluye el archivo de alerta ?>
    <h1>Soy admin</h1>
<?php require_once '../public/vistas/footer.php'; ?>
