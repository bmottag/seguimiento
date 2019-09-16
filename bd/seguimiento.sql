-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-09-2019 a las 18:50:17
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bolivia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alertas`
--

CREATE TABLE `alertas` (
  `id_alerta` int(10) NOT NULL,
  `descripcion_alerta` text NOT NULL,
  `fk_id_tipo_alerta` int(1) NOT NULL,
  `mensaje_alerta` text NOT NULL,
  `fecha_alerta` date DEFAULT NULL,
  `hora_alerta` varchar(10) NOT NULL,
  `tiempo_duracion_alerta` varchar(10) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `estado_alerta` int(1) NOT NULL COMMENT '1: Activa; 2: Inactiva'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `alertas`
--

INSERT INTO `alertas` (`id_alerta`, `descripcion_alerta`, `fk_id_tipo_alerta`, `mensaje_alerta`, `fecha_alerta`, `hora_alerta`, `tiempo_duracion_alerta`, `fecha_creacion`, `fecha_inicio`, `fecha_fin`, `estado_alerta`) VALUES
(1, 'ALERTA INICIAL - BOTON 1', 2, 'INDIQUE SI VA A ASISTIR COMO APERADOR AL PUESTO DE VOTACIÓN QUE LE ASIGNARON', '2019-09-12', '08:00', '30', '2019-09-12', '2019-09-12 08:00:00', '2019-10-20 08:30:00', 1),
(2, 'ALERTA PRESENCIAL - BOTON 2', 2, 'INDIQUE SI YA SE ENCUENTRA EN EL PUESTO DE VOTACION', '2019-09-12', '13:00', '60', '2019-09-12', '2019-09-12 13:00:00', '2019-10-20 14:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidatos`
--

CREATE TABLE `candidatos` (
  `id_candidato` int(10) NOT NULL,
  `nombre_completo_candidato` varchar(150) NOT NULL,
  `fk_id_corporacion` int(10) NOT NULL,
  `fk_id_partido` int(10) NOT NULL,
  `numero_orden_candidato` tinyint(1) NOT NULL,
  `sumatoria_votos` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `candidatos`
--

INSERT INTO `candidatos` (`id_candidato`, `nombre_completo_candidato`, `fk_id_corporacion`, `fk_id_partido`, `numero_orden_candidato`, `sumatoria_votos`) VALUES
(1, 'Candidato Presidente 1', 1, 2, 1, 0),
(2, 'Candidato Presidente 2', 1, 6, 2, 0),
(3, 'CANDIDATO PRESIDENTE 3', 1, 8, 3, 0),
(4, 'Candidato Presidente 4', 1, 5, 4, 0),
(5, 'CANDIDATO PRESIDENTE 5', 1, 3, 5, 0),
(6, 'Candidato Presidente 6', 1, 9, 0, 0),
(7, 'Candidato Presidente 7', 1, 7, 0, 0),
(8, 'Candidato Presidente 8', 1, 4, 0, 0),
(9, 'Candidato Presidente 9', 1, 1, 0, 0),
(12, 'Candidato Diputado 1', 3, 1, 1, 0),
(13, 'Candidato Diputado 2', 3, 2, 2, 0),
(14, 'Candidato Diputado 3', 3, 6, 3, 0),
(15, 'Candidato Diputado 4', 3, 8, 4, 0),
(16, 'Candidato Diputado 5', 3, 3, 5, 0),
(17, 'Candidato Diputado 6', 3, 9, 6, 0),
(18, 'Candidato Diputado 7', 3, 5, 7, 0),
(19, 'Candidato Diputado 8', 3, 7, 8, 0),
(20, 'Candidato Diputado 9', 3, 4, 9, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corporacion`
--

CREATE TABLE `corporacion` (
  `id_corporacion` int(10) NOT NULL,
  `corporacion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `corporacion`
--

INSERT INTO `corporacion` (`id_corporacion`, `corporacion`) VALUES
(1, 'PRESIDENCIA'),
(2, 'SENADO'),
(3, 'DIPUTADO CIRCUNSCRIPCIÓN UNINOMINAL'),
(4, 'DIPUTADO CIRCUNSCRIPCIÓN PLURINOMINAL'),
(5, 'DIPUTADO\r\nCIRCUNSCRIPCIÓN ESPECIAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargado_puesto_votacion`
--

CREATE TABLE `encargado_puesto_votacion` (
  `id_encargado` int(10) NOT NULL,
  `fk_id_usuario` int(10) NOT NULL,
  `fk_id_puesto_votacion` int(10) NOT NULL,
  `registro_hora_ingreso_app` datetime NOT NULL,
  `registro_hora_ingreso_puesto` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `registro_hora_cierre` timestamp NULL DEFAULT NULL COMMENT 'Hora cierre primera mesa',
  `estado_operador` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:No se ha iniciado proceso1:Ingreso APP. 2:Ingreso puesto de votacion. 3:Cierre primera mesa. 4:Cierre puesto3:'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `encargado_puesto_votacion`
--

INSERT INTO `encargado_puesto_votacion` (`id_encargado`, `fk_id_usuario`, `fk_id_puesto_votacion`, `registro_hora_ingreso_app`, `registro_hora_ingreso_puesto`, `registro_hora_cierre`, `estado_operador`) VALUES
(1, 1, 1, '2019-09-11 16:31:22', '0000-00-00 00:00:00', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id_mesa` int(10) NOT NULL,
  `fk_puesto_votacion_mesas` int(10) NOT NULL,
  `numero_mesa` int(1) NOT NULL,
  `personas_habilitadas` int(1) NOT NULL,
  `tipo_voto` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Solo Presidente.2:Presidente y Diputado 3:Presidente, Diputado y Especiales',
  `sumatoria_votos` int(1) NOT NULL DEFAULT '0',
  `estado_mesa` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Abierta;2:Cerrada'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id_mesa`, `fk_puesto_votacion_mesas`, `numero_mesa`, `personas_habilitadas`, `tipo_voto`, `sumatoria_votos`, `estado_mesa`) VALUES
(1, 1, 10001, 250, 2, 0, 1),
(2, 1, 10002, 120, 3, 0, 1),
(3, 1, 10003, 260, 1, 0, 2),
(4, 1, 1004, 39, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_general`
--

CREATE TABLE `param_general` (
  `id_param_general` int(10) NOT NULL,
  `fecha_elecciones` date NOT NULL,
  `hora_inicio` int(1) NOT NULL,
  `hora_fin` int(1) NOT NULL,
  `hora_ingreso_app` int(1) NOT NULL,
  `hora_ingreso_puesto` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_general`
--

INSERT INTO `param_general` (`id_param_general`, `fecha_elecciones`, `hora_inicio`, `hora_fin`, `hora_ingreso_app`, `hora_ingreso_puesto`) VALUES
(1, '2019-10-20', 26, 37, 17, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_horas`
--

CREATE TABLE `param_horas` (
  `id_hora` int(1) NOT NULL,
  `hora` varchar(10) NOT NULL,
  `formato_24` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_horas`
--

INSERT INTO `param_horas` (`id_hora`, `hora`, `formato_24`) VALUES
(1, '12:00 AM', '00:00'),
(2, '12:30 AM', '00:30'),
(3, '1:00 AM', '01:00'),
(4, '1:30 AM', '01:30'),
(5, '2:00 AM', '02:00'),
(6, '2:30 AM', '02:30'),
(7, '3:00 AM', '03:00'),
(8, '3:30 AM', '03:30'),
(9, '4:00 AM', '04:00'),
(10, '4:30 AM', '04:30'),
(11, '5:00 AM', '05:00'),
(12, '5:30 AM', '05:30'),
(13, '6:00 AM', '06:00'),
(14, '6:30 AM', '06:30'),
(15, '7:00 AM', '07:00'),
(16, '7:30 AM', '07:30'),
(17, '8:00 AM', '08:00'),
(18, '8:30 AM', '08:30'),
(19, '9:00 AM', '09:00'),
(20, '9:30 AM', '09:30'),
(21, '10:00 AM', '10:00'),
(22, '10:30 AM', '10:30'),
(23, '11:00 AM', '11:00'),
(24, '11:30 AM', '11:30'),
(25, '12:00 PM', '12:00'),
(26, '12:30 PM', '12:30'),
(27, '1:00 PM', '13:00'),
(28, '1:30 PM', '13:30'),
(29, '2:00 PM', '14:00'),
(30, '2:30 PM', '14:30'),
(31, '3:00 PM', '15:00'),
(32, '3:30 PM', '15:30'),
(33, '4:00 PM', '16:00'),
(34, '4:30 PM', '16:30'),
(35, '5:00 PM', '17:00'),
(36, '5:30 PM', '17:30'),
(37, '6:00 PM', '18:00'),
(38, '6:30 PM', '18:30'),
(39, '7:00 PM', '19:00'),
(40, '7:30 PM', '19:30'),
(41, '8:00 PM', '20:00'),
(42, '8:30 PM', '20:30'),
(43, '9:00 PM', '21:00'),
(44, '9:30 PM', '21:30'),
(45, '10:00 PM', '22:00'),
(46, '10:30 PM', '22:30'),
(47, '11:00 PM', '23:00'),
(48, '11:30 PM', '23:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_roles`
--

CREATE TABLE `param_roles` (
  `id_rol` int(1) NOT NULL,
  `nombre_rol` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `mostrar_lista` int(1) NOT NULL COMMENT '1: Mostrar en alerta; 2: NO mostrar'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_roles`
--

INSERT INTO `param_roles` (`id_rol`, `nombre_rol`, `descripcion`, `mostrar_lista`) VALUES
(1, 'Administrador', 'Acceso a todas las funcionalidades del sistema', 2),
(2, 'Auditor', 'Encargado del puesto de votación', 2),
(3, 'Operador', 'Encargado de supervisar auditores', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_tipo_alerta`
--

CREATE TABLE `param_tipo_alerta` (
  `id_tipo_alerta` int(1) NOT NULL,
  `nombre_tipo_alerta` varchar(50) NOT NULL,
  `descripcion_tipo_alerta` text NOT NULL,
  `observacion_alerta` text NOT NULL,
  `fecha_creacion` date NOT NULL,
  `clase` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_tipo_alerta`
--

INSERT INTO `param_tipo_alerta` (`id_tipo_alerta`, `nombre_tipo_alerta`, `descripcion_tipo_alerta`, `observacion_alerta`, `fecha_creacion`, `clase`) VALUES
(1, 'Informativa', 'Botón (Aceptar o Cerrar). No tiene registro, solo se muestra para informar sobre algún tema de interés. Pasados cinco (5) minutos se debe dejar de mostrar.', '- Debe incluir botón Aceptar o Cerrar, con el objeto que el usuario pueda dejar de visualizar o cerrar el mensaje.\r\n- Después de cinco (5) minutos debe dejar de mostrarse.', '2017-05-10', 'text-danger'),
(2, 'Notificación', 'Botones (Si - No). Se espera respuesta del usuario y lleva registro. En caso de respuesta afirmativa (Si), se debe hacer registro y no es obligatorio diligenciar observación o motivo. En caso de respuesta negativa (No), se debe hacer registro y es obligatorio consignar la observación o motivo. En caso de no respuesta, se debe hacer registro automático o asistido por el sistema con observación o motivo (No respuesta) y notificar a usuario de nivel jerárquico superior.', '- Debe incluir botones Si - No.\r\n- Debe incluir una caja de texto en donde se pueden registrar observaciones o motivos, que solo es obligatorio en su registro cuando se selecciona opción "No" o cuando no hay respuesta por parte del usuario, caso en el cual el sistema hace registro automático o asistido.\r\n- Después de quince (15) minutos sin haber recibido respuesta "No respuesta", se debe hacer registro automático o asistido por el sistema con observación o motivo (No respuesta) y se envía notificación a usuario de nivel jerárquico superior. Una vez se hace registro y notifica al nivel jerárquico superior, el mensaje debe dejar de mostrase.', '2017-05-10', 'text-warning'),
(3, 'Consolidación', 'Botón (Enviar). Tiene registro obligatorio de una cifra o valor, opcional se puede registrar algún motivo u observación. En caso de no respuesta, se debe hacer registro automático o asistido por el sistema con motivo (No respuesta) y notificar a usuario de nivel jerárquico superior.', '- Debe incluir botón Enviar.\r\n- Debe incluir una caja de texto en donde se pueden registrar observaciones o motivos; que no tiene obligatoriedad en su registro, excepto cuando no hay respuesta por parte del usuario, caso en el cual el sistema hace registro automático.\r\n- Después de quince (15) minutos sin haber recibido respuesta "No respuesta", se debe hacer registro automático o asistido por el sistema con observación o motivo (No respuesta) y se envía notificación a usuario de nivel jerárquico superior. Una vez se hace registro y notifica al nivel jerárquico superior, el mensaje debe dejar de mostrase.', '2017-05-10', 'text-success');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE `partidos` (
  `id_partido` int(10) NOT NULL,
  `sigla` varchar(10) NOT NULL,
  `nombre_partido` varchar(100) NOT NULL,
  `numero_orden_partido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id_partido`, `sigla`, `nombre_partido`, `numero_orden_partido`) VALUES
(1, 'C.C.', 'COMUNIDAD CIUDADANA', 1),
(2, 'FPV', 'FRENTE PARA LA VICTORIA', 2),
(3, 'MTS', 'MOVIMIENTO TERCER SISTEMA', 3),
(4, 'UCS', 'UNIDAD CIVICA SOLIDARIDAD', 4),
(5, 'MAS-IPSP', 'MOVIMIENTO AL SOCIALISMO - INSTRUMENTO POLITICO POR LA SOBERANIA DE LOS PUEBLOS', 5),
(6, 'BDN-21F', 'BOLIVIA DICE NO', 6),
(7, 'PDC', 'PARTIDO DEMOCRATA CRISTIANO', 7),
(8, 'MNR', 'MOVIMIENTO NACIONALISTA REVOLUCIONARIO', 8),
(9, 'PAN-BOL', 'PARTIDO DE ACCION NACIONAL DEMOCRATICO', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto_votacion`
--

CREATE TABLE `puesto_votacion` (
  `id_puesto_votacion` int(10) NOT NULL,
  `nombre_puesto_votacion` varchar(150) NOT NULL,
  `geolocalizacion` varchar(150) DEFAULT NULL,
  `numero_mesas` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `puesto_votacion`
--

INSERT INTO `puesto_votacion` (`id_puesto_votacion`, `nombre_puesto_votacion`, `geolocalizacion`, `numero_mesas`) VALUES
(1, 'Puesto de votación 1', 'Centro', 25),
(2, 'Puesto de votación 2', 'Noroccidente', 12),
(3, 'Puesto de votación 3', 'SUR', 36),
(4, 'PUESTO DE VOTACIÓN 4', 'Suroccidente', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `id_registro` int(10) NOT NULL,
  `fk_id_alerta` int(10) NOT NULL,
  `fk_id_usuario` int(10) NOT NULL,
  `fk_id_puesto_votacion` int(10) NOT NULL,
  `acepta` int(1) NOT NULL COMMENT '1: Acepta; 2: NO acepta',
  `observacion` text,
  `fecha_registro` datetime NOT NULL,
  `fk_id_user_coordinador` int(10) DEFAULT NULL,
  `nota` varchar(250) DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `fk_id_user_actualiza` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(10) NOT NULL,
  `numero_documento` bigint(10) NOT NULL,
  `tipo_documento` varchar(150) NOT NULL,
  `nombres_usuario` varchar(50) NOT NULL,
  `apellidos_usuario` varchar(50) NOT NULL,
  `telefono_fijo` varchar(12) DEFAULT NULL,
  `celular` varchar(12) NOT NULL,
  `email` varchar(70) DEFAULT NULL,
  `edad` tinyint(4) DEFAULT NULL,
  `sistema_operativo` varchar(50) DEFAULT NULL,
  `nombre_contacto` varchar(150) NOT NULL,
  `telefono_contacto` varchar(12) NOT NULL,
  `tipo_usuario` tinyint(4) DEFAULT NULL COMMENT '1:Principal; 2:Suplente',
  `log_user` bigint(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `fk_id_rol` int(1) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:active; 2:inactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `numero_documento`, `tipo_documento`, `nombres_usuario`, `apellidos_usuario`, `telefono_fijo`, `celular`, `email`, `edad`, `sistema_operativo`, `nombre_contacto`, `telefono_contacto`, `tipo_usuario`, `log_user`, `password`, `clave`, `fk_id_rol`, `estado`) VALUES
(1, 12645615, '1', 'ADMIN', 'APP', '3347766asdfa', '403408992123', 'sinemail@sinemail.com', NULL, '', 'Pepito', '345234', 2, 12645615, 'ce5dbff68c1cb46e1dbf45eb6736ddc2', '12645615', 1, 1),
(2, 79757228, '1', 'JORGE ELIECER', 'LOZANO OSPINA', '', '300 275 44 7', 'jelozanoo@gmail.com', NULL, NULL, '', '', NULL, 79757228, '7b544b82d84f041224ca43f597bfc6c9', '79757228', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD PRIMARY KEY (`id_alerta`),
  ADD KEY `fk_id_tipo_alerta` (`fk_id_tipo_alerta`);

--
-- Indices de la tabla `candidatos`
--
ALTER TABLE `candidatos`
  ADD PRIMARY KEY (`id_candidato`),
  ADD KEY `fk_id_corporacion` (`fk_id_corporacion`),
  ADD KEY `fk_id_partido` (`fk_id_partido`);

--
-- Indices de la tabla `corporacion`
--
ALTER TABLE `corporacion`
  ADD PRIMARY KEY (`id_corporacion`);

--
-- Indices de la tabla `encargado_puesto_votacion`
--
ALTER TABLE `encargado_puesto_votacion`
  ADD PRIMARY KEY (`id_encargado`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`),
  ADD KEY `fk_id_puesto_votacion` (`fk_id_puesto_votacion`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `fk_id_puesto_votacion` (`fk_puesto_votacion_mesas`);

--
-- Indices de la tabla `param_general`
--
ALTER TABLE `param_general`
  ADD PRIMARY KEY (`id_param_general`),
  ADD KEY `hora_inicio` (`hora_inicio`),
  ADD KEY `hora_fin` (`hora_fin`),
  ADD KEY `hora_ingreso_operador` (`hora_ingreso_app`),
  ADD KEY `hora_ingreso_puesto` (`hora_ingreso_puesto`);

--
-- Indices de la tabla `param_horas`
--
ALTER TABLE `param_horas`
  ADD PRIMARY KEY (`id_hora`);

--
-- Indices de la tabla `param_roles`
--
ALTER TABLE `param_roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `param_tipo_alerta`
--
ALTER TABLE `param_tipo_alerta`
  ADD PRIMARY KEY (`id_tipo_alerta`);

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD PRIMARY KEY (`id_partido`);

--
-- Indices de la tabla `puesto_votacion`
--
ALTER TABLE `puesto_votacion`
  ADD PRIMARY KEY (`id_puesto_votacion`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `fk_id_alerta` (`fk_id_alerta`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`),
  ADD KEY `fk_id_puesto_votacion` (`fk_id_puesto_votacion`),
  ADD KEY `fk_id_user_coordinador` (`fk_id_user_coordinador`),
  ADD KEY `acepta` (`acepta`),
  ADD KEY `fk_id_user_actualiza` (`fk_id_user_actualiza`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `numero_documento` (`numero_documento`),
  ADD UNIQUE KEY `log_user` (`log_user`),
  ADD KEY `fk_id_rol` (`fk_id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alertas`
--
ALTER TABLE `alertas`
  MODIFY `id_alerta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `candidatos`
--
ALTER TABLE `candidatos`
  MODIFY `id_candidato` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `corporacion`
--
ALTER TABLE `corporacion`
  MODIFY `id_corporacion` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `encargado_puesto_votacion`
--
ALTER TABLE `encargado_puesto_votacion`
  MODIFY `id_encargado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id_mesa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `param_general`
--
ALTER TABLE `param_general`
  MODIFY `id_param_general` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `param_horas`
--
ALTER TABLE `param_horas`
  MODIFY `id_hora` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT de la tabla `param_roles`
--
ALTER TABLE `param_roles`
  MODIFY `id_rol` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `param_tipo_alerta`
--
ALTER TABLE `param_tipo_alerta`
  MODIFY `id_tipo_alerta` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id_partido` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `puesto_votacion`
--
ALTER TABLE `puesto_votacion`
  MODIFY `id_puesto_votacion` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `id_registro` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `encargado_puesto_votacion`
--
ALTER TABLE `encargado_puesto_votacion`
  ADD CONSTRAINT `encargado_puesto_votacion_ibfk_1` FOREIGN KEY (`fk_id_puesto_votacion`) REFERENCES `puesto_votacion` (`id_puesto_votacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `mesas_ibfk_1` FOREIGN KEY (`fk_puesto_votacion_mesas`) REFERENCES `puesto_votacion` (`id_puesto_votacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `param_general`
--
ALTER TABLE `param_general`
  ADD CONSTRAINT `param_general_ibfk_1` FOREIGN KEY (`hora_inicio`) REFERENCES `param_horas` (`id_hora`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `param_general_ibfk_2` FOREIGN KEY (`hora_fin`) REFERENCES `param_horas` (`id_hora`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `param_general_ibfk_3` FOREIGN KEY (`hora_ingreso_app`) REFERENCES `param_horas` (`id_hora`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `param_general_ibfk_4` FOREIGN KEY (`hora_ingreso_puesto`) REFERENCES `param_horas` (`id_hora`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
