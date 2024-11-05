-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2024 a las 04:15:44
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(10) NOT NULL,
  `cedula` varchar(15) DEFAULT NULL,
  `nombres` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `direccion_residencia` varchar(255) DEFAULT NULL,
  `ubicacion_residencia` point DEFAULT NULL,
  `direccion_trabajo` varchar(255) DEFAULT NULL,
  `ubicacion_trabajo` point DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `cedula`, `nombres`, `apellidos`, `direccion_residencia`, `ubicacion_residencia`, `direccion_trabajo`, `ubicacion_trabajo`) VALUES
(47, '12123132', 'Lina', 'Garcia', 'calle 45K', 0x0000000001010000008f56b5a4a36c124054724eeca18952c0, 'calle 76', 0x0000000001010000005ce674594cac124069e55e60568452c0),
(48, '56565641', 'Juli', 'Bandida', 'calle 30 Bis', 0x000000000101000000f98557923c871240acff73982f8552c0, 'calle 127C', 0x000000000101000000354580d3bbd81240daa84e07b28252c0),
(49, '89870123', 'Owen', 'Eltodasmias', 'calle 49 Sur', 0x000000000101000000fe2b2b4d4a91124016fbcbeec98b52c0, 'calle 102B', 0x0000000001010000000a80f10c1aaa12409e45ef54c08052c0),
(51, '1014', 'Pepito', 'Zayal', 'calle 13', 0x00000000010100000034812216318c1240664cc11a678552c0, '1385', 0x00000000010100000048c32973f39d12400e4dd9e9078352c0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
