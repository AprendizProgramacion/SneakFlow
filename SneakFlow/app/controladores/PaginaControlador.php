<?php


    class PaginaControlador {

        // Método para mostrar la página de inicio
        public function inicio() {
            include '../public/vistas/inicio.php';
        }

        // Método para mostrar la página de login
        public function login() {
            include '../public/vistas/Autentificacion/login.php';
        }

        // Método para mostrar la página de recuperación de contraseña
        public function recuperarContrasena() {
            include '../public/vistas/autentificacion/Recuperar_Contrasena.php'; // Ruta ajustada
        }

        // Método para mostrar la página para crear nueva contraseña
        public function actualizarContraseña() {
            include '../public/vistas/autentificacion/nueva_contrasena.php'; // Ruta ajustada
        }
        
        public function Carrito() {
            include '../public/vistas/carrito/Carrito.php';
        }

        public function promociones() {
            include '../public/vistas/promo/Promociones.php';

        }


        public function admin() {
            include '../public/vistas_admin/Panel_Control.php';
        }

      

    }
    ?>
