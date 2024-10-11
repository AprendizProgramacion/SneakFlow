<?php 
    require_once __DIR__ . '/../../../app/seguridad/verificarSesion.php'; 
    require_once '../public/vistas/header.php'; 

    verificarSesion(); 

    $mostrarPopup = isset($_SESSION['no_registrado']) && $_SESSION['no_registrado'];

    if ($mostrarPopup) {
        unset($_SESSION['no_registrado']);
        include 'alertas/alert.php';
    } else {
        include 'alertas/eliminar.php';
?>
    <!-- Incluir SweetAlert2 desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Incluir Tailwind CSS desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.0/dist/tailwind.min.css" rel="stylesheet">
    <!-- Incluir Bootstrap CSS desde CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="/SneakFlow/public/vistas/css/carrito.css">
    <div class="container mx-auto p-8 bg-gray-900 rounded-lg shadow-2xl mt-16">
        <h2 class="text-4xl font-bold text-center mb-8">Tu Carrito de Compras</h2>
        <p class="text-center text-lg mb-8">Revisa y ajusta tus productos antes de proceder al pago. ¡La compra está a solo un clic de distancia!</p>
        <div class="products-container">
            <?php if (!empty($productos)): ?>
                <div class="products-list grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php foreach ($productos as $producto): ?>
                        <div class="product-card border border-gray-600 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-transform transform hover:scale-105 relative">
                            <!-- Círculo gris sobre la tarjeta -->
                            <div class="circle absolute top-4 right-4 w-10 h-10 border-4 border-gray-500 rounded-full bg-gray-700"></div>

                            <img src="/SneakFlow/public/vistas/img/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                                <p class="mb-1">Cantidad: <?php echo htmlspecialchars($producto['cantidad']); ?></p>
                                <p class="mb-1">Talla: <?php echo htmlspecialchars($producto['talla']); ?></p>
                                <p class="mb-1">Género: <?php echo htmlspecialchars($producto['genero']); ?></p>
                                <p class="text-green-400 font-semibold mb-1">Precio Unitario: $<?php echo htmlspecialchars($producto['precio']); ?></p>
                                <p class="text-green-400 font-semibold mb-4">Subtotal: $<?php echo htmlspecialchars($producto['precio'] * $producto['cantidad']); ?></p>

                                <div class="button-group flex flex-col space-y-2">
                                    <div class="flex space-x-2">
                                        <form method="POST" action="editar-carrito" class="flex-1">
                                            <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['producto_id']); ?>">
                                            <input type="hidden" name="talla_id" value="<?php echo htmlspecialchars($producto['talla_id']); ?>">
                                            <input type="hidden" name="cantidad_original" value="<?php echo htmlspecialchars($producto['cantidad']); ?>">

                                            <button type="button" onclick="openEditModal('<?php echo htmlspecialchars($producto['producto_id']); ?>', '<?php echo htmlspecialchars($producto['cantidad']); ?>')" class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg transition-transform transform hover:scale-105 hover:bg-blue-600">
                                                Editar
                                            </button>
                                        </form>
                                        <form method="POST" action="eliminar-carrito" class="flex-1">
                                            <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['producto_id']); ?>">
                                            <input type="hidden" name="talla_id" value="<?php echo htmlspecialchars($producto['talla_id']); ?>">
                                            <input type="hidden" name="cantidad" value="<?php echo htmlspecialchars($producto['cantidad']); ?>">

                                            <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-transform transform hover:scale-105">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                    <button type="button" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-transform transform hover:scale-105">
                                        Comprar
                                    </button>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="total-container flex justify-between items-center mt-6 p-6 border border-gray-700 rounded-lg shadow-lg bg-gray-800">
                    <div class="text-lg font-bold flex items-center">
                        <span class="text-2xl mr-2">$</span>
                        <span class="text-3xl total-amount"><?php echo number_format(array_sum(array_map(function($producto) {
                            return $producto['precio'] * $producto['cantidad'];
                        }, $productos)), 2); ?></span>
                    </div>
                    <div class="flex space-x-4">
                        <form method="POST" action="eliminar-todo-carrito" class="mr-4">
                            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg shadow-md hover:shadow-lg text-lg font-bold transition-transform transform hover:scale-105">
                                Eliminar Todo
                            </button>
                        </form>
                        <a href="checkout" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:shadow-lg text-lg font-bold transition-transform transform hover:scale-105">Proceder al Pago</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-cart text-center py-16 bg-gray-900 border border-gray-600 rounded-lg shadow-lg">
                    <h3 class="text-3xl font-bold mb-4">Tu Carrito Está Vacío</h3>
                    <p class="text-lg mb-6">No tienes productos en tu carrito. Explora y añade productos para proceder a la compra.</p>
                    <div class="flex justify-center space-x-4">
                        <a href="productos" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-transform">Explorar Productos</a>
                        <a href="inicio" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-transform">Volver a Inicio</a>
                    </div>
                    <div class="mt-8">
                        <img src="/SneakFlow/public/vistas/img/empty-cart-futuristic.png" alt="Carrito vacío" class="mx-auto w-1/2 max-w-xs">
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php }
    require_once 'editar.php'; 
    require_once '../public/vistas/footer.php'; 
?>
<script src="/SneakFlow/public/vistas/js/carrito.js"></script>
