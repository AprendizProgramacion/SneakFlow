<?php 
    include 'alertas/eliminar.php'; // Archivo de alertas.
    require_once '../public/vistas/header.php'; // Header.
?>

<!-- Incluir Tailwind CSS desde CDN para estilos -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.0/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="/SneakFlow/public/vistas/css/favoritos.css">
<link rel="stylesheet" href="/SneakFlow/public/vistas/css/productos.css">

<br><br><br>
<div class="container mx-auto p-6 rounded-lg shadow-2xl backdrop-blur-sm">
    <h1 class="text-center text-white text-4xl font-extrabold tracking-wide mb-8">Tu colección de favoritos</h1>
    
    <div class="grid grid-cols-1 gap-8">
        <?php if (!empty($productosDetalles)): ?>
            <?php foreach (array_chunk($productosDetalles, 3) as $filaProductos): ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($filaProductos as $producto): ?>
                        <div class="card-container bg-black bg-opacity-50 rounded-lg p-4">
                            <div class="card-header">
                                <h5><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                            </div>
                            <img src="/SneakFlow/public/vistas/img/<?php echo htmlspecialchars($producto['imagen']); ?>" class="w-full h-48 object-cover rounded-lg transition-transform duration-300 hover:scale-105" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            <div class="card-content mt-4">
                                <p><?php echo htmlspecialchars($producto['descripcion'] ?? 'Descripción no disponible por el momento.'); ?></p>
                                <p class="price mt-2">Precio: $<?php echo htmlspecialchars($producto['precio']); ?></p>
                                <p class="date">Agregado el: 
                                    <?php 
                                        $fechaAgregado = isset($producto['fecha_agregado']) ? $producto['fecha_agregado'] : null;
                                        if ($fechaAgregado) {
                                            echo htmlspecialchars(date('d/m/Y', strtotime($fechaAgregado)));
                                        } else {
                                            echo 'Fecha no disponible';
                                        }
                                    ?>
                                </p>
                            </div>
                            <div class="card-footer flex justify-center gap-3 mt-4">
                                <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-300" data-id="p-<?php echo htmlspecialchars($producto['id']); ?>" onclick="toggleProductPreview('p-<?php echo htmlspecialchars($producto['id']); ?>')">Ver detalles</button>

                                <form action="eliminar-favorito" method="post" class="inline-block">
                                    <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-500 transition duration-300">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            
            <!-- Botón para eliminar todos los productos de favoritos -->
            <div class="text-center mb-6 mt-4">
                <form action="eliminar-todos-favoritos" method="post" class="inline-block">
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-500 transition duration-300">
                        Eliminar todos los productos
                    </button>
                </form>
            </div>

        <?php else: ?>
            <div class="container mx-auto p-4 empty-cart text-center">
                <img src="/SneakFlow/public/vistas/img/Adidas.jpg" alt="Favoritos vacíos" class="img-fluid mx-auto mb-4" >
                <h1 class="text-white text-2xl font-bold mb-3">Tu lista de favoritos está vacía</h1>
                <p class="text-gray-300 mb-4">Parece que no has agregado ningún producto a tus favoritos. ¡Explora nuestra tienda y encuentra lo que te encanta!</p>
                <a href="/SneakFlow/public/productos" class="btn-glow">Ver productos</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include_once 'ver.php'; ?> <!-- Incluir detalles del producto -->
<script src="/SneakFlow/public/vistas/js/favoritos.js"></script> <!-- Script de favoritos -->
<?php require_once '../public/vistas/footer.php'; ?> <!-- Footer -->
