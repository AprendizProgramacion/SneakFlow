        <?php include_once __DIR__ . '/../header.php';?>
        <link rel="stylesheet" href="/SneakFlow/public/vistas/css/login.css">
        <!-- LOGIN -->
        <div class="background"></div>
        <div class="container">
            <div class="item">
                <h2 class="logo"><i class='bx bxs-building'></i>SneakFlow</h2>
                <div class="text-item">
                    <h2>¡Bienvenido! <br><span>
                        Estamos encantados de tenerte de nuevo.
                    </span></h2>
                    <p>Gracias a ti, estamos creciendo más allá de nuestras expectativas. 
                        Compartamos el éxito cada día.</p>
                    <div class="social-icon">
                        <a href="#"><i class='bx bxl-facebook'></i></a>
                        <a href="#"><i class='bx bxl-twitter'></i></a>
                        <a href="#"><i class='bx bxl-instagram'></i></a>
                        <a href="#"><i class='bx bxl-tiktok'></i></a>
                    </div>
                </div>
            </div>
            <div class="login-section">
                <div class="form-box login">
                    <form action="login" method="post">
                        <h2>Iniciar Sesión</h2>
                        <div class="input-box">
                            <span class="icon"><i class='bx bxs-user-account'></i></span>
                            <input type="text" id="usuario" name="usuario" required>
                            <label>Usuario</label>
                        </div>
                        <div class="input-box">
                            <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
                            <input type="password" id="contraseña" name="contraseña" required>
                            <label>Contraseña</label>
                        </div>
                        <div class="remember-password">
                            <label for=""><input type="checkbox">Recuerda</label>
                            <a href="recuperar">Olvidaste tu contraseña</a>
                        </div>
                        <button class="btn">Ingresar</button>
                        <div class="create-account">
                            <p>¿Aún no tienes cuenta?<a href="#" class="register-link"> 
                                Registrarse</a></p>
                        </div>
                    </form>
                </div>
                <div class="form-box register">
                    <form action="registrar" method="post">
                        <h2>Ingreso</h2>
                        <div class="input-box">
                            <span class="icon"><i class='bx bxs-user'></i></span>
                            <input type="text" id="username" name="username" required>
                            <label >Usuario</label>
                        </div>
                        <div class="input-box">
                            <span class="icon"><i class='bx bxs-user-account'></i></span>
                            <input type="text" id="email" name="email" required>
                            <label>Correo</label>
                        </div>
                        <div class="input-box">
                            <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
                            <input type="password" id="password" name="password" required>
                            <label>Contraseña</label>
                        </div>
                        <div class="remember-password">
                            <label for=""><input type="checkbox">Estoy de acuerdo con
                                los términos y condiciones</label>
                        </div>
                        <button class="btn">Registrarse</button>
                        <div class="create-account">
                        <p>Tienes una cuenta? <a href="#" class="login-link">Iniciar Sesión</a></p>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="/SneakFlow/public/vistas/js/login.js"></script>

