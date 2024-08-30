<?php  session_start();?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SneakFlow</title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="/SneakFlow/public/vistas/css/general.css">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.2/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/SneakFlow/public/vistas/css/productos.css">

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
                        <div class="grid grid-cols-2 gap-4 p-4">
                            <a href="#" class="block text-center">
                                <img src="/SneakFlow/public/img/nike.png" alt="Nike" class="w-16 h-16 mx-auto">
                            </a>
                            <a href="#" class="block text-center">
                                <img src="/SneakFlow/public/img/adidas.png" alt="Adidas" class="w-16 h-16 mx-auto">
                            </a>
                            <a href="#" class="block text-center">
                                <img src="/SneakFlow/public/img/puma.png" alt="Puma" class="w-16 h-16 mx-auto">
                            </a>
                            <a href="#" class="block text-center">
                                <img src="/SneakFlow/public/img/reebok.png" alt="Reebok" class="w-16 h-16 mx-auto">
                            </a>
                        </div>
                    </div>
                </div>
                <a href="#">Promociones</a>
                <a href="#">Contáctenos</a>
            </nav>
            <div class="header-icons">
                <a href="#" class="icon"><i class='bx bxs-heart'></i></a>
                <a href="Carrito" class="icon"><i class='bx bxs-cart'></i></a>
                <form action="" class="search-bar">
                    <input type="text" placeholder="Buscar...">
                    <button><i class='bx bx-search'></i></button>
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
           <script src="/SneakFlow/public/vistas/js/general.js"></script>
        </header>
      