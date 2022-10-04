-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2022 a las 07:06:00
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_sistemaescolar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `paralelo_id` int(11) DEFAULT NULL,
  `promedio_total` double DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id`, `docente_id`, `materia_id`, `curso_id`, `paralelo_id`, `promedio_total`, `estado`) VALUES
(1, 4, 1, 1, 1, 9.17, 'A'),
(2, 4, 1, 1, 1, 9.1, 'A'),
(3, 4, 1, 1, 1, 8.83, 'A'),
(4, 4, 1, 1, 1, 8.33, 'A'),
(5, 4, 1, 1, 1, 9.17, 'A'),
(6, 4, 1, 1, 1, 8.08, 'A'),
(7, 4, 2, 1, 1, 7.83, 'A'),
(8, 4, 2, 1, 1, 8.43, 'A'),
(9, 4, 2, 1, 1, 8.54, 'A'),
(10, 4, 2, 1, 1, 7.98, 'A'),
(11, 4, 2, 1, 1, 8.71, 'A'),
(12, 4, 2, 1, 1, 9, 'A'),
(13, 4, 3, 1, 1, 9.1, 'A'),
(14, 4, 3, 1, 1, 8, 'A'),
(15, 4, 3, 1, 1, 9.46, 'A'),
(16, 4, 3, 1, 1, 8.93, 'A'),
(17, 4, 3, 1, 1, 8.58, 'A'),
(18, 4, 3, 1, 1, 8.46, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `jornada_id` int(11) DEFAULT NULL,
  `nombre_curso` varchar(100) NOT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `total_estudiantes` int(11) DEFAULT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id`, `jornada_id`, `nombre_curso`, `capacidad`, `total_estudiantes`, `estado`) VALUES
(1, 1, 'Octavo', 100, 2, 'A'),
(2, 1, 'Noveno', 100, 0, 'A'),
(3, 2, 'Decimo', 50, 0, 'A'),
(6, 1, 'Prueba Curso', 50, 1, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_materia`
--

CREATE TABLE `curso_materia` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `curso_materia`
--

INSERT INTO `curso_materia` (`id`, `curso_id`, `materia_id`, `estado`) VALUES
(1, 1, 1, 'A'),
(2, 1, 2, 'A'),
(3, 1, 3, 'A'),
(4, 2, 1, 'A'),
(5, 2, 2, 'A'),
(6, 3, 1, 'A'),
(7, 3, 5, 'A'),
(8, 3, 6, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_calificaciones`
--

CREATE TABLE `detalle_calificaciones` (
  `id` int(11) NOT NULL,
  `calificaciones_id` int(11) DEFAULT NULL,
  `parcial_id` int(11) DEFAULT NULL,
  `quimestre_id` int(11) DEFAULT NULL,
  `estudiante_id` int(11) DEFAULT NULL,
  `nota1` double DEFAULT NULL,
  `nota2` double DEFAULT NULL,
  `nota3` double DEFAULT NULL,
  `nota4` double DEFAULT NULL,
  `nota5` double DEFAULT NULL,
  `nota6` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `promedio` double DEFAULT NULL,
  `examen` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_calificaciones`
--

INSERT INTO `detalle_calificaciones` (`id`, `calificaciones_id`, `parcial_id`, `quimestre_id`, `estudiante_id`, `nota1`, `nota2`, `nota3`, `nota4`, `nota5`, `nota6`, `total`, `promedio`, `examen`) VALUES
(1, 1, 1, 1, 2, 9.5, 9, 9.5, 8, 10, 9, 55, 9.17, 8.5),
(2, 2, 2, 1, 2, 9, 9, 8, 8.6, 10, 10, 54.6, 9.1, 9),
(3, 3, 3, 1, 2, 9.5, 9.5, 9.5, 8.5, 8, 8, 53, 8.83, 8),
(4, 4, 1, 2, 2, 8.5, 7.5, 8, 8, 9, 9, 50, 8.33, 9),
(5, 5, 2, 2, 2, 9, 9, 9.5, 8.5, 10, 9, 55, 9.17, 9),
(6, 6, 3, 2, 2, 9.5, 9, 7, 7, 8, 8, 48.5, 8.08, 8),
(7, 7, 1, 1, 2, 8, 8, 7.5, 7.5, 8, 8, 47, 7.83, 9.5),
(8, 8, 2, 1, 2, 8.5, 8.5, 8, 8, 9, 8.6, 50.6, 8.43, 8.25),
(9, 9, 3, 1, 2, 8.5, 8.5, 9, 7.25, 9, 9, 51.25, 8.54, 9),
(10, 10, 1, 2, 2, 7, 7.25, 8, 8, 9, 8.6, 47.85, 7.98, 8),
(11, 11, 2, 2, 2, 8, 8, 8.25, 9, 9, 10, 52.25, 8.71, 10),
(12, 12, 3, 2, 2, 9, 9, 9, 9, 9, 9, 54, 9, 9),
(13, 13, 1, 1, 2, 8, 9, 9, 9.6, 10, 9, 54.6, 9.1, 9),
(14, 14, 2, 1, 2, 8, 8, 8, 8, 8, 8, 48, 8, 8),
(15, 15, 3, 1, 2, 9, 9.25, 9.5, 9, 10, 10, 56.75, 9.46, 10),
(16, 16, 1, 2, 2, 9, 8.6, 9, 9, 9, 9, 53.6, 8.93, 9.25),
(17, 17, 2, 2, 2, 8.25, 8.25, 8.5, 8.5, 9, 9, 51.5, 8.58, 9),
(18, 18, 3, 2, 2, 8, 8, 8, 8.25, 9, 9.5, 50.75, 8.46, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id`, `persona_id`, `estado`) VALUES
(1, 2, 'A'),
(2, 3, 'A'),
(3, 5, 'A'),
(4, 10, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente_materia`
--

CREATE TABLE `docente_materia` (
  `id` int(11) NOT NULL,
  `periodo_id` int(11) DEFAULT NULL,
  `docente_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `paralelo_id` int(11) DEFAULT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `docente_materia`
--

INSERT INTO `docente_materia` (`id`, `periodo_id`, `docente_id`, `materia_id`, `curso_id`, `paralelo_id`, `estado`) VALUES
(1, 1, 4, 1, 1, 1, 'A'),
(2, 1, 4, 2, 1, 1, 'A'),
(3, 1, 4, 3, 1, 1, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `paralelo_id` int(11) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id`, `persona_id`, `curso_id`, `paralelo_id`, `estado`) VALUES
(1, 29, 6, 1, 'A'),
(2, 30, 1, 1, 'A'),
(3, 31, 1, 1, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada`
--

CREATE TABLE `jornada` (
  `id` int(11) NOT NULL,
  `jornada` varchar(50) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jornada`
--

INSERT INTO `jornada` (`id`, `jornada`, `estado`) VALUES
(1, 'Matutina', 'A'),
(2, 'Vespertina', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id` int(11) NOT NULL,
  `nombre_materia` varchar(100) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id`, `nombre_materia`, `estado`) VALUES
(1, 'Matematicas', 'A'),
(2, 'Lengua y Literatura', 'A'),
(3, 'Estudios Sociales', 'A'),
(4, 'Ciencias Naturales', 'A'),
(5, 'Ingles', 'A'),
(6, 'Educacion Fisica', 'A'),
(7, 'Educacion Artistica', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `id_seccion` int(11) DEFAULT NULL,
  `menu` varchar(100) DEFAULT NULL,
  `icono` varchar(100) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `posicion` int(2) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `id_seccion`, `menu`, `icono`, `url`, `posicion`, `estado`) VALUES
(1, 0, 'Inicio', 'fa fa-laptop', 'inicio', 0, 'I'),
(2, 1, 'Dashboard', '#', 'inicio/administrador', 1, 'I'),
(3, 0, 'Gestión Usuarios', 'fa fa-user', 'usuario', 0, 'A'),
(4, 3, 'Nuevo Usuario', '#', 'usuario/nuevo', 1, 'A'),
(5, 3, 'Listar Usuario', '#', 'usuario/listar', 2, 'A'),
(6, 0, 'Inicio', 'fa fa-laptop', 'inicio/docente', 0, 'A'),
(7, 0, 'Gestion Estudiantes', 'fa fa-address-card', 'estudiantes', 0, 'A'),
(8, 7, 'Listar Estudiantes', '#', 'estudiantes/listar', 1, 'A'),
(9, 0, 'Registros', 'fa-tags', 'registros', 0, 'A'),
(10, 9, 'Nuevo Registro', '#', 'registros/nuevo', 1, 'A'),
(11, 9, 'Asignar Materias', '#', 'registros/asignarmateria', 1, 'A'),
(12, 9, 'Asignar Docente', '#', 'registros/asignardocentemateria', 2, 'A'),
(13, 6, 'Mis Cursos', '#', 'inicio/miscursos', 1, 'A'),
(14, 0, 'Reportes', 'fa fa-clipboard', 'reportes', 0, 'A'),
(15, 14, 'Reporte Por Estudiante', '#', 'reportes/estudiante', 1, 'A'),
(16, 14, 'Reporte Por Parcial', '#', 'reportes/parcial', 2, 'A'),
(17, 0, 'Calificaciones', 'fa fa-list', 'calificaciones', 0, 'A'),
(18, 17, 'Control Calificaciones', '#', 'calificaciones/control', 1, 'A'),
(19, 14, 'Reporte Quimestral', '#', 'reportes/quimestral', 3, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paralelo`
--

CREATE TABLE `paralelo` (
  `id` int(11) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paralelo`
--

INSERT INTO `paralelo` (`id`, `tipo`, `estado`) VALUES
(1, 'A', 'A'),
(2, 'B', 'A'),
(3, 'D', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parcial`
--

CREATE TABLE `parcial` (
  `id` int(11) NOT NULL,
  `parcial` varchar(30) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `parcial`
--

INSERT INTO `parcial` (`id`, `parcial`, `estado`) VALUES
(1, 'Primer Parcial', 'A'),
(2, 'Segundo Parcial', 'A'),
(3, 'Tercer Parcial', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo`
--

CREATE TABLE `periodo` (
  `id` int(11) NOT NULL,
  `periodo` varchar(50) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `periodo`
--

INSERT INTO `periodo` (`id`, `periodo`, `estado`) VALUES
(1, '2022', 'A'),
(2, '2023', 'A'),
(3, '2024', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `acceso` varchar(1) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `rol_id`, `menu_id`, `acceso`, `estado`) VALUES
(1, 1, 1, 'N', 'I'),
(2, 1, 2, 'N', 'I'),
(3, 1, 3, 'S', 'A'),
(4, 1, 4, 'S', 'A'),
(5, 1, 5, 'S', 'A'),
(6, 3, 6, 'S', 'A'),
(8, 1, 9, 'S', 'A'),
(9, 1, 10, 'S', 'A'),
(11, 1, 11, 'S', 'A'),
(12, 1, 12, 'S', 'A'),
(13, 3, 13, 'S', 'A'),
(14, 1, 7, 'S', 'A'),
(15, 1, 8, 'S', 'A'),
(16, 1, 14, 'S', 'A'),
(17, 1, 15, 'S', 'A'),
(18, 2, 14, 'S', 'A'),
(19, 2, 16, 'S', 'A'),
(20, 3, 17, 'S', 'A'),
(21, 3, 18, 'S', 'A'),
(22, 2, 19, 'S', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `sexo_id` int(11) DEFAULT NULL,
  `cedula` varchar(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `celular` varchar(10) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `sexo_id`, `cedula`, `nombres`, `apellidos`, `celular`, `direccion`, `estado`) VALUES
(1, 1, '24000032775', 'Jordy', 'Pozo', '0988838045', 'Santa Elena', 'A'),
(2, 1, '2400032559', 'Danny', 'Chavez', '0945468445', 'Salinas', 'A'),
(3, 1, '2400454720', 'Juan', 'Carlos', '0945646545', 'Guayaquil', 'A'),
(5, 1, '2450311556', 'Carlos', 'Rodriguez', '0975646465', 'Manabi', 'A'),
(9, 1, '2450067323', 'Prueba Admin', 'Pryeba', '0292962652', 'Salinas', 'A'),
(10, 2, '0928275817', 'Prueba Docente', 'PruebaD', '0984515151', 'Muey', 'A'),
(29, 2, '2450795261', 'Daniela', 'Cruz', '0987651255', 'La libertad', 'A'),
(30, 1, '2450024969', 'Mario', 'Fernandez', '0985615151', 'Muey', 'A'),
(31, 1, '2450876111', 'Bruno', 'Perez', '0985478959', 'Santa elena', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quimestre`
--

CREATE TABLE `quimestre` (
  `id` int(11) NOT NULL,
  `quimestre` varchar(50) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `quimestre`
--

INSERT INTO `quimestre` (`id`, `quimestre`, `estado`) VALUES
(1, 'Primer Quimestre', 'A'),
(2, 'Segundo Quimestre', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `cargo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `cargo`, `estado`) VALUES
(1, 'Administrador', 'A'),
(2, 'Estudiante', 'A'),
(3, 'Docente', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE `sexo` (
  `id` int(11) NOT NULL,
  `sexo` varchar(30) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`id`, `sexo`, `estado`) VALUES
(1, 'Masculino', 'A'),
(2, 'Femenino', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `img` varchar(200) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `conf_clave` varchar(100) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `persona_id`, `rol_id`, `usuario`, `correo`, `img`, `clave`, `conf_clave`, `estado`) VALUES
(1, 1, 1, 'jordy45', 'jordy1@gmail.com', 'userdefault.png', '324fbd3a9c7100837b90b3351e53e97050a22c85678b9226386bd7066ed2ca0c', '324fbd3a9c7100837b90b3351e53e97050a22c85678b9226386bd7066ed2ca0c', 'A'),
(2, 2, 3, 'Danny745', 'danny_791@hotmail.es', 'userdefault.png', '668e2b73ac556a2f051304702da290160b29bad3392ddcc72074fefbee80c55a', 'dfd0dee33f082ff6b60d76ce06c45448716cfc8c1635bf1b0bfd939190e8dc51', 'A'),
(3, 3, 3, 'Juan', 'juan@gmail.com', 'userdefault.png', 'ed08c290d7e22f7bb324b15cbadce35b0b348564fd2d5f95752388d86d71bcca', 'ed08c290d7e22f7bb324b15cbadce35b0b348564fd2d5f95752388d86d71bcca', 'A'),
(5, 5, 3, 'Carlos', 'carlos1@gmail.com', 'userdefault.png', '7b85175b455060e3237e925f023053ca9515e8682a83c8b09911c724a1f8b75f', '7b85175b455060e3237e925f023053ca9515e8682a83c8b09911c724a1f8b75f', 'A'),
(9, 9, 1, 'pruebaadmin', 'pruebaad@gmail.com', 'userdefault.png', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'A'),
(10, 10, 3, 'pruebadoc', 'pruebadoc@gmail.com', 'userdefault.png', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'A'),
(29, 29, 2, 'daniela', 'danny@gmail.com', 'estudiantedefault.png', 'e4ee06d13f52021bfbfc793ebce404608a0efd7786e1accad9d113d099fbab48', 'e4ee06d13f52021bfbfc793ebce404608a0efd7786e1accad9d113d099fbab48', 'A'),
(30, 30, 2, 'mario', 'mario@gmail.com', 'estudiantedefault.png', '59195c6c541c8307f1da2d1e768d6f2280c984df217ad5f4c64c3542b04111a4', '59195c6c541c8307f1da2d1e768d6f2280c984df217ad5f4c64c3542b04111a4', 'A'),
(31, 31, 2, 'bruno', 'bruno@gmail.com', 'estudiantedefault.png', 'ccc68482d9e0eee0789e64c7674421076738f8836857ea89bcd0afb832bf3fc3', 'ccc68482d9e0eee0789e64c7674421076738f8836857ea89bcd0afb832bf3fc3', 'A');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cal_docente` (`docente_id`),
  ADD KEY `fk_cal_materia` (`materia_id`),
  ADD KEY `fk_cal_curso` (`curso_id`),
  ADD KEY `fk_cal_paralelo` (`paralelo_id`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curso_jor` (`jornada_id`);

--
-- Indices de la tabla `curso_materia`
--
ALTER TABLE `curso_materia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cursmat_curso` (`curso_id`),
  ADD KEY `fk_cursmat_materia` (`materia_id`);

--
-- Indices de la tabla `detalle_calificaciones`
--
ALTER TABLE `detalle_calificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detcal_cal` (`calificaciones_id`),
  ADD KEY `fk_detcal_parcial` (`parcial_id`),
  ADD KEY `fk_detcal_est` (`estudiante_id`),
  ADD KEY `fk_detcal_quimestre` (`quimestre_id`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_docente_persona` (`persona_id`);

--
-- Indices de la tabla `docente_materia`
--
ALTER TABLE `docente_materia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_docentemateria_docente` (`docente_id`),
  ADD KEY `fk_docentemateria_materia` (`materia_id`),
  ADD KEY `fk_docentemateria_curso` (`curso_id`),
  ADD KEY `fk_docentemateria_paralelo` (`paralelo_id`),
  ADD KEY `fk_docentemateria_periodo` (`periodo_id`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estudiante_persona` (`persona_id`),
  ADD KEY `fk_estudiante_curso` (`curso_id`),
  ADD KEY `fk_estudiante_paralelo` (`paralelo_id`);

--
-- Indices de la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paralelo`
--
ALTER TABLE `paralelo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `parcial`
--
ALTER TABLE `parcial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_permisos_menu` (`menu_id`),
  ADD KEY `fk_permisos_rol` (`rol_id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_per_sexo` (`sexo_id`);

--
-- Indices de la tabla `quimestre`
--
ALTER TABLE `quimestre`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_persona` (`persona_id`),
  ADD KEY `fk_usuarios_roles` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `curso_materia`
--
ALTER TABLE `curso_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `detalle_calificaciones`
--
ALTER TABLE `detalle_calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `docente_materia`
--
ALTER TABLE `docente_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `jornada`
--
ALTER TABLE `jornada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `paralelo`
--
ALTER TABLE `paralelo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `parcial`
--
ALTER TABLE `parcial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `quimestre`
--
ALTER TABLE `quimestre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `fk_cal_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `fk_cal_docente` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`),
  ADD CONSTRAINT `fk_cal_materia` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`),
  ADD CONSTRAINT `fk_cal_paralelo` FOREIGN KEY (`paralelo_id`) REFERENCES `paralelo` (`id`);

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `fk_curso_jor` FOREIGN KEY (`jornada_id`) REFERENCES `jornada` (`id`);

--
-- Filtros para la tabla `curso_materia`
--
ALTER TABLE `curso_materia`
  ADD CONSTRAINT `fk_cursmat_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `fk_cursmat_materia` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`);

--
-- Filtros para la tabla `detalle_calificaciones`
--
ALTER TABLE `detalle_calificaciones`
  ADD CONSTRAINT `fk_detcal_cal` FOREIGN KEY (`calificaciones_id`) REFERENCES `calificaciones` (`id`),
  ADD CONSTRAINT `fk_detcal_est` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiante` (`id`),
  ADD CONSTRAINT `fk_detcal_parcial` FOREIGN KEY (`parcial_id`) REFERENCES `parcial` (`id`),
  ADD CONSTRAINT `fk_detcal_quimestre` FOREIGN KEY (`quimestre_id`) REFERENCES `quimestre` (`id`);

--
-- Filtros para la tabla `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `fk_docente_persona` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `docente_materia`
--
ALTER TABLE `docente_materia`
  ADD CONSTRAINT `fk_docentemateria_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `fk_docentemateria_docente` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`),
  ADD CONSTRAINT `fk_docentemateria_materia` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`),
  ADD CONSTRAINT `fk_docentemateria_paralelo` FOREIGN KEY (`paralelo_id`) REFERENCES `paralelo` (`id`),
  ADD CONSTRAINT `fk_docentemateria_periodo` FOREIGN KEY (`periodo_id`) REFERENCES `periodo` (`id`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_estudiante_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `fk_estudiante_paralelo` FOREIGN KEY (`paralelo_id`) REFERENCES `paralelo` (`id`),
  ADD CONSTRAINT `fk_estudiante_persona` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `fk_permisos_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `fk_permisos_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_per_sexo` FOREIGN KEY (`sexo_id`) REFERENCES `sexo` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_persona` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
