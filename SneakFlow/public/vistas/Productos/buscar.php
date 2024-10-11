<?php require_once '../public/vistas/header.php'; ?>
<div class="container mx-auto px-4 py-20">
    <?php if (!empty($resultados)): ?>
        <h2 class="text-4xl font-bold text-gray-800 mb-6 text-center">Resultados</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($resultados as $producto): ?>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 ease-in-out w-full max-w-md">
                    <!-- Mostrar la imagen del producto con altura reducida -->
                    <div class="h-48 overflow-hidden">
                        <img src="/SneakFlow/public/vistas/img/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="w-full h-full object-cover">
                    </div>

                    <div class="p-6 flex flex-col justify-between">
                        <h3 class="text-xl font-semibold text-gray-800"><?php echo $producto['nombre']; ?></h3>
                        <p class="mt-2 text-gray-600 text-sm">
                            <?php 
                                // Limitar la descripción a 21 palabras
                                $descripcion = explode(' ', $producto['descripcion']);
                                echo implode(' ', array_slice($descripcion, 0, 21)) . (count($descripcion) > 21 ? '...' : '');
                            ?>
                        </p>
                        <div class="mt-4 text-right">
                            <a href="#" class="text-indigo-500 hover:text-indigo-700 font-bold">Ver más</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <h2 class="text-2xl font-semibold text-red-500 text-center">No hay resultados.</h2>
    <?php endif; ?>
</div>
<?php require_once '../public/vistas/footer.php'; ?>
