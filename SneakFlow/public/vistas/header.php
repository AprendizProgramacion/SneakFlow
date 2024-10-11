<?php
    // Inicia la sesión si no ha sido iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Inicia la sesión para acceder a variables de sesión
    }

    // Obtiene la cantidad de productos en el carrito desde la sesión, o 0 si no existe
    $cartCount = isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;

    // Obtiene la cantidad de favoritos desde la sesión, o 0 si no existe
    $favCount = isset($_SESSION['fav_count']) ? $_SESSION['fav_count'] : 0;

    // Requiere el controlador de marcas, ajustando la ruta según la estructura del proyecto
    require_once __DIR__ . '/../../app/controladores/MarcaControlador.php';

    // Crea una instancia del controlador de marcas
    $marcaControlador = new MarcaControlador();

    // Llama al método para mostrar las marcas y almacena el resultado en la variable $marcas
    $marcas = $marcaControlador->mostrarMarcas();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SneakFlow</title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="/SneakFlow/public/vistas/css/general.css">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.2/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="https://unpkg.com/@heroicons/react/outline"></script>
    </head>
    <body>
        <!-- HEADER -->
        <header class="header">
            <nav class="navbar">
                <a href="inicio">Inicio</a>
                <a href="productos">Productos</a>
                <div class="relative">
                    <a href="#" class="text-gray-700 hover:text-indigo-600 transition-colors" onmouseover="showDropdown()" onmouseout="hideDropdown()">Marcas</a>
                    <div id="marcasDropdown" class="absolute left-0 mt-2 w-64 bg-black bg-opacity-70 rounded-md shadow-lg py-2 hidden">
                        <div class="grid grid-cols-5 gap-4 p-4">
                            <?php foreach ($marcas as $mark): ?>
                                <!-- Enlace modificado para utilizar la ruta hacia el controlador MVC -->
                                <a href="marca?id=<?= $mark['id']; ?>" class="block text-center">
                                    <img src="/SneakFlow/public/vistas/img/<?php echo htmlspecialchars($mark['imagen']); ?>" alt="<?= $mark['marca']; ?>" class="w-16 h-16 mx-auto">
                                </a>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>


                <a href="Promociones">Promociones</a>
                <a href="Contactenos">Contáctenos</a>
            </nav>
            <div class="header-icons">
                <!-- Contenedor del ícono de favoritos -->
                <div class="fav-icon-container relative">
                    <a href="Favoritos" class="icon">
                        <i class='bx bxs-heart text-2xl text-white-700 transition duration-300 ease-in-out hover:text-blue-600' id="fav-icon"></i>
                    </a>
                    <?php if (isset($_SESSION['fav_count']) && $_SESSION['fav_count'] > 0): ?>
                        <span id="fav-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
                            <?php echo $_SESSION['fav_count']; ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Contenedor del ícono del carrito -->
                <div class="cart-icon-container relative">
                    <a href="Carrito" class="icon">
                        <i class='bx bxs-cart text-2xl text-gray-700 transition duration-300 ease-in-out hover:text-green-600' id="cart-icon"></i>
                    </a>
                    <?php if (isset($_SESSION['cart_count']) && $_SESSION['cart_count'] > 0): ?>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
                            <?php echo $_SESSION['cart_count']; ?>
                        </span>
                    <?php endif; ?>
                </div>


                <form action="buscar" method="POST" class="search-bar">
                    <input type="text" name="query" placeholder="Buscar...">
                    <button type="submit"><i class='bx bx-search'></i></button>
                </form>


                <div class="profile-menu">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="#" class="icon profile-icon" onclick="toggleMenu(event)"><i class="bx bxs-user"></i></a>
                        <div id="profileDropdown" class="dropdown-content hidden">
                            <a href="perfil">Mi perfil</a>
                            <a href="logout">Cerrar sesión</a>
                        </div>
                    <?php else: ?>
                        <a href="#" class="icon profile-icon" onclick="toggleMenu(event)"><i class="bx bxs-user"></i></a>
                        <div id="profileDropdown" class="dropdown-content hidden">
                            <a href="login">Iniciar sesión</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>
                        
