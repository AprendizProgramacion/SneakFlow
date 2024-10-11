-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-09-2024 a las 01:00:03
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sneakflow`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `usuario_id`, `producto_id`, `talla_id`, `cantidad`, `fecha_registro`) VALUES
(165, 1, 5, 12, 10, '2024-09-11 22:52:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id` int(11) NOT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id`, `color`) VALUES
(7, 'Amarillo'),
(4, 'Azul'),
(11, 'Beige'),
(1, 'Blanco'),
(14, 'Bordeaux'),
(3, 'Gris'),
(10, 'Marrón'),
(12, 'Morado'),
(8, 'Naranja'),
(2, 'Negro'),
(16, 'Oro'),
(15, 'Plata'),
(5, 'Rojo'),
(9, 'Rosa'),
(13, 'Turquesa'),
(6, 'Verde');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_entrega`
--

CREATE TABLE `detalles_entrega` (
  `id` int(11) NOT NULL,
  `id_entrega` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos`
--

CREATE TABLE `detalles_pedidos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distribuidores`
--

CREATE TABLE `distribuidores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contacto_nombre` varchar(100) DEFAULT NULL,
  `contacto_telefono` varchar(20) DEFAULT NULL,
  `contacto_email` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
  `id` int(11) NOT NULL,
  `id_distribuidor` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

CREATE TABLE `envios` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `nombre_destinatario` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`id`, `usuario_id`, `producto_id`, `estado`, `fecha_creacion`) VALUES
(137, 1, 2, 1, '2024-09-07 18:36:19'),
(138, 1, 1, 1, '2024-09-07 18:39:15'),
(149, 1, 4, 1, '2024-09-07 18:54:52'),
(150, 1, 5, 1, '2024-09-07 18:54:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `marca`, `descripcion`, `imagen`) VALUES
(1, 'Nike', 'Nike es una marca líder en la industria del calzado deportivo, conocida por sus innovaciones tecnológicas como Air Max y Nike Free. Ofrece una amplia gama de zapatillas para todos los deportes y actividades, con un diseño moderno y rendimiento superior.', 'Adidas.jpg'),
(2, 'Adidas', 'Adidas es famosa por su estilo icónico y su tecnología de amortiguación Boost. La marca combina moda y funcionalidad, ofreciendo zapatillas para correr, entrenar y uso diario, destacándose por su durabilidad y comodidad.', 'Adidas.jpg'),
(3, 'Puma', 'Puma se destaca por sus diseños deportivos y colaboraciones con celebridades. Ofrece una mezcla de estilo y rendimiento, con modelos que abarcan desde zapatillas para deportes hasta opciones casuales.', 'Adidas.jpg'),
(4, 'Reebok', 'Reebok es conocida por su amplia gama de zapatillas de entrenamiento y deporte. Con un enfoque en la comodidad y la funcionalidad, Reebok ofrece productos de alta calidad a precios accesibles.', 'Adidas.jpg'),
(5, 'New Balance', 'New Balance se especializa en zapatillas deportivas que ofrecen un excelente soporte y comodidad. Ideal para corredores y caminantes, la marca es reconocida por sus tecnologías de amortiguación y ajuste personalizado.', 'Adidas.jpg'),
(6, 'Asics', 'Asics es una marca de renombre en el ámbito del running, conocida por su tecnología de amortiguación GEL. Ofrece zapatillas diseñadas para mejorar el rendimiento y reducir el impacto en las articulaciones.', 'Adidas.jpg'),
(7, 'Converse', 'Converse es famosa por sus zapatillas Chuck Taylor All Star, un clásico atemporal en el mundo de la moda. Ofrece un estilo casual y versátil que ha perdurado a lo largo de los años.', 'Adidas.jpg'),
(8, 'Saucony', 'Saucony se enfoca en la tecnología de rendimiento para corredores, proporcionando zapatillas que combinan comodidad y soporte. Es conocida por sus modelos altamente recomendados para entrenamiento y carreras.', 'Adidas.jpg'),
(9, 'Under Armour', 'Under Armour es una marca innovadora en el ámbito deportivo, ofreciendo zapatillas con tecnologías avanzadas para mejorar el rendimiento y la comodidad durante el ejercicio.', 'Adidas.jpg'),
(10, 'Vans', 'Vans es icónica por sus zapatillas estilo skater y casual. Con un enfoque en el estilo y la autenticidad, Vans ofrece una amplia variedad de diseños que capturan la esencia del estilo urbano.', 'Adidas.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `direccion_envio` varchar(255) NOT NULL,
  `estado` enum('pendiente','procesando','enviado','entregado','cancelado') DEFAULT 'pendiente',
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `marca_id` int(11) DEFAULT NULL,
  `genero` enum('Hombre','Mujer','Unisex','') DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descuento` varchar(50) DEFAULT NULL,
  `existencias` int(11) NOT NULL,
  `fecha_agregado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `imagen`, `marca_id`, `genero`, `color_id`, `precio`, `descuento`, `existencias`, `fecha_agregado`) VALUES
(1, 'Zapatillas de Running', 'Zapatillas cómodas para correr.', 'Adidas.jpg', 4, 'Hombre', 13, 120000.00, '10', 10, '2024-08-22 22:16:37'),
(2, 'Zapatos de Cuero', 'Zapatos elegantes para ocasiones especiales.', 'Adidas.jpg', 7, 'Mujer', 6, 70000.00, '5', 18, '2024-08-22 22:16:37'),
(4, 'Zapatos de Adidas', 'safaf', 'Adidas.jpg', 1, 'Hombre', 13, 150000.00, '15', 23, '2024-08-22 22:16:37'),
(5, '4wefe', 'ewfwefe', 'Adidas.jpg', 6, 'Unisex', 2, 60000.00, '20', 10, '2024-08-22 22:16:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperaciones`
--

CREATE TABLE `recuperaciones` (
  `recuperar_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `talla` varchar(10) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id`, `producto_id`, `talla`, `cantidad`, `disponible`) VALUES
(7, 1, '40', 10, 1),
(8, 2, '54', 18, 1),
(9, 4, '39', 10, 1),
(10, 4, '44', 13, 1),
(11, 5, '30', 10, 1),
(12, 5, '39', 0, 1);

--
-- Disparadores `tallas`
--
DELIMITER $$
CREATE TRIGGER `actualizar_existencias_actualizacion` AFTER UPDATE ON `tallas` FOR EACH ROW BEGIN
  DECLARE total_existencias INT;

  -- Calcular la suma de todas las tallas disponibles para el producto
  SELECT SUM(disponible) INTO total_existencias
  FROM tallas
  WHERE producto_id = NEW.producto_id;

  -- Actualizar las existencias del producto
  UPDATE productos
  SET existencias = total_existencias
  WHERE id = NEW.producto_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `actualizar_existencias_after_delete` AFTER DELETE ON `tallas` FOR EACH ROW BEGIN
    UPDATE productos
    SET existencias = (
        SELECT SUM(cantidad)
        FROM tallas
        WHERE producto_id = OLD.producto_id AND disponible = 1
    )
    WHERE id = OLD.producto_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `actualizar_existencias_after_insert` AFTER INSERT ON `tallas` FOR EACH ROW BEGIN
    UPDATE productos
    SET existencias = (
        SELECT SUM(cantidad)
        FROM tallas
        WHERE producto_id = NEW.producto_id AND disponible = 1
    )
    WHERE id = NEW.producto_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `actualizar_existencias_after_update` AFTER UPDATE ON `tallas` FOR EACH ROW BEGIN
    IF OLD.cantidad != NEW.cantidad OR OLD.disponible != NEW.disponible THEN
        UPDATE productos
        SET existencias = (
            SELECT SUM(cantidad)
            FROM tallas
            WHERE producto_id = NEW.producto_id AND disponible = 1
        )
        WHERE id = NEW.producto_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `actualizar_existencias_eliminacion` AFTER DELETE ON `tallas` FOR EACH ROW BEGIN
  DECLARE total_existencias INT;

  -- Calcular la suma de todas las tallas disponibles para el producto
  SELECT SUM(disponible) INTO total_existencias
  FROM tallas
  WHERE producto_id = OLD.producto_id;

  -- Actualizar las existencias del producto
  UPDATE productos
  SET existencias = total_existencias
  WHERE id = OLD.producto_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `actualizar_existencias_insercion` AFTER INSERT ON `tallas` FOR EACH ROW BEGIN
  DECLARE total_existencias INT;

  -- Calcular la suma de todas las tallas disponibles para el producto
  SELECT SUM(disponible) INTO total_existencias
  FROM tallas
  WHERE producto_id = NEW.producto_id;

  -- Actualizar las existencias del producto
  UPDATE productos
  SET existencias = total_existencias
  WHERE id = NEW.producto_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('usuario','administrador') DEFAULT 'usuario',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `correo`, `telefono`, `direccion`, `contrasena`, `rol`, `fecha_registro`) VALUES
(1, 'Helbert', 'morerahelbert9@gmail.com', '', '', '$2y$10$M0w8OI4V.0zzDkvsaQ5bRejfwuiyfce6P8R.sf/pr5KXEm8PBHnsC', 'administrador', '2024-09-01 22:07:19'),
(2, 'Brayan', 'admin1@email.com', '', '', '$2y$10$cdiQ71q.iGe2alswra/Xa.eVFdwdavdsgNkPic/gFg5RGijfeui3W', 'administrador', '2024-09-01 22:07:19'),
(3, 'Valdez', 'admin2@email.com', '', '', '$2y$10$QOYDn0GvCA5i3F08Yn595eBGvbZ.3.nAYs5P3cQ/GcWFHawJXzOae', 'administrador', '2024-09-01 22:07:21'),
(8, 'pablo', 'pablo@gmail.com', '', '', '$2y$10$JT9FHin8mG0/HyeDxP0BVuL5tvgFBXvBjdSVR3XuTWklhNC4w9Nbi', 'usuario', '2024-09-09 13:04:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`producto_id`,`talla_id`),
  ADD UNIQUE KEY `unico_carrito` (`usuario_id`,`producto_id`,`talla_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`color`);

--
-- Indices de la tabla `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_entrega` (`id_entrega`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `talla_id` (`talla_id`);

--
-- Indices de la tabla `distribuidores`
--
ALTER TABLE `distribuidores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_distribuidor` (`id_distribuidor`);

--
-- Indices de la tabla `envios`
--
ALTER TABLE `envios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`producto_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`marca`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `fk_producto_marca` (`marca_id`);

--
-- Indices de la tabla `recuperaciones`
--
ALTER TABLE `recuperaciones`
  ADD PRIMARY KEY (`recuperar_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `distribuidores`
--
ALTER TABLE `distribuidores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `envios`
--
ALTER TABLE `envios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  ADD CONSTRAINT `detalles_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalles_pedidos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `detalles_pedidos_ibfk_3` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`id`);

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_marca` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
