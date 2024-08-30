<?php
require_once __DIR__ . '/../../app/controladores/PerfilControlador.php';

$perfilControlador = new PerfilControlador();
$perfilControlador->mostrarPerfil();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="/SneakFlow/public/vistas/css/perfil.css">
</head>
<body>
    <?php if (isset($perfil)): ?>
        <div class="card-container">
            <!-- <h1><?php echo htmlspecialchars($perfil['id'])?></h1> -->
            <div class="card">
                <div class="card-header">
                    <h1>Bienvenido <?php echo htmlspecialchars($perfil['usuario']); ?></h1>
                </div>
                <div class="card-body">
                    <p class="message">Gestiona tu información, la privacidad y la seguridad para mejorar tu experiencia en SneakFlow. Los cambios realizados se verán reflejados en tu perfil.</p>
                    
                    <div class="profile-cards">
                        <div class="profile-card">
                            <img src="../vistas/img/desi" alt="Imagen de Perfil" class="profile-image">
                            <h3>Usuario</h3>
                            <p class="description">Tu nombre de usuario en SneakFlow.</p>
                            <p class="data" id="usuario-data"><?php echo htmlspecialchars($perfil['usuario']); ?></p>
                            <button class="edit-button" onclick="showEditForm('usuario')">Editar</button>
                            <div id="form-usuario" class="edit-form" style="display: none;">
                                <form action="actualizarPerfil" method="POST">
                                    <div class="form-group">
                                        <label for="usuario">Usuario:</label>
                                        <input type="text" name="usuario" value="<?php echo htmlspecialchars($perfil['usuario']); ?>" required>
                                        <button type="submit">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="profile-card">
                            <img src="path/to/email-image.jpg" alt="Imagen de Correo" class="profile-image">
                            <h3>Correo</h3>
                            <p class="description">Tu dirección de correo electrónico.</p>
                            <p class="data" id="correo-data"><?php echo htmlspecialchars($perfil['correo']); ?></p>
                            <button class="edit-button" onclick="showEditForm('correo')">Editar</button>
                            <div id="form-correo" class="edit-form" style="display: none;">
                                <form action="actualizarPerfil" method="POST">
                                    <div class="form-group">
                                        <label for="correo">Correo:</label>
                                        <input type="email" name="correo" value="<?php echo htmlspecialchars($perfil['correo']); ?>" required>
                                        <button type="submit">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="profile-card">
                            <img src="path/to/password-image.jpg" alt="Imagen de Contraseña" class="profile-image">
                            <h3>Contraseña</h3>
                            <p class="description">Tu contraseña actual.</p>
                            <p class="data" id="contrasena-data"><?php echo str_repeat('*', 12); ?></p>
                            <button class="edit-button" onclick="showEditForm('contrasena')">Editar</button>
                            <div id="form-contrasena" class="edit-form" style="display: none;">
                                <form action="actualizarPerfil" method="POST">
                                    <div class="form-group">
                                        <label for="contrasena">Nueva Contraseña:</label>
                                        <input type="password" name="contrasena" required>
                                        <button type="submit">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function showEditForm(field) {
            var dataElement = document.getElementById(field + '-data');
            var formElement = document.getElementById('form-' + field);
            if (formElement.style.display === 'none') {
                formElement.style.display = 'block';
                dataElement.style.display = 'none';
            } else {
                formElement.style.display = 'none';
                dataElement.style.display = 'block';
            }
        }
        </script>
    <?php else: ?>
        <p>No se encontró información del perfil.</p>
    <?php endif; ?>
</body>
</html>
