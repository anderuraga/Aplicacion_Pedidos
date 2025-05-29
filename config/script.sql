-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2025 a las 10:19:41
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `icono` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

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
  `id_pedido` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `descripcion` mediumtext NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 0,
  `fecha_solucionada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `referencia` varchar(20) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_subconcepto` int(11) NOT NULL,
  `id_area_gasto` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha_creada` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_enviada` datetime DEFAULT NULL,
  `descripcion` mediumtext NOT NULL,
  `importe` decimal(15,2) NOT NULL,
  `id_factura` varchar(20) DEFAULT NULL,
  `anio_contable` year(4) NOT NULL,
  `anexo` varchar(255) DEFAULT NULL,
  `albaran` varchar(255) DEFAULT NULL,
  `factura` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_estados`
--

CREATE TABLE `pedidos_estados` (
  `id` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `comentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `documento` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `seleccionado` tinyint(1) NOT NULL
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
  `id_servicio` int(11) NOT NULL,
  `terceros` varchar(255) DEFAULT NULL,
  `provedoor_profesor` varchar(255) DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subconceptos`
--

CREATE TABLE `subconceptos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_servicio`
--

CREATE TABLE `tipos_servicio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `id` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `cantidad` float(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

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

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_proveedores_gastos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_proveedores_gastos` (
`id` int(11)
,`cif` varchar(9)
,`nombre` varchar(100)
,`direccion` varchar(255)
,`cod_postal` varchar(10)
,`poblacion` varchar(45)
,`provincia` varchar(45)
,`pais` varchar(45)
,`telefono` varchar(17)
,`correo` varchar(255)
,`factura_e` tinyint(4)
,`cuanta_bancaria` varchar(35)
,`contacto` varchar(45)
,`id_servicio` int(11)
,`proveedor_terceros` varchar(255)
,`proveedor_prov_prof` varchar(255)
,`proveedor_fecha_baja` datetime
,`anio_contable` decimal(4,0)
,`gasto_anual` decimal(37,2)
);

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
,`ingresos` double(19,2)
,`gastos` double(19,2)
,`gasto_pendiente` decimal(37,2)
,`total` double(19,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_resumen_movimientos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_resumen_movimientos` (
`id` int(11)
,`departamento_id` int(11)
,`nombre` varchar(45)
,`cantidad` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_proveedores_gastos`
--
DROP TABLE IF EXISTS `vista_proveedores_gastos`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_proveedores_gastos`  AS SELECT `pr`.`id` AS `id`, `pr`.`cif` AS `cif`, `pr`.`nombre` AS `nombre`, `pr`.`direccion` AS `direccion`, `pr`.`cod_postal` AS `cod_postal`, `pr`.`poblacion` AS `poblacion`, `pr`.`provincia` AS `provincia`, `pr`.`pais` AS `pais`, `pr`.`telefono` AS `telefono`, `pr`.`correo` AS `correo`, `pr`.`factura_e` AS `factura_e`, `pr`.`cuanta_bancaria` AS `cuanta_bancaria`, `pr`.`contacto` AS `contacto`, `pr`.`id_servicio` AS `id_servicio`, `pr`.`terceros` AS `proveedor_terceros`, `pr`.`provedoor_profesor` AS `proveedor_prov_prof`, `pr`.`fecha_baja` AS `proveedor_fecha_baja`, coalesce(`pe`.`anio_contable`,year(curdate())) AS `anio_contable`, coalesce(sum(case when `pe`.`id_estado` > 1 then `pe`.`importe` else 0 end),0) AS `gasto_anual` FROM (`proveedores` `pr` left join `pedidos` `pe` on(`pr`.`id` = `pe`.`id_proveedor`)) GROUP BY `pr`.`id`, `pr`.`cif`, `pr`.`nombre`, `pr`.`direccion`, `pr`.`cod_postal`, `pr`.`poblacion`, `pr`.`provincia`, `pr`.`pais`, `pr`.`telefono`, `pr`.`correo`, `pr`.`factura_e`, `pr`.`cuanta_bancaria`, `pr`.`contacto`, `pr`.`id_servicio`, `pe`.`anio_contable` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_resumen_areas`
--
DROP TABLE IF EXISTS `vista_resumen_areas`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_resumen_areas`  AS SELECT `ag`.`id` AS `id_area`, `ag`.`nombre` AS `nombre_area`, `ag`.`id_departamento` AS `id_departamento`, `d`.`nombre` AS `nombre_departamento`, ifnull(sum(case when `t`.`cantidad` > 0 then `t`.`cantidad` else 0 end),0) AS `ingresos`, ifnull(sum(case when `t`.`cantidad` < 0 then abs(`t`.`cantidad`) else 0 end),0) AS `gastos`, ifnull((select sum(`p`.`importe`) from `pedidos` `p` where `p`.`id_area_gasto` = `ag`.`id` and `p`.`id_estado` between 0 and 5),0) AS `gasto_pendiente`, ifnull(sum(case when `t`.`cantidad` > 0 then `t`.`cantidad` else 0 end),0) - (ifnull(sum(case when `t`.`cantidad` < 0 then abs(`t`.`cantidad`) else 0 end),0) + ifnull((select sum(`p`.`importe`) from `pedidos` `p` where `p`.`id_area_gasto` = `ag`.`id` and `p`.`id_estado` between 0 and 5),0)) AS `total` FROM ((`areas_gastos` `ag` left join `departamentos` `d` on(`ag`.`id_departamento` = `d`.`id`)) left join `transacciones` `t` on(`ag`.`id` = `t`.`id_area`)) GROUP BY `ag`.`id`, `ag`.`nombre`, `ag`.`id_departamento`, `d`.`nombre` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_resumen_movimientos`
--
DROP TABLE IF EXISTS `vista_resumen_movimientos`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_resumen_movimientos`  AS SELECT `m`.`id` AS `id`, `m`.`id_departamento` AS `departamento_id`, `m`.`nombre` AS `nombre`, ifnull(sum(`mv`.`cantidad`),0) AS `cantidad` FROM (`materiales` `m` left join `movimientos` `mv` on(`m`.`id` = `mv`.`id_item`)) WHERE 1 GROUP BY `m`.`id` ;

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
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `item_departamento` (`id_departamento`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subconceptos`
--
ALTER TABLE `subconceptos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_servicio`
--
ALTER TABLE `tipos_servicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `incidencia_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD CONSTRAINT `item_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id`);

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
  ADD CONSTRAINT `pedido_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `pedido_subconcepto` FOREIGN KEY (`id_subconcepto`) REFERENCES `subconceptos` (`id`),
  ADD CONSTRAINT `pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuesto_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`);

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
