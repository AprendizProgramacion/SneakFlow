<?php
    use Libreria\Enrutador;

    require_once '../configuracion/conexionBD.php'; // Asegúrate de que la ruta sea correcta

    // Definir las rutas GET
    Enrutador::get('/', [PaginaControlador::class, 'inicio']); // Ruta para la página de inicio
    Enrutador::get('inicio', [PaginaControlador::class, 'inicio']); // Ruta para acceder a la página de inicio
    Enrutador::get('login', [PaginaControlador::class, 'login']); // Ruta para la página de inicio de sesión
    Enrutador::get('Recuperar_Contrasena', [PaginaControlador::class, 'recuperarContrasena']); // Ruta para la recuperación de contraseña
    Enrutador::get('Nueva_contrasena', [PaginaControlador::class, 'actualizarContraseña']); // Ruta para la actualización de la contraseña
    Enrutador::get('Panel_Control', [PaginaControlador::class, 'admin']); // Ruta para el panel de control del administrador

    // Ruta para la página de productos
    Enrutador::get('productos', [ProductoControlador::class, 'mostrarProductos']); // Ruta para mostrar todos los productos

    // Ruta para mostrar productos de una marca específica
    Enrutador::get('marca', [MarcaControlador::class, 'mostrarProductosPorMarca']); // Ruta para mostrar productos por marca

    // Rutas para el perfil del usuario
    Enrutador::get('perfil', [PerfilControlador::class, 'mostrarPerfil']); // Ruta para mostrar el perfil del usuario
    Enrutador::post('actualizarPerfil', [PerfilControlador::class, 'actualizarPerfil']); // Ruta para actualizar el perfil del usuario

    // Ruta para cerrar sesión
    Enrutador::get('logout', [UsuarioControlador::class, 'logout']); // Ruta para cerrar sesión del usuario

    // Rutas para gestionar usuarios
    Enrutador::post('registrar', [UsuarioControlador::class, 'registrar']); // Ruta para registrar un nuevo usuario
    Enrutador::post('login', [UsuarioControlador::class, 'login']); // Ruta para iniciar sesión
    Enrutador::post('enviar-enlace', [RecuperarControlador::class, 'enviarEnlace']); // Ruta para enviar el enlace de recuperación de contraseña
    Enrutador::post('actualizarContrasena', [RecuperarControlador::class, 'actualizarContrasena']); // Ruta para actualizar la contraseña del usuario

    // Rutas para el carrito de compras
    Enrutador::get('Carrito', [CarritoControlador::class, 'mostrarCarrito']); // Ruta para mostrar el carrito de compras
    Enrutador::post('agregar-al-carrito', [CarritoControlador::class, 'agregarAlCarrito']); // Ruta para agregar un producto al carrito
    Enrutador::post('editar-carrito', [CarritoControlador::class, 'actualizarCarrito']); // Ruta para editar los productos del carrito
    Enrutador::post('actualizar-carrito', [CarritoControlador::class, 'actualizarCarrito']); // Ruta para actualizar el carrito (posiblemente redundante)
    Enrutador::post('eliminar-carrito', [CarritoControlador::class, 'eliminarDelCarrito']); // Ruta para eliminar un producto del carrito
    Enrutador::post('eliminar-todo-carrito', [CarritoControlador::class, 'eliminarTodoCarrito']); // Ruta para vaciar el carrito

    // Rutas para favoritos
    Enrutador::get('Favoritos', [FavoritoControlador::class, 'mostrarFavoritos']); // Ruta para mostrar productos favoritos
    Enrutador::post('agregar-favorito', [FavoritoControlador::class, 'agregarFavorito']); // Ruta para agregar un producto a favoritos
    Enrutador::post('eliminar-favorito', [FavoritoControlador::class, 'eliminarFavorito']); // Ruta para eliminar un producto de favoritos
    Enrutador::post('eliminar-todos-favoritos', [FavoritoControlador::class, 'eliminarTodosFavoritos']); // Ruta para eliminar todos los productos favoritos

    // Rutas para promociones
    Enrutador::get('Promociones', [PaginaControlador::class, 'promociones']); // Ruta para mostrar promociones

    // Rutas de contacto
    Enrutador::get('Contactenos', [ContactoControlador::class, 'contacto']); // Ruta para mostrar la página de contacto
    // Ruta para procesar el envío del formulario de contacto
    Enrutador::post('enviar-contacto', [ContactoControlador::class, 'enviarEmail']); // Ruta para enviar el correo del formulario de contacto

    // Ruta para buscar productos
    Enrutador::get('buscar', [BuscarControlador::class, 'buscarProductos']); // Ruta para la búsqueda
    Enrutador::post('buscar', [BuscarControlador::class, 'buscarProductos']); // Ruta para la búsqueda

?>
