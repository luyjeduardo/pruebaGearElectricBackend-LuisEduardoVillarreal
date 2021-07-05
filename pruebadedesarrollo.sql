-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-07-2021 a las 15:33:20
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pruebadedesarrollo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `tipodedocumento` varchar(25) NOT NULL,
  `numerodedocumento` varchar(10) NOT NULL,
  `nombresyapellidos` varchar(100) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`tipodedocumento`, `numerodedocumento`, `nombresyapellidos`, `telefono`, `email`, `estado`) VALUES
('Cedula de ciudadania', '1231231232', 'Pedrito perez perea', '5255512', 'luedvito1994@gmail.com', 'activo'),
('Cedula extranjera', '213123123', 'jose perez', '234234234', 'luedvito1994@gmail.com', 'inactivo'),
('Cedula de ciudadania', '23424234', 'eeeeeeeeeee', '234234234', 'luedvito1994@gmail.com', 'activo'),
('Pasaporte', '242342423', 'juuu', '1232412123', 'luedvito1994@gmail.com', 'activo'),
('Cedula de ciudadania', '888838383', 'ddddddddddddddddddddd', '4234234', 'luedvito1994@gmail.com', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`numerodedocumento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
