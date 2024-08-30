<?php 
   if (!isset($_SESSION['usuario'])) {
        header("Location: inicio");
        exit();
    }
?>

<link rel="stylesheet" href="/SneakFlow/public/vistas/css/carrito.css">

<div class="container mx-auto p-6 bg-white rounded-lg shadow-lg mt-16 max-w-4xl">
    <h2 class="text-4xl font-bold text-center mb-8 text-gray-900">Tu Carrito de Compras</h2>
    <p class="text-center text-lg mb-8 text-gray-700">Revisa los productos que has añadido a tu carrito antes de proceder al pago.</p>

    <div class="products-container">
        <?php if (!empty($productos)): ?>
            <div class="products-list flex flex-wrap gap-8">
                <?php foreach ($productos as $producto): ?>
                    <div class="product-card flex border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-transform">
                        <img src="/SneakFlow/public/vistas/img/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="w-1/4 object-cover">
                        <div class="p-4 flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p class="text-gray-600 mb-2">Cantidad: <?php echo htmlspecialchars($producto['cantidad']); ?></p>
                            <p class="text-gray-600 mb-2">Talla: <?php echo htmlspecialchars($producto['talla']); ?></p>
                            <p class="text-gray-600 mb-2">Género: <?php echo htmlspecialchars($producto['genero']); ?></p>
                            <p class="text-green-600 font-bold mb-2">Precio Unitario: $<?php echo htmlspecialchars($producto['precio']); ?></p>
                            <br><br>
                            <p class="text-green-600 font-bold mb-2">PruebaId_producto = <?php echo htmlspecialchars($producto['producto_id']); ?></p>
                            <p class="text-green-600 font-bold mb-2">PruebaID_talla = <?php echo htmlspecialchars($producto['talla_id']); ?></p>
                            <p class="text-green-600 font-bold mb-2">Prueba_cantidad= <?php echo htmlspecialchars($producto['cantidad']); ?></p>

                            <p class="text-green-600 font-bold mb-4">Subtotal: $<?php echo htmlspecialchars($producto['precio'] * $producto['cantidad']); ?></p>
                           
                            <div class="button-group flex flex-col space-y-2">
                                <div class="flex space-x-2">
                                    <form method="POST" action="editar-carrito">
                                        <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['producto_id']); ?>">
                                        <input type="hidden" name="talla_id" value="<?php echo htmlspecialchars($producto['talla_id']); ?>">
                                        <input type="hidden" name="cantidad" value="<?php echo htmlspecialchars($producto['cantidad']); ?>">

                                        <button type="button" onclick="openEditModal(<?php echo htmlspecialchars($producto['producto_id']); ?>, <?php echo htmlspecialchars($producto['talla_id']); ?>, <?php echo htmlspecialchars($producto['cantidad']); ?>)" class="btn-edit bg-gray-600 text-white px-6 py-3 text-lg rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-black flex-1 w-25 flex items-center justify-center">
                                            <i class="bx bx-edit text-xl mr-2"></i> Editar
                                        </button>
                                    </form>
                                    <form method="POST" action="eliminar-carrito">
                                        <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['producto_id']); ?>">
                                        <input type="hidden" name="talla_id" value="<?php echo htmlspecialchars($producto['talla_id']); ?>">
                                        <input type="hidden" name="cantidad" value="<?php echo htmlspecialchars($producto['cantidad']); ?>">

                                        <button type="submit" class="btn-edit bg-gray-600 text-white px-6 py-3 text-lg rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-black flex-1 w-32 flex items-center justify-center">
                                            <i class="bx bx-trash text-xl mr-2"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                                <button type="button" class="btn-buy border-2 border-black text-gray-600 px-6 py-3 text-lg rounded-lg hover:bg-black-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-black w-70 ml-1.0 flex items-center justify-center">
                                    <i class="bx bx-cart text-xl mr-2"></i> Comprar
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="total-container flex justify-between items-center mt-8 p-6 border border-gray-300 rounded-lg shadow-lg bg-white transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <div class="text-lg font-bold text-gray-800 flex items-center">
                    <span class="text-2xl mr-2">$</span>
                    <span class="text-4xl total-amount animate-pulse"><?php echo number_format(array_sum(array_map(function($producto) {
                        return $producto['precio'] * $producto['cantidad'];
                    }, $productos)), 2); ?></span>
                </div>
                <a href="checkout" class="checkout-button bg-blue-600 text-white px-8 py-3 rounded-lg shadow-md hover:shadow-lg transition-transform duration-300 text-xl font-bold transform hover:scale-105">Proceder al Pago</a>
            </div>
        <?php else: ?>
            <div class="empty-cart text-center py-16 bg-gray-100 border border-gray-200 rounded-lg shadow-lg">
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Tu Carrito Está Vacío</h3>
                <p class="text-lg mb-6 text-gray-600">¡Añade productos a tu carrito para verlos aquí!</p>
                <div class="flex justify-center space-x-6">
                    <a href="productos" class="btn btn-explore bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Explorar Productos</a>
                    <a href="inicio" class="btn btn-return bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">Volver a Inicio</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include_once 'editar.php'?>
<script src="/SneakFlow/public/vistas/js/carrito.js"></script>
