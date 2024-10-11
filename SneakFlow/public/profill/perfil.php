<?php require_once '../public/vistas/header.php'; ?>
    <link rel="stylesheet" href="/SneakFlow/public/vistas/css/perfil.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
  
    <div class="container min-vh-100 d-flex justify-content-center align-items-center p-5">
        <?php if (isset($perfil)): ?>
            <div class="profile-container container mx-auto p-8 rounded-lg mt-4 max-w-4xl bg-white">
                <div class="mb-4 text-center">
                    <h1 class="text-4xl font-bold mb-2 text-bordered" style="color: white;">Bienvenido, <?php echo htmlspecialchars($perfil['usuario']); ?></h1>
                    <p class="text-lg text-bordered" style="color: white;">Gestiona tu información personal.</p>
                </div>
                
                <div class="row g-4 position-relative">
                    <!-- Figuras decorativas -->
                    <div class="decorative-shape small"></div>
                    <div class="decorative-shape medium"></div>
                    <div class="decorative-shape large"></div>

                    <!-- Usuario -->
                    <div class="col-md-4">
                        <div class="profile-card p-4 rounded-lg shadow-lg fade-in text-center">
                            <div class="card-header" style="background-color: #343a40;">
                                <h3 class="text-2xl font-semibold text-white mb-2">Usuario</h3>
                                <p class="text-white font-bold mb-3"><?php echo htmlspecialchars($perfil['usuario']); ?></p>
                                <button class="btn btn-edit" onclick="showEditForm('usuario')">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                            </div>
                            <div id="form-usuario" class="edit-form mt-3" style="display:none;">
                                <form action="actualizarPerfil" method="POST">
                                    <div class="mb-3">
                                        <label for="usuario" class="form-label" style="color: white;">Nuevo Usuario:</label>
                                        <input type="text" name="usuario" value="<?php echo htmlspecialchars($perfil['usuario']); ?>" class="form-control input-field" required>
                                    </div>
                                    <button type="submit" class="btn btn-update">
                                        <i class="fas fa-save"></i> Actualizar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Correo -->
                    <div class="col-md-4">
                        <div class="profile-card p-4 rounded-lg shadow-lg fade-in text-center">
                            <div class="card-header" style="background-color: #343a40;">
                                <h3 class="text-2xl font-semibold text-white mb-2">Correo</h3>
                                <p class="text-white font-bold mb-3"><?php echo htmlspecialchars($perfil['correo']); ?></p>
                                <button class="btn btn-edit" onclick="showEditForm('correo')">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                            </div>
                            <div id="form-correo" class="edit-form mt-3">
                                <form action="actualizarPerfil" method="POST">
                                    <div class="mb-3">
                                        <label for="correo" class="form-label" style="color: white;">Nuevo Correo:</label>
                                        <input type="email" name="correo" value="<?php echo htmlspecialchars($perfil['correo']); ?>" class="form-control input-field" required>
                                    </div>
                                    <button type="submit" class="btn btn-update">
                                        <i class="fas fa-save"></i> Actualizar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contraseña -->
                    <div class="col-md-4">
                        <div class="profile-card p-4 rounded-lg shadow-lg fade-in text-center">
                            <div class="card-header" style="background-color: #343a40;">
                                <h3 class="text-2xl font-semibold text-white mb-2">Contraseña</h3>
                                <p class="text-white font-bold mb-3"><?php echo str_repeat('*', 12); ?></p>
                                <button class="btn btn-change" onclick="showEditForm('contrasena')">
                                    <i class="fas fa-lock"></i> Editar
                                </button>
                            </div>
                            <div id="form-contrasena" class="edit-form mt-3">
                                <form action="actualizarPerfil" method="POST">
                                    <div class="mb-3">
                                        <label for="contrasena" class="form-label" style="color: white;">Nueva Contraseña:</label>
                                        <input type="password" name="contrasena" class="form-control input-field" required>
                                    </div>
                                    <button type="submit" class="btn btn-change">
                                        <i class="fas fa-save"></i> Actualizar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            function showEditForm(field) {
                var formElement = document.getElementById('form-' + field);
                var isHidden = formElement.style.display === 'none';
                formElement.style.display = isHidden ? 'block' : 'none';
            }
            </script>
        <?php else: ?>
            <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg max-w-4xl">
                <p class="text-center text-lg text-gray-600">No se encontró información del perfil.</p>
            </div>
        <?php endif; ?>
    </div>
<?php require_once '../public/vistas/footer.php'; ?>
