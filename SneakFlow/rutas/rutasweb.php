<?php

    use Libreria\Enrutador;

    // Incluir archivos necesarios
    require_once '../configuracion/conexionBD.php'; // Asegúrate de que la ruta sea correcta

    // Definir las rutas GET
    Enrutador::get('/', [PaginaControlador::class, 'inicio']);
    Enrutador::get('inicio', [PaginaControlador::class, 'inicio']);
    Enrutador::get('login', [PaginaControlador::class, 'login']);
    Enrutador::get('Recuperar_Contraseña', [PaginaControlador::class, 'recuperarContrasena']);
    Enrutador::get('Nueva_contrasena', [PaginaControlador::class, 'actualizarContraseña']);
    Enrutador::get('Panel_Control', [PaginaControlador::class, 'admin']);
    // Ruta para la página de productos
    Enrutador::get('productos', [ProductoControlador::class, 'mostrarProductos']);

    // Rutas para el perfil
    Enrutador::get('perfil', [PerfilControlador::class, 'mostrarPerfil']);
    Enrutador::post('actualizarPerfil', [PerfilControlador::class, 'actualizarPerfil']);
    // Ruta para cerrar sesión
    Enrutador::get('logout', [UsuarioControlador::class, 'logout']);

    Enrutador::post('registrar', [UsuarioControlador::class, 'registrar']);
    Enrutador::post('login', [UsuarioControlador::class, 'login']);
    Enrutador::post('enviar-enlace', [RecuperarControlador::class, 'enviarEnlace']);
    Enrutador::post('actualizarContrasena', [RecuperarControlador::class, 'actualizarContrasena']);

    Enrutador::get('Carrito', [CarritoControlador::class, 'mostrarCarrito']);
    Enrutador::post('agregar-al-carrito', [CarritoControlador::class, 'agregarAlCarrito']);
    Enrutador::post('editar-carrito', [CarritoControlador::class, 'editarCarrito']);
    Enrutador::post('actualizar-carrito', [CarritoControlador::class, 'actualizarCarrito']);
    Enrutador::post('eliminar-carrito', [CarritoControlador::class, 'eliminarDelCarrito']);

?>
