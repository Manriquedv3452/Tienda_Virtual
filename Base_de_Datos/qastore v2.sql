-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2018 a las 00:20:41
-- Versión del servidor: 10.1.35-MariaDB
-- Versión de PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `qastore`
--
CREATE DATABASE IF NOT EXISTS `qastore` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `qastore`;

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizarProducto` (IN `id` INT, IN `pNombre` VARCHAR(45), IN `Pdescripcion` VARCHAR(200), IN `pImagen` VARCHAR(200), IN `pPrecio` FLOAT, IN `pStock` INT, IN `cat` INT)  BEGIN
  update producto set nombre = pNombre, 
  descripcion = Pdescripcion, 
  precio = pPrecio,
  stock = pStock,
  imagen = pImagen
  where idProducto = id;
  update categoria_x_producto set Categoria_idCategoria = cat
  where Producto_idProducto = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscarProductoxID` (IN `pID` INT)  BEGIN

SELECT p.idProducto, p.nombre, p.descripcion, p.precio, p.imagen, p.precio, p.stock, p.estado, pc.Categoria_idCategoria, c.nombre as Cnombre
from producto p, categoria_x_producto pc, categoria c where
pID = p.idProducto and pID = pc.Producto_idProducto and pc.Categoria_idCategoria = c.idCategoria and estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `busqueda_producto` (IN `frase` VARCHAR(45))  BEGIN
SELECT * FROM producto WHERE nombre LIKE CONCAT('%', frase, '%') and estado = 1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteProducto` (IN `id` INT)  BEGIN
  update producto set estado = 0 where idProducto = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategorias` ()  BEGIN
  select idCategoria, nombre,condicion from Categoria;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductos` ()  BEGIN
  select * from Producto
    where estado = 1
  order by idProducto desc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUsuario` (IN `correo` VARCHAR(255))  BEGIN
  select users.name, email, admin from users where email = correo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarCarrito` (IN `pFecha` DATETIME, IN `pCorreo` VARCHAR(45))  BEGIN
INSERT INTO `qastore`.`carrito`
(
`fecha`,
`Usuario_correo`)
VALUES
(
pFecha,
pCorreo);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarCarritoXProducto` (IN `pCarritoID` INT, IN `pProductoID` INT, IN `pCantidad` INT)  BEGIN
INSERT INTO `qastore`.`carrito_x_producto`
(`Carrito_idCarrito`,
`Producto_idProducto`,
`cantidad`,
`precio`)
VALUES
(pCarritoID,
pProductoID,
pCantidad,
pCantidad * (SELECT 
    precio 
FROM producto where idProducto = pProductoID));
update producto set stock = (stock - pCantidad) where idProducto = pProductoID;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarCategoria` (IN `pNombre` VARCHAR(45), IN `pDescripcion` VARCHAR(200), IN `pCondicion` INT)  BEGIN
INSERT INTO `qastore`.`categoria`
(
`nombre`,
`descripcion`,
`condicion`)
VALUES
(
pNombre,
pDescripcion,
pCondicion);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarCategoriaXProducto` (IN `pCategoriaID` INT, IN `pProductoID` INT)  BEGIN
INSERT INTO `qastore`.`categoria_x_producto`
(`Categoria_idCategoria`,
`Producto_idProducto`)
VALUES
(pCategoriaID,
pProductoID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarOrden` (IN `pDireccion` VARCHAR(200), IN `PCarritoID` INT, IN `pTotal` DOUBLE, IN `pTarjeta` INT)  BEGIN
INSERT INTO `qastore`.`orden`
(
`total`,
`fecha`,
`direccion`,
`Carrito_idCarrito`,
`Tarjeta_idTarjeta`)
VALUES
(
pTotal,
NOW(),
pDireccion,
pCarritoID,
pTarjeta);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarProducto` (IN `pNombre` VARCHAR(45), IN `Pdescripcion` VARCHAR(200), IN `pImagen` VARCHAR(200), IN `pPrecio` FLOAT, IN `pStock` INT)  BEGIN
INSERT INTO `qastore`.`producto`
(
`nombre`,
`descripcion`,
`imagen`,
`precio`,
`stock`)
VALUES
(
pNombre,
pDescripcion,
pImagen,
pPrecio,
pStock);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarTarjeta` (IN `pNombre` VARCHAR(45), IN `pNumero` VARCHAR(255), IN `pCCV` INT, IN `pFecha` DATE, IN `pCorreo` VARCHAR(45))  BEGIN
INSERT INTO `qastore`.`tarjeta`
(
`nombre_tarjeta`,
`numero_tarjeta`,
`ccv`,
`fecha_expiracion`,
`Usuario_correo`)
VALUES
(
pNombre,
MD5(pNumero),
MD5(pCCV),
pFecha,
pCorreo);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertartipoUsuario` (IN `pNombre` VARCHAR(45))  BEGIN
INSERT INTO `qastore`.`tipousuario`
(
`nombre`)
VALUES
(
pNombre);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarUsuario` (IN `pNombre` VARCHAR(45), IN `pApellido1` VARCHAR(45), IN `pApellido2` VARCHAR(45), IN `pCorreo` VARCHAR(45), IN `pContrasena` VARCHAR(45), IN `pTipoUsuarioID` INT)  BEGIN
INSERT INTO `qastore`.`usuario`
(
`nombre`,
`apellido1`,
`apellido2`,
`correo`,
`contrasena`,
`tipoUsuario_idtipoUsuario`)
VALUES
(
pNombre,
pApellido1,
pApellido2,
pCorreo,
MD5(pContrasena),
pTipoUsuarioID);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ordenesPorUsuario` (IN `correo` VARCHAR(255))  BEGIN
  select LPAD(idOrden,10,0) as factura, total, ord.fecha,direccion,Carrito_idCarrito from orden as ord
  inner join Carrito on Carrito_idCarrito = idCarrito
  where Usuario_correo = correo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `productosPorOrden` (IN `ordenID` INT)  BEGIN
select nombre, imagen, producto.precio from producto
  inner join carrito_x_producto on Producto_idProducto = idProducto
  where Carrito_idCarrito = ordenID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `productos_x_categoria` (IN `IDcategoria` INT)  BEGIN
  select idProducto,nombre,descripcion, imagen, precio,stock from Producto
  inner join categoria_x_producto on idProducto = Producto_idProducto and Categoria_idCategoria = IDcategoria
  where Producto.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tarjetasPorUsuario` (IN `correo` VARCHAR(255))  BEGIN
  select idTarjeta, nombre_tarjeta, fecha_expiracion from tarjeta
            where Usuario_correo = correo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ultimoCarrito` ()  BEGIN
  select idCarrito FROM Carrito ORDER BY idCarrito DESC LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ultimoProducto` ()  BEGIN
  select idProducto FROM Producto ORDER BY idProducto DESC LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `verificarProducto` (IN `id` INT)  BEGIN
  select idProducto, nombre, imagen, precio from producto where idProducto = id and stock > 0;
END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `agregarProductoXCarrito` (`pProductoID` INT, `pCantidad` INT, `pCarritoID` INT) RETURNS INT(11) BEGIN
DECLARE Resultado INT;
SET Resultado = 1;
IF pCantidad <= (SELECT stock from producto where idProducto = pProductoID) THEN
CALL `qastore`.`insertarCarritoXProducto`(pCarritoID, pProductoID, pCantidad);
ELSE
SET Resultado = 0;
END IF;
  
RETURN Resultado;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE IF NOT EXISTS `carrito` (
  `idCarrito` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `Usuario_correo` varchar(255) NOT NULL,
  PRIMARY KEY (`idCarrito`),
  UNIQUE KEY `idCarrito_UNIQUE` (`idCarrito`),
  KEY `fk_Carrito_Usuario1_idx` (`Usuario_correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_x_producto`
--

CREATE TABLE IF NOT EXISTS `carrito_x_producto` (
  `Carrito_idCarrito` int(11) NOT NULL,
  `Producto_idProducto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  PRIMARY KEY (`Carrito_idCarrito`,`Producto_idProducto`),
  KEY `fk_Carrito_has_Producto_Producto1_idx` (`Producto_idProducto`),
  KEY `fk_Carrito_has_Producto_Carrito_idx` (`Carrito_idCarrito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `condicion` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idCategoria`),
  UNIQUE KEY `idCategoria_UNIQUE` (`idCategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_x_producto`
--

CREATE TABLE IF NOT EXISTS `categoria_x_producto` (
  `Categoria_idCategoria` int(11) NOT NULL,
  `Producto_idProducto` int(11) NOT NULL,
  PRIMARY KEY (`Categoria_idCategoria`,`Producto_idProducto`),
  KEY `fk_Categoria_has_Producto_Producto1_idx` (`Producto_idProducto`),
  KEY `fk_Categoria_has_Producto_Categoria1_idx` (`Categoria_idCategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE IF NOT EXISTS `orden` (
  `idOrden` int(11) NOT NULL AUTO_INCREMENT,
  `total` double DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `Carrito_idCarrito` int(11) NOT NULL,
  `Tarjeta_idTarjeta` int(11) NOT NULL,
  PRIMARY KEY (`idOrden`),
  KEY `fk_Orden_Carrito1_idx` (`Carrito_idCarrito`),
  KEY `fk_Orden_Tarjeta1_idx` (`Tarjeta_idTarjeta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`idProducto`),
  UNIQUE KEY `idProducto_UNIQUE` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE IF NOT EXISTS `tarjeta` (
  `idTarjeta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tarjeta` varchar(45) DEFAULT NULL,
  `numero_tarjeta` varchar(255) DEFAULT NULL,
  `ccv` int(11) DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `Usuario_correo` varchar(255) NOT NULL,
  PRIMARY KEY (`idTarjeta`),
  UNIQUE KEY `idPago_UNIQUE` (`idTarjeta`),
  KEY `fk_Tarjeta_Usuario1_idx` (`Usuario_correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE IF NOT EXISTS `tipousuario` (
  `idtipoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtipoUsuario`),
  UNIQUE KEY `idtipoUsuario_UNIQUE` (`idtipoUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `correo` varchar(45) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido1` varchar(45) DEFAULT NULL,
  `apellido2` varchar(45) DEFAULT NULL,
  `contrasena` varchar(45) DEFAULT NULL,
  `tipoUsuario_idtipoUsuario` int(11) NOT NULL,
  PRIMARY KEY (`correo`),
  UNIQUE KEY `correo_UNIQUE` (`correo`),
  KEY `fk_Usuario_tipoUsuario1_idx` (`tipoUsuario_idtipoUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_Carrito_Usuario1` FOREIGN KEY (`Usuario_correo`) REFERENCES `users` (`email`);

--
-- Filtros para la tabla `carrito_x_producto`
--
ALTER TABLE `carrito_x_producto`
  ADD CONSTRAINT `fk_Carrito_has_Producto_Carrito` FOREIGN KEY (`Carrito_idCarrito`) REFERENCES `carrito` (`idCarrito`),
  ADD CONSTRAINT `fk_Carrito_has_Producto_Producto1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `categoria_x_producto`
--
ALTER TABLE `categoria_x_producto`
  ADD CONSTRAINT `fk_Categoria_has_Producto_Categoria1` FOREIGN KEY (`Categoria_idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `fk_Categoria_has_Producto_Producto1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `fk_Orden_Carrito1` FOREIGN KEY (`Carrito_idCarrito`) REFERENCES `carrito` (`idCarrito`),
  ADD CONSTRAINT `fk_Orden_Tarjeta1` FOREIGN KEY (`Tarjeta_idTarjeta`) REFERENCES `tarjeta` (`idTarjeta`);

--
-- Filtros para la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD CONSTRAINT `fk_Tarjeta_Usuario1` FOREIGN KEY (`Usuario_correo`) REFERENCES `users` (`email`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_Usuario_tipoUsuario1` FOREIGN KEY (`tipoUsuario_idtipoUsuario`) REFERENCES `tipousuario` (`idtipoUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
