-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-08-2024 a las 18:31:50
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
  `usuario_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`usuario_id`, `producto_id`, `talla_id`, `cantidad`, `estado`) VALUES
(32, 1, 1, 1, 1);

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
-- Estructura de tabla para la tabla `detalles_pedido`
--

CREATE TABLE `detalles_pedido` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
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
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','procesado','enviado','entregado') DEFAULT 'pendiente'
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
  `marca` varchar(255) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descuento` varchar(50) DEFAULT NULL,
  `existencias` int(11) NOT NULL,
  `fecha_agregado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `imagen`, `marca`, `genero`, `color`, `precio`, `descuento`, `existencias`, `fecha_agregado`) VALUES
(1, 'Zapatillas de Running', 'Zapatillas cómodas para correr.', 'Adidas.jpg', 'Nike', 'Hombre', 'Negro', 120000.00, '10', 3, '2024-08-22 22:16:37'),
(2, 'Zapatos de Cuero', 'Zapatos elegantes para ocasiones especiales.', 'Adidas.jpg', 'Fila', 'Mujer', 'Marrón', 70000.00, '5', 4, '2024-08-22 22:16:37'),
(4, 'Zapatos de Adidas', 'safaf', 'Adidas.jpg', 'Adidas', 'Hombre', 'Blanco', 150000.00, '15', 10, '2024-08-22 22:16:37'),
(5, '4wefe', 'ewfwefe', 'Adidas.jpg', 'Fila', 'Unisex', 'Rojo', 60000.00, '20', 2, '2024-08-22 22:16:37');

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
(1, 1, '39', 3, 1),
(2, 2, '41', 4, 1),
(3, 4, '38', 10, 1),
(4, 5, '44', 2, 1);

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
(23, 'Luis', 'Pablo@gmail.com', '', '', '$2y$10$9zNO6wtCZJZf96sfYxtkzuGgEIJldSp.PbQv6pNaWFM7efPs2CSM.', 'usuario', '2024-08-13 10:37:21'),
(24, 'Admin1', 'ad@gmail.com', '', '', '$2y$10$LhSZW3DVHyHiUzMQP.bl0u6jgArUEiwd0Xzn1XJP/TAdrgFyzU2mS', 'administrador', '2024-08-13 10:43:37'),
(25, 'Admin2', '', '', '', '$2y$10$R5iQakAv99xTdPdOT4ACSeSQpwlROsNETxZoHKCHwC1fFBiNj4Rvq', 'administrador', '2024-08-13 10:43:38'),
(26, 'Admin3', 'admin2@email.com', '', '', '$2y$10$3vEfiDlXTPwLjePwdywi4eXmEWnb53KnEQJ5OY.HGh8ypKF3LU0t.', 'administrador', '2024-08-13 10:43:38'),
(28, '1414', 'fwqafcij@gmail.com', '', '', '$2y$10$SSnCxy1VLybbWa.ClpMo0eMeuIAZy2YiFpbr5UdMy6VosPDCrjoLu', 'usuario', '2024-08-13 12:45:59'),
(29, 'andres', 'nico@gmail.com', '', '', '$2y$10$PJ1M9qJc44J7hZW/kI6Pte61c.4kcfQWskUkDKGFmeJNNzoqzhAP2', 'usuario', '2024-08-16 13:37:04'),
(30, 'Andrew', 'morerahernandezhelbertdubler@gmail.com', '', '', '$2y$10$COuO0BopuYersg181ek8qOFSX0yLlzIrZJomF1kylxpd5Ns3PH1ku', 'usuario', '2024-08-17 13:56:16'),
(31, 'Helbert', 'morerahelbert9@gmail.com', '', '', '$2y$10$vkVntc0TCOw1T2i1n5r/Nu3lYjf3C3ySVYc8I.poEq6oOaGOOxKq2', 'usuario', '2024-08-22 12:35:51'),
(32, 'Pablo', 'dmdks@gmail.COM', '', '', '$2y$10$k9ZviWGDO96aFQas15VLYeuD7To/KBxJmVB.7PC/8EcFIQlnH.276', 'usuario', '2024-08-26 12:09:19');

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
  ADD PRIMARY KEY (`usuario_id`,`producto_id`,`talla_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `talla_id` (`talla_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_entrega` (`id_entrega`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

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
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
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
-- AUTO_INCREMENT de la tabla `recuperaciones`
--
ALTER TABLE `recuperaciones`
  MODIFY `recuperar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_3` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `marcar_carritos_inactivos` ON SCHEDULE EVERY 1 DAY STARTS '2024-08-28 08:12:16' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE carrito
    SET estado = 0
    WHERE actualizado_el < NOW() - INTERVAL 48 HOUR AND estado = 1;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
