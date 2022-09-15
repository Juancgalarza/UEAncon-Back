-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-08-2022 a las 18:42:14
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

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
-- Estructura de tabla para la tabla `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id` int(11) NOT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `estudiante_id` int(11) DEFAULT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `paralelo_id` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignaciones`
--

INSERT INTO `asignaciones` (`id`, `docente_id`, `materia_id`, `estudiante_id`, `curso_id`, `paralelo_id`, `total`, `estado`) VALUES
(1, 3, 1, 2, 1, 2, 9.6, 'A'),
(2, 3, 1, 2, 1, 2, 8.4, 'A'),
(3, 3, 1, 2, 1, 2, 9.6, 'A'),
(4, 3, 1, 2, 1, 2, 7.9, 'A'),
(5, 3, 2, 4, 2, 2, 10, 'A'),
(6, 3, 2, 4, 2, 2, 9.6, 'A'),
(7, 3, 2, 4, 2, 2, 5, 'A'),
(8, 3, 4, 2, 1, 2, 10, 'A'),
(9, 3, 4, 2, 1, 2, 6.8, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `nombre_curso` varchar(100) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id`, `nombre_curso`, `estado`) VALUES
(1, 'Octavo', 'A'),
(2, 'Noveno', 'A'),
(3, 'Decimo', 'A');

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
(1, 3, 2, 'A'),
(2, 1, 1, 'A'),
(4, 2, 1, 'A'),
(5, 1, 2, 'A'),
(6, 1, 3, 'A'),
(7, 1, 4, 'A'),
(8, 3, 1, 'A'),
(9, 3, 3, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_asignaciones`
--

CREATE TABLE `detalle_asignaciones` (
  `id` int(11) NOT NULL,
  `asignaciones_id` int(11) DEFAULT NULL,
  `parcial_id` int(11) DEFAULT NULL,
  `quimestre_id` int(11) DEFAULT NULL,
  `tipo_actividades_id` int(11) DEFAULT NULL,
  `calificacion` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_asignaciones`
--

INSERT INTO `detalle_asignaciones` (`id`, `asignaciones_id`, `parcial_id`, `quimestre_id`, `tipo_actividades_id`, `calificacion`) VALUES
(1, 1, 1, 1, 1, 9.6),
(2, 2, 1, 1, 1, 8.4),
(3, 3, 1, 1, 2, 9.6),
(4, 4, 1, 1, 3, 7.9),
(5, 5, 1, 1, 1, 10),
(6, 6, 1, 1, 1, 9.6),
(7, 7, 1, 1, 1, 5),
(8, 8, 1, 1, 1, 10),
(9, 9, 1, 1, 1, 6.8);

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
(3, 5, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente_materia`
--

CREATE TABLE `docente_materia` (
  `id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `paralelo_id` int(11) DEFAULT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `docente_materia`
--

INSERT INTO `docente_materia` (`id`, `docente_id`, `materia_id`, `curso_id`, `paralelo_id`, `estado`) VALUES
(1, 3, 1, 1, 2, 'A'),
(3, 3, 2, 2, 2, 'A'),
(4, 1, 2, 3, 3, 'A'),
(6, 1, 2, 3, 1, 'A'),
(7, 2, 5, 1, 1, 'A'),
(8, 2, 3, 1, 1, 'A'),
(9, 2, 4, 1, 1, 'A'),
(10, 3, 4, 1, 2, 'A');

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
(1, 4, 1, 1, 'A'),
(2, 6, 1, 2, 'A'),
(3, 7, 3, 2, 'A'),
(4, 8, 2, 2, 'A');

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
(3, 0, 'Gestion Usuarios', 'fa fa-user', 'usuario', 0, 'A'),
(4, 3, 'Guardar Usuario', '#', 'usuario/nuevo', 1, 'A'),
(5, 3, 'Listar Usuario', '#', 'usuario/listar', 2, 'A'),
(6, 0, 'Inicio', 'fa fa-laptop', 'inicio/docente', 0, 'A'),
(7, 0, 'Gestion Estudiantes', 'fa fa-address-card', 'estudiantes', 0, 'A'),
(8, 7, 'Listar Estudiantes', '#', 'estudiantes/listar', 1, 'A'),
(9, 0, 'Registros', 'fa-tags', 'registros', 0, 'A'),
(10, 9, 'Nuevo', '#', 'registros/nuevo', 1, 'A'),
(11, 9, 'Asignar Materias', '#', 'registros/asignarmateria', 1, 'A'),
(12, 9, 'Asignar Docente', '#', 'registros/asignardocentemateria', 2, 'A'),
(13, 6, 'Mis Cursos', '#', 'inicio/miscursos', 1, 'A'),
(14, 0, 'Reportes', 'fa fa-clipboard', 'reportes', 0, 'A'),
(15, 14, 'Reporte Por Estudiante', '#', 'reportes/estudiante', 1, 'A'),
(16, 14, 'Reporte Por Parcial', '#', 'reportes/parcial', 2, 'A');

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
(1, 'Parcial 1', 'A'),
(2, 'Parcial 2', 'A'),
(3, 'Parcial 3', 'A');

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
(3, '2024', 'A'),
(4, '2021', 'I');

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
(19, 2, 16, 'S', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `cedula` varchar(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo` varchar(130) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `cedula`, `nombres`, `apellidos`, `telefono`, `correo`, `direccion`, `estado`) VALUES
(1, '24000032775', 'Jordy', 'Pozo', '0988838045', 'jordy1@gmail.com', 'Santa Elena', 'A'),
(2, '2400032559', 'Danny', 'Chavez', '0945468445', 'danny_791@hotmail.es', 'Salinas', 'A'),
(3, '2400454720', 'Juan', 'Carlos', '0945646545', 'juan@gmail.com', 'chelas', 'A'),
(4, '2450826835', 'Marcos', 'Sanchez', '0945646543', 'marcos@gmail.com', 'salinas', 'A'),
(5, '2450311556', 'Carlos', 'Rodriguez', '0975646465', 'carlos1@gmail.com', 'xxxxx', 'A'),
(6, '2400048720', 'Julia', 'Malave', '0964654165', 'julia@gmail.com', 'SDSD', 'A'),
(7, '2450580689', 'carlos', 'suarez', '0984564654', 'carlossuarez@gmail.com', 'salinas', 'A'),
(8, '2450547563', 'Maria', 'Sanchez', '0988473683', 'maria@hotmail.es', 'guayas', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quimestre`
--

CREATE TABLE `quimestre` (
  `id` int(11) NOT NULL,
  `quimestre` varchar(30) DEFAULT NULL,
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
-- Estructura de tabla para la tabla `tipo_actividades`
--

CREATE TABLE `tipo_actividades` (
  `id` int(11) NOT NULL,
  `actividad` varchar(50) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_actividades`
--

INSERT INTO `tipo_actividades` (`id`, `actividad`, `estado`) VALUES
(1, 'Tarea', 'A'),
(2, 'Proy Integ', 'A'),
(3, 'Eval Sum', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `img` varchar(200) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `conf_clave` varchar(100) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `persona_id`, `rol_id`, `usuario`, `img`, `clave`, `conf_clave`, `estado`) VALUES
(1, 1, 1, 'jordy45', 'userdefault.png', '324fbd3a9c7100837b90b3351e53e97050a22c85678b9226386bd7066ed2ca0c', '324fbd3a9c7100837b90b3351e53e97050a22c85678b9226386bd7066ed2ca0c', 'A'),
(2, 2, 1, 'Danny745', 'userdefault.png', '668e2b73ac556a2f051304702da290160b29bad3392ddcc72074fefbee80c55a', 'dfd0dee33f082ff6b60d76ce06c45448716cfc8c1635bf1b0bfd939190e8dc51', 'A'),
(3, 3, 3, 'Juan', 'userdefault.png', 'ed08c290d7e22f7bb324b15cbadce35b0b348564fd2d5f95752388d86d71bcca', 'ed08c290d7e22f7bb324b15cbadce35b0b348564fd2d5f95752388d86d71bcca', 'A'),
(4, 4, 2, 'marcos44', 'userdefault.png', '43f1efecd33031b0ccd142b1c5cccc44ea19ad3e7a947965c5b0c16a632b5d7b', '43f1efecd33031b0ccd142b1c5cccc44ea19ad3e7a947965c5b0c16a632b5d7b', 'A'),
(5, 5, 3, 'Carlos', 'userdefault.png', '7b85175b455060e3237e925f023053ca9515e8682a83c8b09911c724a1f8b75f', '7b85175b455060e3237e925f023053ca9515e8682a83c8b09911c724a1f8b75f', 'A'),
(6, 6, 2, 'jordyom', 'userdefault.png', '7b346904f63cc07f1d8cc2d88d7dae08a3f088a0e4159d5214c27a6571a51eb4', '7b346904f63cc07f1d8cc2d88d7dae08a3f088a0e4159d5214c27a6571a51eb4', 'A'),
(7, 7, 2, 'carlos854895465', 'userdefault.png', '7b85175b455060e3237e925f023053ca9515e8682a83c8b09911c724a1f8b75f', '7b85175b455060e3237e925f023053ca9515e8682a83c8b09911c724a1f8b75f', 'A'),
(8, 8, 2, 'maria', 'userdefault.png', '94aec9fbed989ece189a7e172c9cf41669050495152bc4c1dbf2a38d7fd85627', '94aec9fbed989ece189a7e172c9cf41669050495152bc4c1dbf2a38d7fd85627', 'A');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cal_docente` (`docente_id`),
  ADD KEY `fk_cal_materia` (`materia_id`),
  ADD KEY `fk_cal_est` (`estudiante_id`),
  ADD KEY `fk_cal_curso` (`curso_id`),
  ADD KEY `fk_cal_paralelo` (`paralelo_id`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `curso_materia`
--
ALTER TABLE `curso_materia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cursmat_curso` (`curso_id`),
  ADD KEY `fk_cursmat_materia` (`materia_id`);

--
-- Indices de la tabla `detalle_asignaciones`
--
ALTER TABLE `detalle_asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_deasig_asig` (`asignaciones_id`),
  ADD KEY `fk_deasign_parcial` (`parcial_id`),
  ADD KEY `fk_deasign_qui` (`quimestre_id`),
  ADD KEY `fk_deasign_act` (`tipo_actividades_id`);

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
  ADD KEY `fk_docentemateria_paralelo` (`paralelo_id`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estudiante_persona` (`persona_id`),
  ADD KEY `fk_estudiante_curso` (`curso_id`),
  ADD KEY `fk_estudiante_paralelo` (`paralelo_id`);

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
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `tipo_actividades`
--
ALTER TABLE `tipo_actividades`
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
-- AUTO_INCREMENT de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `curso_materia`
--
ALTER TABLE `curso_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_asignaciones`
--
ALTER TABLE `detalle_asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `docente_materia`
--
ALTER TABLE `docente_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- AUTO_INCREMENT de la tabla `tipo_actividades`
--
ALTER TABLE `tipo_actividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `fk_cal_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `fk_cal_docente` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`),
  ADD CONSTRAINT `fk_cal_est` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiante` (`id`),
  ADD CONSTRAINT `fk_cal_materia` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`),
  ADD CONSTRAINT `fk_cal_paralelo` FOREIGN KEY (`paralelo_id`) REFERENCES `paralelo` (`id`);

--
-- Filtros para la tabla `curso_materia`
--
ALTER TABLE `curso_materia`
  ADD CONSTRAINT `fk_cursmat_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `fk_cursmat_materia` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`);

--
-- Filtros para la tabla `detalle_asignaciones`
--
ALTER TABLE `detalle_asignaciones`
  ADD CONSTRAINT `fk_deasig_asig` FOREIGN KEY (`asignaciones_id`) REFERENCES `asignaciones` (`id`),
  ADD CONSTRAINT `fk_deasign_act` FOREIGN KEY (`tipo_actividades_id`) REFERENCES `tipo_actividades` (`id`),
  ADD CONSTRAINT `fk_deasign_parcial` FOREIGN KEY (`parcial_id`) REFERENCES `parcial` (`id`),
  ADD CONSTRAINT `fk_deasign_qui` FOREIGN KEY (`quimestre_id`) REFERENCES `quimestre` (`id`);

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
  ADD CONSTRAINT `fk_docentemateria_paralelo` FOREIGN KEY (`paralelo_id`) REFERENCES `paralelo` (`id`);

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
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_persona` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
