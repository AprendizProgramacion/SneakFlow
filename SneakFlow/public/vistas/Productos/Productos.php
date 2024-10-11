<?php require_once '../public/vistas/header.php'; ?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/SneakFlow/public/vistas/css/productos.css">
    <body class="p-8"><br>

    <div class="container">
        <nav class="flex items-center space-x-3 text-sm font-medium text-gray-700 mb-6 bg-white  rounded-lg p-2">
            <a href="/SneakFlow/public/inicio" class="flex items-center text-blue-600 hover:text-blue-800 transition-transform duration-300 transform hover:scale-110 hover:translate-x-1 hover:rotate-3">
                <i class="fas fa-arrow-left mr-2 text-lg transition-transform duration-300 transform hover:translate-x-1 hover:rotate-3"></i> Atrás
            </a>
            <span class="text-gray-400">/</span>
            <a href="/SneakFlow/public/inicio" class="flex items-center text-blue-600 hover:text-blue-800 transition-transform duration-300 transform hover:scale-110 hover:translate-x-1 hover:rotate-3">
                <i class="fas fa-home mr-2 text-lg transition-transform duration-300 transform hover:translate-x-1 hover:rotate-3"></i> Inicio
            </a>
            <span class="text-gray-400">/</span>
            <a href="/SneakFlow/public/productos" class="flex items-center text-blue-600 hover:text-blue-800 transition-transform duration-300 transform hover:scale-110 hover:translate-x-1 hover:rotate-3">
                Productos
            </a>
        </nav>
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight tracking-tight">
            Explora Nuestra Colección Exclusiva
        </h1>
        <p class="text-lg text-gray-600 mb-6 leading-relaxed">
            Descubre la última tendencia en calzado deportivo y casual. Cada par está diseñado para ofrecerte comodidad y estilo únicos en cada paso.
        </p>


        <!-- Incluir filtros -->
        <?php include 'filtros.php'; ?>
        <!-- Filtro adicional -->
    
        <div class="products-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="product bg-white shadow-lg rounded-lg overflow-hidden transform transition-transform duration-300 hover:scale-105 cursor-pointer" data-id="p-<?php echo htmlspecialchars($producto['id']); ?>" onclick="toggleProductPreview('p-<?php echo htmlspecialchars($producto['id']); ?>')">
                        <img src="/SneakFlow/public/vistas/img/<?php echo $producto['imagen']; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="w-full h-48 object-cover">
                        <div class="p-3"> <!-- Reducido el padding aquí -->
                            <h3 class="text-lg font-semibold mb-1"><?php echo htmlspecialchars($producto['nombre']); ?></h3> <!-- Reducido el tamaño del texto y margen -->
                            <p class="text-sm font-medium mb-1"><?php echo htmlspecialchars($producto['genero']); ?></p> <!-- Reducido el tamaño del texto y margen -->
                            <div class="price text-lg font-bold text-green-600">$<?php echo htmlspecialchars($producto['precio']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center col-span-full">No se encontraron productos.</p>
            <?php endif; ?>
        </div>

        <?php include 'productos-popups.php'; ?>

        <!-- Mostrar paginación -->
        <?php if ($totalPaginas > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="flex justify-center space-x-4 mt-8">
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <?php
                        // Construir la URL con los filtros
                        $queryParams = array_merge($filtros, ['pagina' => $i]);
                        $queryString = http_build_query($queryParams);
                        ?>
                        <li>
                            <a class="page-link
                                <?php echo ($i == $paginaActual) ? 'bg-gradient-to-r from-green-600 via-green-700 to-green-800 text-white shadow-xl border-2 border-green-900' : 'bg-gray-800 text-green-300 border border-gray-600 hover:bg-gray-700 hover:text-white shadow-md'; ?>
                                rounded-full px-5 py-3 text-lg font-semibold transition-transform duration-300 transform hover:scale-110" 
                            href="?<?php echo $queryString; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

            
    <script src="/SneakFlow/public/vistas/js/producto.js"></script>
<?php require_once '../public/vistas/footer.php'; ?>
