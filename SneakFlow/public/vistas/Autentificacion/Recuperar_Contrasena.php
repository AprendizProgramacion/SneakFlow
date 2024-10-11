<?php require_once '../public/vistas/header.php'; ?>
<link rel="stylesheet" href="/SneakFlow/public/vistas/css/recuperar.css">
<div class="background">
    <div class="container">
        <div class="form-box forgot-password">
            <h2>Recuperar Contraseña</h2>
            <p>Introduce tu correo electrónico para recibir un enlace de restablecimiento de contraseña.</p>
            <form action="enviar-enlace" method="post">
                <div class="input-box">
                    <input type="email" id="email" name="email" required>
                    <label for="email">Correo Electrónico</label>
                </div>
                <button type="submit" class="btn">Enviar Enlace</button>
            </form>
            <p class="create-account"><a href="login">Regresar al Login</a></p>
        </div>
    </div>
</div>
<?php require_once '../public/vistas/footer.php'; ?>
