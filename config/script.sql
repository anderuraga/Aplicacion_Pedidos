-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-05-2025 a las 08:21:50
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
-- Base de datos: `elorrieta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas_gastos`
--

CREATE TABLE `areas_gastos` (
  `id` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `areas_gastos`
--

INSERT INTO `areas_gastos` (`id`, `id_departamento`, `nombre`) VALUES
(1, 2, 'Gastos Generales'),
(4, 3, 'Materiales de fabricación'),
(5, 2, 'Elorrieta Prueba 23'),
(7, 4, 'test 2 22'),
(8, 5, 'Prueba nueva'),
(9, 4, 'Super prueba'),
(10, 3, 'Segunda area gasto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre`) VALUES
(12, 'Bombillas led'),
(1, 'Borrado2r'),
(2, 'Conserjería'),
(9, 'cuarta prueba'),
(5, 'Electricidad'),
(3, 'Fabricación Mecánica'),
(11, 'Materiales de fabricación'),
(6, 'Nuevo departamento'),
(4, 'Química'),
(10, 'quinta prueba'),
(7, 'segunda prueba'),
(8, 'Tercera prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `nombre`) VALUES
(1, 'Borrador'),
(2, 'Enviado Secretaría'),
(3, 'Enviado Proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `identificador` varchar(20) NOT NULL,
  `pedido` varchar(20) NOT NULL,
  `fecha` date NOT NULL,
  `vencimiento` date NOT NULL,
  `documento` varchar(45) NOT NULL,
  `documento_firmado` varchar(45) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencias`
--

CREATE TABLE `incidencias` (
  `id` int(11) NOT NULL,
  `id_pedido` varchar(20) NOT NULL,
  `fecha` date NOT NULL,
  `descipcion` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id`, `nombre`) VALUES
(1, 'Bombillas led'),
(2, 'Teclados Logitech');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `id_item`, `fecha`, `descripcion`, `cantidad`) VALUES
(1, 2, '2025-05-04 12:00:00', 'Entrada teclados', 6),
(2, 2, '2025-05-05 12:00:00', 'Entregados 2 teclados en la clase 101', -2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `referencia` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_subconcepto` int(11) NOT NULL,
  `id_area_gasto` int(11) NOT NULL,
  `id_proveedor` varchar(9) NOT NULL,
  `fecha_creada` datetime NOT NULL,
  `fecha_enviada` datetime DEFAULT NULL,
  `descripcion` mediumtext NOT NULL,
  `importe` float NOT NULL,
  `id_factura` varchar(20) NOT NULL,
  `anio_contable` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_estados`
--

CREATE TABLE `pedidos_estados` (
  `id` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `fecha` varchar(45) NOT NULL,
  `comentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id` int(11) NOT NULL,
  `identificador` varchar(20) NOT NULL,
  `id_pedido` varchar(20) NOT NULL,
  `documento` varchar(45) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `cif` varchar(9) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `cod_postal` varchar(10) NOT NULL,
  `poblacion` varchar(45) NOT NULL,
  `provincia` varchar(45) NOT NULL,
  `pais` varchar(45) NOT NULL,
  `telefono` varchar(17) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `factura_e` tinyint(4) NOT NULL,
  `cuanta_bancaria` varchar(35) NOT NULL,
  `contacto` varchar(45) NOT NULL,
  `id_servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `cif`, `nombre`, `direccion`, `cod_postal`, `poblacion`, `provincia`, `pais`, `telefono`, `correo`, `factura_e`, `cuanta_bancaria`, `contacto`, `id_servicio`) VALUES
(1, 'P8536976G', 'Javier SL', 'Calle 122', '48901', 'Barakaldo', 'Bizkaia', 'España', '681260860', 'javier@sl.com', 0, '123456789123456789', 'Artetxe', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subconceptos`
--

CREATE TABLE `subconceptos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `tipo` enum('Fungible','Inventariable') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `subconceptos`
--

INSERT INTO `subconceptos` (`id`, `nombre`, `tipo`) VALUES
(1, 'Subconcepto 1', 'Inventariable'),
(2, 'Subconcepto 2', 'Fungible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_servicio`
--

CREATE TABLE `tipos_servicio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tipos_servicio`
--

INSERT INTO `tipos_servicio` (`id`, `nombre`) VALUES
(1, 'Materiales de fabricación'),
(2, 'Equipos Informáticos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `id` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `cantidad` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `transacciones`
--

INSERT INTO `transacciones` (`id`, `id_area`, `fecha`, `descripcion`, `cantidad`) VALUES
(1, 4, '2025-04-01 12:00:00', 'Ingreso para área materiales', 10001.5),
(2, 1, '2025-04-02 14:00:00', 'Ingreso para gastos generales', 9000.02),
(3, 5, '2025-04-02 12:00:00', 'Nuevo ingreos', 10000),
(4, 4, '2025-04-29 12:00:00', 'Nuevo ingreos prueba', 599.99),
(5, 1, '2025-04-29 11:00:00', 'Otra prueba', 200.5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT 0,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `nombre`, `correo`, `contrasena`, `id_departamento`, `baja`) VALUES
(1, 1, 'Javier Gómez', 'javier.gomez@emaginarte.com', '$2y$10$2iDisbSnjUv3qWM4fb0v9OC1zCXt6wmdyLp0NKjsjLILSspxPUkzO', 2, NULL),
(3, 0, 'Prueba', 'prueba@prueba.com', '$2y$10$VS.RgJapSeXoUgUBdpXUlOgJjrQAP4NLDqXzOCQzHIXdMebOculV6', 10, NULL),
(4, 0, 'Imanol', 'imanol@prueba.com', '$2y$10$EVV1fM.tCFIIJHLbrhblvejZhTsiCEfqmGj.0mDHH2Nb8bxCIwqdW', 4, NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_resumen_areas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_resumen_areas` (
`id_area` int(11)
,`nombre_area` varchar(255)
,`id_departamento` int(11)
,`nombre_departamento` varchar(255)
,`ingresos` double
,`gastos` double
,`total` double
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_resumen_movimientos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_resumen_movimientos` (
`id` int(11)
,`nombre` varchar(45)
,`cantidad` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_resumen_areas`
--
DROP TABLE IF EXISTS `vista_resumen_areas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_resumen_areas`  AS SELECT `ag`.`id` AS `id_area`, `ag`.`nombre` AS `nombre_area`, `ag`.`id_departamento` AS `id_departamento`, `d`.`nombre` AS `nombre_departamento`, sum(case when `t`.`cantidad` > 0 then `t`.`cantidad` else 0 end) AS `ingresos`, sum(case when `t`.`cantidad` < 0 then abs(`t`.`cantidad`) else 0 end) AS `gastos`, ifnull(sum(`t`.`cantidad`),0) AS `total` FROM ((`areas_gastos` `ag` left join `departamentos` `d` on(`ag`.`id_departamento` = `d`.`id`)) left join `transacciones` `t` on(`ag`.`id` = `t`.`id_area`)) GROUP BY `ag`.`id`, `ag`.`nombre`, `ag`.`id_departamento`, `d`.`nombre` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_resumen_movimientos`
--
DROP TABLE IF EXISTS `vista_resumen_movimientos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_resumen_movimientos`  AS SELECT `m`.`id` AS `id`, `m`.`nombre` AS `nombre`, ifnull(sum(`mv`.`cantidad`),0) AS `cantidad` FROM (`materiales` `m` left join `movimientos` `mv` on(`m`.`id` = `mv`.`id_item`)) WHERE 1 GROUP BY `m`.`id` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas_gastos`
--
ALTER TABLE `areas_gastos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `areagasto_departamento_idx` (`id_departamento`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `identificador_UNIQUE` (`identificador`);

--
-- Indices de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `incidencia_pedido_idx` (`id_pedido`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `movimientos_material_idx` (`id_item`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referencia_UNIQUE` (`referencia`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `pedido_usuario_idx` (`id_usuario`),
  ADD KEY `pedido_departamento_idx` (`id_departamento`),
  ADD KEY `pedido_subconcepto_idx` (`id_subconcepto`),
  ADD KEY `pedido_areagasto_idx` (`id_area_gasto`),
  ADD KEY `pedido_proveedor_idx` (`id_proveedor`),
  ADD KEY `fk_Pedidos_Factura1_idx` (`id_factura`);

--
-- Indices de la tabla `pedidos_estados`
--
ALTER TABLE `pedidos_estados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `pe_estado_idx` (`id_estado`),
  ADD KEY `pe_pedido_idx` (`id_pedido`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificador_UNIQUE` (`identificador`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `presupuesto_pedido_idx` (`id_pedido`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `cif_UNIQUE` (`cif`),
  ADD KEY `proveedor_servicio_idx` (`id_servicio`);

--
-- Indices de la tabla `subconceptos`
--
ALTER TABLE `subconceptos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indices de la tabla `tipos_servicio`
--
ALTER TABLE `tipos_servicio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `transaccion_area_idx` (`id_area`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `usuario_departamento_idx` (`id_departamento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas_gastos`
--
ALTER TABLE `areas_gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos_estados`
--
ALTER TABLE `pedidos_estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `subconceptos`
--
ALTER TABLE `subconceptos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipos_servicio`
--
ALTER TABLE `tipos_servicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `areas_gastos`
--
ALTER TABLE `areas_gastos`
  ADD CONSTRAINT `areagasto_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id`);

--
-- Filtros para la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD CONSTRAINT `incidencia_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`referencia`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_material` FOREIGN KEY (`id_item`) REFERENCES `materiales` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedido_areagasto` FOREIGN KEY (`id_area_gasto`) REFERENCES `areas_gastos` (`id`),
  ADD CONSTRAINT `pedido_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id`),
  ADD CONSTRAINT `pedido_factura` FOREIGN KEY (`id_factura`) REFERENCES `facturas` (`identificador`),
  ADD CONSTRAINT `pedido_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`cif`),
  ADD CONSTRAINT `pedido_subconcepto` FOREIGN KEY (`id_subconcepto`) REFERENCES `subconceptos` (`id`),
  ADD CONSTRAINT `pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `pedidos_estados`
--
ALTER TABLE `pedidos_estados`
  ADD CONSTRAINT `pe_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`),
  ADD CONSTRAINT `pe_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuesto_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`referencia`);

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedor_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `tipos_servicio` (`id`);

--
-- Filtros para la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transaccion_area` FOREIGN KEY (`id_area`) REFERENCES `areas_gastos` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuario_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
