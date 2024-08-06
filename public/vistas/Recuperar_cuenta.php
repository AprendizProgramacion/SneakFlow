<!DOCTYPE html>
<html>
<head>
    <title>Olvidé mi Contraseña</title>
    <link rel="stylesheet" type="text/css" href="css/recuperar.css">
</head>
<body>
    <div class="background">
        <div class="container">
            <div class="form-box forgot-password">
                <h2>Recuperar Contraseña</h2>
                <p>Introduce tu correo electrónico para recibir un enlace de restablecimiento de contraseña.</p>
                <form action="/forgot-password" method="post">
                    <div class="input-box">
                        <input type="email" id="email" name="email" required>
                        <label for="email">Correo Electrónico</label>
                    </div>
                    <button type="submit" class="btn">Enviar Enlace</button>
                </form>
                <p class="create-account"><a href="login.php">Regresar al Login</a></p>
            </div>
        </div>
    </div>
    <script src=""></script>
</body>
</html>
