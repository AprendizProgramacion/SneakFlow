<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    $token = null; // o puedes manejar el error aquí
    echo '<script>
        alert("El enlace de recuperación es inválido o ha expirado.");
        window.location = "recuperar";
    </script>';
    require_once '../public/vistas/header.php'; 

}
?>

<link rel="stylesheet" href="/SneakFlow/public/vistas/css/recuperar.css">
<div class="background">
    <div class="container">
        <div class="form-box forgot-password">
            <h2>Crear Nueva Contraseña</h2>
            <form action="actualizarContrasena" method="post">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="input-box">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Nueva Contraseña</label>
                </div>
                <button type="submit" class="btn">Actualizar Contraseña</button>
            </form>
            <p class="create-account"><a href="login">Regresar al Login</a></p>
        </div>
    </div>
</div>

<?php require_once '../public/vistas/footer.php'; ?>
