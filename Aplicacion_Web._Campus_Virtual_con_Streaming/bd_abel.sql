-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-08-2015 a las 15:53:37
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_abel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE IF NOT EXISTS `asignatura` (
  `id_asignatura` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `id_profesor` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10020 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`id_asignatura`, `nombre`, `descripcion`, `id_profesor`) VALUES
(10019, 'Frances', 'Frances', '03475014f');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembro`
--

CREATE TABLE IF NOT EXISTS `miembro` (
  `id_usuario` varchar(20) NOT NULL,
  `id_asignatura` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `miembro`
--

INSERT INTO `miembro` (`id_usuario`, `id_asignatura`) VALUES
('03475014p', 10019);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE IF NOT EXISTS `recurso` (
  `id_recurso` int(10) NOT NULL,
  `autor` varchar(50) DEFAULT NULL,
  `ruta` varchar(50) DEFAULT NULL,
  `nombre_recurso` varchar(50) DEFAULT NULL,
  `descripcion_recurso` varchar(500) DEFAULT NULL,
  `es_publico` tinyint(1) NOT NULL DEFAULT '0',
  `id_tema` int(10) NOT NULL,
  `id_alumno` text
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`id_recurso`, `autor`, `ruta`, `nombre_recurso`, `descripcion_recurso`, `es_publico`, `id_tema`, `id_alumno`) VALUES
(57, '03475014f', '../archivos/', 'Recurso de Frances', 'Recurso de Frances Modificar\r\n', 1, 127, NULL),
(59, '03475014f', '../archivos/', 'Recurso de los verbos', 'Recurso de los verbos', 0, 127, NULL),
(60, '03475014p', '../archivos/', 'Recurso del alumno', 'Recurso del alumno Modificar', 1, 127, NULL),
(61, '03475014f', NULL, 'Tutoria de Frances', 'Tutoria de Frances', 1, 127, '03475014p'),
(62, '03475014p', '../archivos/agua08.jpg', 'Recurso del alumno 2', 'Recurso del alumno 2', 0, 127, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE IF NOT EXISTS `tema` (
  `id_tema` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `id_asignatura` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`id_tema`, `fecha`, `descripcion`, `id_asignatura`) VALUES
(127, '2015-08-26', 'Tema I de Frances Modificado', 10019);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `rol` varchar(25) NOT NULL,
  `salt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `pass`, `correo`, `rol`, `salt`) VALUES
('03475014f', 'Profesor de Frances', '990b4e597ce23940cf9bfa1bf1effdb8546d2f7b', 'frances@frances', 'Profesor', 'CC/CBW/dZEcv2huZ3DvlyQ=='),
('03475014j', 'Abel', '3bd5c2ef3a16348eb0c3b0cf42d0d8a262fcee67', 'abel@abel', 'Profesor', 'xCmj2PGkFBrVt3VPqx3CRA=='),
('03475014p', 'AlumnoFrances', '3e0f179010a9cf3e9dd4934f16b3cdf5defa6871', '03475014p@03475014p', 'Alumno', 'yalBVUzj4Nj/tvrEZzCImA=='),
('03475014z', 'Jose Perez', '40cc96c91b7c4b37c0117614eb05ea7b9de67e59', 'jose@jose', 'Profesor', 'dnGe+Qa3LQNGM7IJ+5GDPQ=='),
('admin', 'admin', '159b06dd40b0c41eeb33121f5ecc397bc1e9e508', 'admin@admin1', 'Admin', 'qj3nqAC7c+RzZLinH2D08w==');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`id_asignatura`),
  ADD KEY `id_profesor_idx` (`id_profesor`);

--
-- Indices de la tabla `miembro`
--
ALTER TABLE `miembro`
  ADD PRIMARY KEY (`id_usuario`,`id_asignatura`),
  ADD KEY `id_usuario_idx` (`id_usuario`),
  ADD KEY `id_asignatura` (`id_asignatura`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id_recurso`),
  ADD KEY `id_tema_idx` (`id_tema`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id_tema`),
  ADD KEY `id_asignatura_idx` (`id_asignatura`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `id_asignatura` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10020;
--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id_recurso` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `id_tema` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=130;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `miembro`
--
ALTER TABLE `miembro`
  ADD CONSTRAINT `id_asignatura` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id_asignatura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD CONSTRAINT `id_tema` FOREIGN KEY (`id_tema`) REFERENCES `tema` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tema`
--
ALTER TABLE `tema`
  ADD CONSTRAINT `id_asignatura_tema` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id_asignatura`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
