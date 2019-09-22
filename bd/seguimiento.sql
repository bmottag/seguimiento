-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-09-2019 a las 18:45:30
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
  `estado_alerta` int(1) NOT NULL COMMENT '1: Activa; 2: Inactiva',
  `flujo_alerta` tinyint(4) NOT NULL COMMENT '1:Reporte asistencia; 2:Ingreso Puesto. 3:Cierre primera mesa'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `alertas`
--

INSERT INTO `alertas` (`id_alerta`, `descripcion_alerta`, `fk_id_tipo_alerta`, `mensaje_alerta`, `fecha_alerta`, `hora_alerta`, `tiempo_duracion_alerta`, `fecha_creacion`, `fecha_inicio`, `fecha_fin`, `estado_alerta`, `flujo_alerta`) VALUES
(1, 'ALERTA INICIAL - BOTON 1', 2, 'INDIQUE SI VA A ASISTIR COMO APERADOR AL PUESTO DE VOTACIÓN QUE LE ASIGNARON', '2019-09-17', '21:00', '120', '2019-09-12', '2019-09-17 21:00:00', '2019-09-17 23:00:00', 1, 1),
(2, 'ALERTA PRESENCIAL - BOTON 2', 2, 'INDIQUE SI YA SE ENCUENTRA EN EL PUESTO DE VOTACION', '2019-09-19', '12:00', '180', '2019-09-12', '2019-09-19 12:00:00', '2019-09-19 15:00:00', 1, 2);

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
-- Estructura de tabla para la tabla `log_registro`
--

CREATE TABLE `log_registro` (
  `id_log_registro` int(10) NOT NULL,
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

--
-- Volcado de datos para la tabla `log_registro`
--

INSERT INTO `log_registro` (`id_log_registro`, `fk_id_alerta`, `fk_id_usuario`, `fk_id_puesto_votacion`, `acepta`, `observacion`, `fecha_registro`, `fk_id_user_coordinador`, `nota`, `fecha_actualizacion`, `fk_id_user_actualiza`) VALUES
(1, 1, 1, 1, 1, 'Todo bajo control', '2019-09-17 21:59:01', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_registro_votos`
--

CREATE TABLE `log_registro_votos` (
  `id_log_registro_votos` int(10) NOT NULL,
  `fk_id_puesto_votos_rv` int(10) NOT NULL,
  `fk_id_mesa_rv` int(10) NOT NULL,
  `fk_id_candidato_rv` int(10) NOT NULL,
  `fk_id_usuario_rv` int(10) NOT NULL,
  `numero_votos` int(10) NOT NULL,
  `fecha_registro_votos` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `estado_mesa` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Abierta;2:Cerrada',
  `fk_id_usuario_auditor` int(10) NOT NULL,
  `estado_presidente` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Abierto 2.Iniciada 3:Cerrada',
  `estado_diputado` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Abierto 2.Iniciada 3:Cerrada',
  `foto_acta_presidente` varchar(250) NOT NULL,
  `foto_acta_diputado` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id_mesa`, `fk_puesto_votacion_mesas`, `numero_mesa`, `personas_habilitadas`, `tipo_voto`, `sumatoria_votos`, `estado_mesa`, `fk_id_usuario_auditor`, `estado_presidente`, `estado_diputado`, `foto_acta_presidente`, `foto_acta_diputado`) VALUES
(1, 1, 10001, 250, 2, 0, 1, 1, 1, 1, '', ''),
(2, 1, 10002, 120, 3, 0, 1, 1, 1, 1, '', ''),
(3, 1, 10003, 260, 1, 0, 1, 0, 1, 1, '', ''),
(4, 1, 1004, 39, 1, 0, 1, 0, 1, 1, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_divipola`
--

CREATE TABLE `param_divipola` (
  `codigo_departamento` int(10) NOT NULL,
  `nombre_departamento` varchar(150) NOT NULL,
  `codigo_provincia` int(10) NOT NULL,
  `nombre_provincia` varchar(150) NOT NULL,
  `codigo_municipio` int(10) NOT NULL,
  `nombre_municipio` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_divipola`
--

INSERT INTO `param_divipola` (`codigo_departamento`, `nombre_departamento`, `codigo_provincia`, `nombre_provincia`, `codigo_municipio`, `nombre_municipio`) VALUES
(1, 'Chuquisaca', 101, 'Oropeza', 10101, 'Sucre'),
(1, 'Chuquisaca', 101, 'Oropeza', 10102, 'Yotala'),
(1, 'Chuquisaca', 101, 'Oropeza', 10103, 'Poroma'),
(1, 'Chuquisaca', 102, 'Azurduy', 10201, 'Azurduy'),
(1, 'Chuquisaca', 102, 'Azurduy', 10202, 'Tarvita'),
(1, 'Chuquisaca', 103, 'ZudaÃ±ez', 10301, 'ZudÃ¡Ã±ez'),
(1, 'Chuquisaca', 103, 'ZudaÃ±ez', 10302, 'Presto'),
(1, 'Chuquisaca', 103, 'ZudaÃ±ez', 10303, 'Mojocoya'),
(1, 'Chuquisaca', 103, 'ZudaÃ±ez', 10304, 'Icla'),
(1, 'Chuquisaca', 104, 'Tomina', 10401, 'Padilla'),
(1, 'Chuquisaca', 104, 'Tomina', 10402, 'Tomina'),
(1, 'Chuquisaca', 104, 'Tomina', 10403, 'Sopachuy'),
(1, 'Chuquisaca', 104, 'Tomina', 10404, 'Villa AlcalÃ¡'),
(1, 'Chuquisaca', 104, 'Tomina', 10405, 'El Villar'),
(1, 'Chuquisaca', 105, 'Hernando Siles', 10501, 'Monteagudo'),
(1, 'Chuquisaca', 105, 'Hernando Siles', 10502, 'Huacareta'),
(1, 'Chuquisaca', 106, 'Yamparaez', 10601, 'Tarabuco'),
(1, 'Chuquisaca', 106, 'Yamparaez', 10602, 'Yamparaez'),
(1, 'Chuquisaca', 107, 'Nor Cinti', 10701, 'Camargo'),
(1, 'Chuquisaca', 107, 'Nor Cinti', 10702, 'San Lucas'),
(1, 'Chuquisaca', 107, 'Nor Cinti', 10703, 'Incahuasi'),
(1, 'Chuquisaca', 107, 'Nor Cinti', 10704, 'Villa Charcas'),
(1, 'Chuquisaca', 108, 'Belisario Boeto', 10801, 'Villa Serrano'),
(1, 'Chuquisaca', 109, 'Sud Cinti', 10901, 'Villa Abecia'),
(1, 'Chuquisaca', 109, 'Sud Cinti', 10902, 'Culpina'),
(1, 'Chuquisaca', 109, 'Sud Cinti', 10903, 'Las Carreras'),
(1, 'Chuquisaca', 110, 'Luis Calvo', 11001, 'Muyupampa'),
(1, 'Chuquisaca', 110, 'Luis Calvo', 11002, 'Huacaya'),
(1, 'Chuquisaca', 110, 'Luis Calvo', 11003, 'MacharetÃ­'),
(2, 'La Paz', 201, 'Murillo', 20101, 'La Paz'),
(2, 'La Paz', 201, 'Murillo', 20102, 'Palca'),
(2, 'La Paz', 201, 'Murillo', 20103, 'Mecapaca'),
(2, 'La Paz', 201, 'Murillo', 20104, 'Achocalla'),
(2, 'La Paz', 201, 'Murillo', 20105, 'El Alto'),
(2, 'La Paz', 202, 'Omasuyos', 20201, 'Achacachi'),
(2, 'La Paz', 202, 'Omasuyos', 20202, 'Ancoraimes'),
(2, 'La Paz', 202, 'Omasuyos', 20203, 'Chua Cocani'),
(2, 'La Paz', 202, 'Omasuyos', 20204, 'Huarina'),
(2, 'La Paz', 202, 'Omasuyos', 20205, 'Santiago de Huata'),
(2, 'La Paz', 202, 'Omasuyos', 20206, 'Huatajata'),
(2, 'La Paz', 203, 'Pacajes', 20301, 'Corocoro'),
(2, 'La Paz', 203, 'Pacajes', 20302, 'Caquiaviri'),
(2, 'La Paz', 203, 'Pacajes', 20303, 'Calacoto'),
(2, 'La Paz', 203, 'Pacajes', 20304, 'Comanche'),
(2, 'La Paz', 203, 'Pacajes', 20305, 'CharaÃ±a'),
(2, 'La Paz', 203, 'Pacajes', 20306, 'Waldo BalliviÃ¡n'),
(2, 'La Paz', 203, 'Pacajes', 20307, 'Nazacara de Pacajes'),
(2, 'La Paz', 203, 'Pacajes', 20308, 'Callapa'),
(2, 'La Paz', 204, 'Camacho', 20401, 'Puerto Acosta'),
(2, 'La Paz', 204, 'Camacho', 20402, 'Mocomoco'),
(2, 'La Paz', 204, 'Camacho', 20403, 'Pto. Carabuco'),
(2, 'La Paz', 204, 'Camacho', 20404, 'Humanata'),
(2, 'La Paz', 204, 'Camacho', 20405, 'Escoma'),
(2, 'La Paz', 205, 'MuÃ±ecas', 20501, 'Chuma'),
(2, 'La Paz', 205, 'MuÃ±ecas', 20502, 'Ayata'),
(2, 'La Paz', 205, 'MuÃ±ecas', 20503, 'Aucapata'),
(2, 'La Paz', 206, 'Larecaja', 20601, 'Sorata'),
(2, 'La Paz', 206, 'Larecaja', 20602, 'Guanay'),
(2, 'La Paz', 206, 'Larecaja', 20603, 'Tacacoma'),
(2, 'La Paz', 206, 'Larecaja', 20604, 'Quiabaya'),
(2, 'La Paz', 206, 'Larecaja', 20605, 'Combaya'),
(2, 'La Paz', 206, 'Larecaja', 20606, 'Tipuani'),
(2, 'La Paz', 206, 'Larecaja', 20607, 'Mapiri'),
(2, 'La Paz', 206, 'Larecaja', 20608, 'Teoponte'),
(2, 'La Paz', 207, 'Franz Tamayo', 20701, 'Apolo'),
(2, 'La Paz', 207, 'Franz Tamayo', 20702, 'Pelechuco'),
(2, 'La Paz', 208, 'Ingavi', 20801, 'Viacha'),
(2, 'La Paz', 208, 'Ingavi', 20802, 'Guaqui'),
(2, 'La Paz', 208, 'Ingavi', 20803, 'Tiahuanacu'),
(2, 'La Paz', 208, 'Ingavi', 20804, 'Desaguadero'),
(2, 'La Paz', 208, 'Ingavi', 20805, 'San AndrÃ©s de Machaca'),
(2, 'La Paz', 208, 'Ingavi', 20806, 'JesÃºs de Machaca'),
(2, 'La Paz', 208, 'Ingavi', 20807, 'Taraco'),
(2, 'La Paz', 209, 'Loayza', 20901, 'Luribay'),
(2, 'La Paz', 209, 'Loayza', 20902, 'Sapahaqui'),
(2, 'La Paz', 209, 'Loayza', 20903, 'Yaco'),
(2, 'La Paz', 209, 'Loayza', 20904, 'Malla'),
(2, 'La Paz', 209, 'Loayza', 20905, 'Cairoma'),
(2, 'La Paz', 210, 'Inquisivi', 21001, 'Inquisivi'),
(2, 'La Paz', 210, 'Inquisivi', 21002, 'Quime'),
(2, 'La Paz', 210, 'Inquisivi', 21003, 'Cajuata'),
(2, 'La Paz', 210, 'Inquisivi', 21004, 'Colquiri'),
(2, 'La Paz', 210, 'Inquisivi', 21005, 'Ichoca'),
(2, 'La Paz', 210, 'Inquisivi', 21006, 'Villa Libertad Licoma'),
(2, 'La Paz', 211, 'Sud Yungas', 21101, 'Chulumani'),
(2, 'La Paz', 211, 'Sud Yungas', 21102, 'Irupana'),
(2, 'La Paz', 211, 'Sud Yungas', 21103, 'Yanacachi'),
(2, 'La Paz', 211, 'Sud Yungas', 21104, 'Palos Blancos'),
(2, 'La Paz', 211, 'Sud Yungas', 21105, 'La Asunta'),
(2, 'La Paz', 212, 'Los Andes', 21201, 'Pucarani'),
(2, 'La Paz', 212, 'Los Andes', 21202, 'Laja'),
(2, 'La Paz', 212, 'Los Andes', 21203, 'Batallas'),
(2, 'La Paz', 212, 'Los Andes', 21204, 'Puerto PÃ©rez'),
(2, 'La Paz', 213, 'Aroma', 21301, 'Sica Sica'),
(2, 'La Paz', 213, 'Aroma', 21302, 'Umala'),
(2, 'La Paz', 213, 'Aroma', 21303, 'Ayo Ayo'),
(2, 'La Paz', 213, 'Aroma', 21304, 'Calamarca'),
(2, 'La Paz', 213, 'Aroma', 21305, 'Patacamaya'),
(2, 'La Paz', 213, 'Aroma', 21306, 'Colquencha'),
(2, 'La Paz', 213, 'Aroma', 21307, 'Collana'),
(2, 'La Paz', 214, 'Nor Yungas', 21401, 'Coroico'),
(2, 'La Paz', 214, 'Nor Yungas', 21402, 'Coripata'),
(2, 'La Paz', 215, 'Abel Iturralde', 21501, 'Ixiamas'),
(2, 'La Paz', 215, 'Abel Iturralde', 21502, 'San Buenaventura'),
(2, 'La Paz', 216, 'Bautista Saavedra', 21601, 'Charazani'),
(2, 'La Paz', 216, 'Bautista Saavedra', 21602, 'Curva'),
(2, 'La Paz', 217, 'Manco Kapac', 21701, 'Copacabana'),
(2, 'La Paz', 217, 'Manco Kapac', 21702, 'San Pedro de Tiquina'),
(2, 'La Paz', 217, 'Manco Kapac', 21703, 'Tito Yupanqui'),
(2, 'La Paz', 218, 'Gualberto Villarroel', 21801, 'San Pedro Cuarahuara'),
(2, 'La Paz', 218, 'Gualberto Villarroel', 21802, 'Papel Pampa'),
(2, 'La Paz', 218, 'Gualberto Villarroel', 21803, 'Chacarilla'),
(2, 'La Paz', 219, 'JosÃ© Manuel Pando', 21901, 'Santiago de Machaca'),
(2, 'La Paz', 219, 'JosÃ© Manuel Pando', 21902, 'Catacora'),
(2, 'La Paz', 220, 'Caranavi', 22001, 'Caranavi'),
(2, 'La Paz', 220, 'Caranavi', 22002, 'Alto Beni'),
(3, 'Cochabamba', 301, 'Cercado', 30101, 'Cochabamba'),
(3, 'Cochabamba', 302, 'Campero', 30201, 'Aiquile'),
(3, 'Cochabamba', 302, 'Campero', 30202, 'Pasorapa'),
(3, 'Cochabamba', 302, 'Campero', 30203, 'Omereque'),
(3, 'Cochabamba', 303, 'Ayopaya', 30301, 'Independencia'),
(3, 'Cochabamba', 303, 'Ayopaya', 30302, 'Morochata'),
(3, 'Cochabamba', 303, 'Ayopaya', 30303, 'Cocapata'),
(3, 'Cochabamba', 304, 'Esteban Arze', 30401, 'Tarata'),
(3, 'Cochabamba', 304, 'Esteban Arze', 30402, 'Anzaldo'),
(3, 'Cochabamba', 304, 'Esteban Arze', 30403, 'Arbieto'),
(3, 'Cochabamba', 304, 'Esteban Arze', 30404, 'Sacabamba'),
(3, 'Cochabamba', 305, 'Arani', 30501, 'Arani'),
(3, 'Cochabamba', 305, 'Arani', 30502, 'Vacas'),
(3, 'Cochabamba', 306, 'Arque', 30601, 'Arque'),
(3, 'Cochabamba', 306, 'Arque', 30602, 'Tacopaya'),
(3, 'Cochabamba', 307, 'Capinota', 30701, 'Capinota'),
(3, 'Cochabamba', 307, 'Capinota', 30702, 'SantivaÃ±ez'),
(3, 'Cochabamba', 307, 'Capinota', 30703, 'Sicaya'),
(3, 'Cochabamba', 308, 'German JordÃ¡n', 30801, 'Cliza'),
(3, 'Cochabamba', 308, 'German JordÃ¡n', 30802, 'Toco'),
(3, 'Cochabamba', 308, 'German JordÃ¡n', 30803, 'Tolata'),
(3, 'Cochabamba', 309, 'Quillacollo', 30901, 'Quillacollo'),
(3, 'Cochabamba', 309, 'Quillacollo', 30902, 'Sipesipe'),
(3, 'Cochabamba', 309, 'Quillacollo', 30903, 'Tiquipaya'),
(3, 'Cochabamba', 309, 'Quillacollo', 30904, 'Vinto'),
(3, 'Cochabamba', 309, 'Quillacollo', 30905, 'Colcapirhua'),
(3, 'Cochabamba', 310, 'Chapare', 31001, 'Sacaba'),
(3, 'Cochabamba', 310, 'Chapare', 31002, 'Colomi'),
(3, 'Cochabamba', 310, 'Chapare', 31003, 'Villa Tunari'),
(3, 'Cochabamba', 311, 'TapacarÃ­', 31101, 'TapacarÃ­'),
(3, 'Cochabamba', 312, 'Carrasco', 31201, 'Totora'),
(3, 'Cochabamba', 312, 'Carrasco', 31202, 'Pojo'),
(3, 'Cochabamba', 312, 'Carrasco', 31203, 'Pocona'),
(3, 'Cochabamba', 312, 'Carrasco', 31204, 'ChimorÃ©'),
(3, 'Cochabamba', 312, 'Carrasco', 31205, 'Puerto Villarroel'),
(3, 'Cochabamba', 312, 'Carrasco', 31206, 'Entre RÃ­os'),
(3, 'Cochabamba', 313, 'Mizque', 31301, 'Mizque'),
(3, 'Cochabamba', 313, 'Mizque', 31302, 'Vila Vila'),
(3, 'Cochabamba', 313, 'Mizque', 31303, 'Alalay'),
(3, 'Cochabamba', 314, 'Punata', 31401, 'Punata'),
(3, 'Cochabamba', 314, 'Punata', 31402, 'Villa Rivero'),
(3, 'Cochabamba', 314, 'Punata', 31403, 'San Benito'),
(3, 'Cochabamba', 314, 'Punata', 31404, 'Tacachi'),
(3, 'Cochabamba', 314, 'Punata', 31405, 'Cuchumuela'),
(3, 'Cochabamba', 315, 'BolÃ­var', 31501, 'BolÃ­var'),
(3, 'Cochabamba', 316, 'Tiraque', 31601, 'Tiraque'),
(3, 'Cochabamba', 316, 'Tiraque', 31602, 'Shinahota'),
(4, 'Oruro', 401, 'Cercado', 40101, 'Oruro'),
(4, 'Oruro', 401, 'Cercado', 40102, 'Caracollo'),
(4, 'Oruro', 401, 'Cercado', 40103, 'El Choro'),
(4, 'Oruro', 401, 'Cercado', 40104, 'Soracachi'),
(4, 'Oruro', 402, 'Abaroa', 40201, 'Challapata'),
(4, 'Oruro', 402, 'Abaroa', 40202, 'Quillacas'),
(4, 'Oruro', 403, 'Carangas', 40301, 'Corque'),
(4, 'Oruro', 403, 'Carangas', 40302, 'Choque Cota'),
(4, 'Oruro', 404, 'Sajama', 40401, 'Curahuara de Carangas'),
(4, 'Oruro', 404, 'Sajama', 40402, 'Turco'),
(4, 'Oruro', 405, 'Litoral', 40501, 'Huachacalla'),
(4, 'Oruro', 405, 'Litoral', 40502, 'Escara'),
(4, 'Oruro', 405, 'Litoral', 40503, 'Cruz de Machacamarca'),
(4, 'Oruro', 405, 'Litoral', 40504, 'Yunguyo de Litoral'),
(4, 'Oruro', 405, 'Litoral', 40505, 'Esmeralda'),
(4, 'Oruro', 406, 'Poopo', 40601, 'PoopÃ³'),
(4, 'Oruro', 406, 'Poopo', 40602, 'PazÃ±a'),
(4, 'Oruro', 406, 'Poopo', 40603, 'Antequera'),
(4, 'Oruro', 407, 'Pantaleon Dalence', 40701, 'Huanuni'),
(4, 'Oruro', 407, 'Pantaleon Dalence', 40702, 'Machacamarca'),
(4, 'Oruro', 408, 'Ladislao Cabrera', 40801, 'Salinas de GarcÃ­a Mendoza'),
(4, 'Oruro', 408, 'Ladislao Cabrera', 40802, 'Pampa Aullagas'),
(4, 'Oruro', 409, 'Sabaya', 40901, 'Sabaya'),
(4, 'Oruro', 409, 'Sabaya', 40902, 'Coipasa'),
(4, 'Oruro', 409, 'Sabaya', 40903, 'Chipaya'),
(4, 'Oruro', 410, 'Saucari', 41001, 'Toledo'),
(4, 'Oruro', 411, 'Tomas Barron', 41101, 'Eucaliptus'),
(4, 'Oruro', 412, 'Sur Carangas', 41201, 'Santiago de Andamarca'),
(4, 'Oruro', 412, 'Sur Carangas', 41202, 'BelÃ©n de Andamarca'),
(4, 'Oruro', 413, 'San Pedro de Totora', 41301, 'San Pedro de Totora'),
(4, 'Oruro', 414, 'SebastiÃ¡n Pagador', 41401, 'Huari'),
(4, 'Oruro', 415, 'Mejillones', 41501, 'La Rivera'),
(4, 'Oruro', 415, 'Mejillones', 41502, 'Todos Santos'),
(4, 'Oruro', 415, 'Mejillones', 41503, 'Carangas'),
(4, 'Oruro', 416, 'Nor Carangas', 41601, 'Huayllamarca'),
(5, 'Potosi', 501, 'Tomas Frias', 50101, 'PotosÃ­'),
(5, 'Potosi', 501, 'Tomas Frias', 50102, 'Tinguipaya'),
(5, 'Potosi', 501, 'Tomas Frias', 50103, 'Yocalla'),
(5, 'Potosi', 501, 'Tomas Frias', 50104, 'Urmiri'),
(5, 'Potosi', 502, 'Rafael Bustillo', 50201, 'UncÃ­a'),
(5, 'Potosi', 502, 'Rafael Bustillo', 50202, 'Chayanta'),
(5, 'Potosi', 502, 'Rafael Bustillo', 50203, 'Llallagua'),
(5, 'Potosi', 502, 'Rafael Bustillo', 50204, 'Chuquiuta'),
(5, 'Potosi', 503, 'Cornelio Saavedra', 50301, 'Betanzos'),
(5, 'Potosi', 503, 'Cornelio Saavedra', 50302, 'ChaquÃ­'),
(5, 'Potosi', 503, 'Cornelio Saavedra', 50303, 'Tacobamba'),
(5, 'Potosi', 504, 'Chayanta', 50401, 'Colquechaca'),
(5, 'Potosi', 504, 'Chayanta', 50402, 'Ravelo'),
(5, 'Potosi', 504, 'Chayanta', 50403, 'Pocoata'),
(5, 'Potosi', 504, 'Chayanta', 50404, 'OcurÃ­'),
(5, 'Potosi', 505, 'Charcas', 50501, 'S.P. De Buena Vista'),
(5, 'Potosi', 505, 'Charcas', 50502, 'Toro Toro'),
(5, 'Potosi', 506, 'Nor Chichas', 50601, 'Cotagaita'),
(5, 'Potosi', 506, 'Nor Chichas', 50602, 'Vitichi'),
(5, 'Potosi', 507, 'Alonso de IbaÃ±ez', 50701, 'Villa de Sacaca'),
(5, 'Potosi', 507, 'Alonso de IbaÃ±ez', 50702, 'Caripuyo'),
(5, 'Potosi', 508, 'Sur Chichas', 50801, 'Tupiza'),
(5, 'Potosi', 508, 'Sur Chichas', 50802, 'Atocha'),
(5, 'Potosi', 509, 'Nor LÃ­pez', 50901, '"Colcha ""K"""'),
(5, 'Potosi', 509, 'Nor LÃ­pez', 50902, 'San Pedro de Quemes'),
(5, 'Potosi', 510, 'Sur LÃ­pez', 51001, 'San Pablo de Lipez'),
(5, 'Potosi', 510, 'Sur LÃ­pez', 51002, 'Mojinete'),
(5, 'Potosi', 510, 'Sur LÃ­pez', 51003, 'San Antonio de Esmoruco'),
(5, 'Potosi', 511, 'JosÃ© Maria Linares', 51101, 'Puna'),
(5, 'Potosi', 511, 'JosÃ© Maria Linares', 51102, '"Caiza ""D"""'),
(5, 'Potosi', 511, 'JosÃ© Maria Linares', 51103, 'Ckochas'),
(5, 'Potosi', 512, 'Antonio Quijarro', 51201, 'Uyuni'),
(5, 'Potosi', 512, 'Antonio Quijarro', 51202, 'Tomave'),
(5, 'Potosi', 512, 'Antonio Quijarro', 51203, 'Porco'),
(5, 'Potosi', 513, 'Bernardino Bilbao Rioja', 51301, 'Arampampa'),
(5, 'Potosi', 513, 'Bernardino Bilbao Rioja', 51302, 'Acasio'),
(5, 'Potosi', 514, 'Daniel Campos', 51401, 'Llica'),
(5, 'Potosi', 514, 'Daniel Campos', 51402, 'Tahua'),
(5, 'Potosi', 515, 'Modesto Omiste', 51501, 'VillazÃ³n'),
(5, 'Potosi', 516, 'Enrique Baldivieso', 51601, 'San AgustÃ­n'),
(6, 'Tarija', 601, 'Cercado', 60101, 'Tarija'),
(6, 'Tarija', 602, 'Aniceto Arce', 60201, 'Padcaya'),
(6, 'Tarija', 602, 'Aniceto Arce', 60202, 'Bermejo'),
(6, 'Tarija', 603, 'Gran Chaco', 60301, 'Yacuiba'),
(6, 'Tarija', 603, 'Gran Chaco', 60302, 'CaraparÃ­'),
(6, 'Tarija', 603, 'Gran Chaco', 60303, 'Villamontes'),
(6, 'Tarija', 604, 'Aviles', 60401, 'Uriondo'),
(6, 'Tarija', 604, 'Aviles', 60402, 'YuncharÃ¡'),
(6, 'Tarija', 605, 'MÃ©ndez', 60501, 'Villa San Lorenzo'),
(6, 'Tarija', 605, 'MÃ©ndez', 60502, 'El Puente'),
(6, 'Tarija', 606, 'Burnet Oconnor', 60601, 'Entre RÃ­os'),
(7, 'Santa Cruz', 701, 'AndrÃ©s IbaÃ±ez', 70101, 'Santa Cruz de la Sierra'),
(7, 'Santa Cruz', 701, 'AndrÃ©s IbaÃ±ez', 70102, 'Cotoca'),
(7, 'Santa Cruz', 701, 'AndrÃ©s IbaÃ±ez', 70103, 'Porongo'),
(7, 'Santa Cruz', 701, 'AndrÃ©s IbaÃ±ez', 70104, 'La Guardia'),
(7, 'Santa Cruz', 701, 'AndrÃ©s IbaÃ±ez', 70105, 'El Torno'),
(7, 'Santa Cruz', 702, 'Warnes', 70201, 'Warnes'),
(7, 'Santa Cruz', 702, 'Warnes', 70202, 'Okinawa Uno'),
(7, 'Santa Cruz', 703, 'Velasco', 70301, 'San Ignacio de Velasco'),
(7, 'Santa Cruz', 703, 'Velasco', 70302, 'San Miguel de Velasco'),
(7, 'Santa Cruz', 703, 'Velasco', 70303, 'San Rafael'),
(7, 'Santa Cruz', 704, 'Ichilo', 70401, 'Buena Vista'),
(7, 'Santa Cruz', 704, 'Ichilo', 70402, 'San Carlos'),
(7, 'Santa Cruz', 704, 'Ichilo', 70403, 'YapacanÃ­'),
(7, 'Santa Cruz', 704, 'Ichilo', 70404, 'San Juan de YapacanÃ­'),
(7, 'Santa Cruz', 705, 'Chiquitos', 70501, 'San JosÃ© de Chiquitos'),
(7, 'Santa Cruz', 705, 'Chiquitos', 70502, 'PailÃ³n'),
(7, 'Santa Cruz', 705, 'Chiquitos', 70503, 'RoborÃ©'),
(7, 'Santa Cruz', 706, 'Sara', 70601, 'Portachuelo'),
(7, 'Santa Cruz', 706, 'Sara', 70602, 'Santa Rosa del Sara'),
(7, 'Santa Cruz', 706, 'Sara', 70603, 'Colpa Belgica'),
(7, 'Santa Cruz', 707, 'Cordillera', 70701, 'Lagunillas'),
(7, 'Santa Cruz', 707, 'Cordillera', 70702, 'Charagua'),
(7, 'Santa Cruz', 707, 'Cordillera', 70703, 'Cabezas'),
(7, 'Santa Cruz', 707, 'Cordillera', 70704, 'Cuevo'),
(7, 'Santa Cruz', 707, 'Cordillera', 70705, 'GutiÃ©rrez'),
(7, 'Santa Cruz', 707, 'Cordillera', 70706, 'Camiri'),
(7, 'Santa Cruz', 707, 'Cordillera', 70707, 'Boyuibe'),
(7, 'Santa Cruz', 708, 'Vallegrande', 70801, 'Vallegrande'),
(7, 'Santa Cruz', 708, 'Vallegrande', 70802, 'Trigal'),
(7, 'Santa Cruz', 708, 'Vallegrande', 70803, 'Moro Moro'),
(7, 'Santa Cruz', 708, 'Vallegrande', 70804, 'Postrer Valle'),
(7, 'Santa Cruz', 708, 'Vallegrande', 70805, 'Pucara'),
(7, 'Santa Cruz', 709, 'Florida', 70901, 'Samaipata'),
(7, 'Santa Cruz', 709, 'Florida', 70902, 'Pampa Grande'),
(7, 'Santa Cruz', 709, 'Florida', 70903, 'Mairana'),
(7, 'Santa Cruz', 709, 'Florida', 70904, 'Quirusillas'),
(7, 'Santa Cruz', 710, 'Obispo Santiestevan', 71001, 'Montero'),
(7, 'Santa Cruz', 710, 'Obispo Santiestevan', 71002, 'Gral. Saavedra'),
(7, 'Santa Cruz', 710, 'Obispo Santiestevan', 71003, 'Mineros'),
(7, 'Santa Cruz', 710, 'Obispo Santiestevan', 71004, 'FernÃ¡ndez Alonso'),
(7, 'Santa Cruz', 710, 'Obispo Santiestevan', 71005, 'San Pedro'),
(7, 'Santa Cruz', 711, 'Ã‘uflo de ChÃ¡vez', 71101, 'ConcepciÃ³n'),
(7, 'Santa Cruz', 711, 'Ã‘uflo de ChÃ¡vez', 71102, 'San Javier'),
(7, 'Santa Cruz', 711, 'Ã‘uflo de ChÃ¡vez', 71103, 'San RamÃ³n'),
(7, 'Santa Cruz', 711, 'Ã‘uflo de ChÃ¡vez', 71104, 'San JuliÃ¡n'),
(7, 'Santa Cruz', 711, 'Ã‘uflo de ChÃ¡vez', 71105, 'San Antonio de LomerÃ­o'),
(7, 'Santa Cruz', 711, 'Ã‘uflo de ChÃ¡vez', 71106, 'Cuatro CaÃ±adas'),
(7, 'Santa Cruz', 712, 'Angel Sandoval', 71201, 'San MatÃ­as'),
(7, 'Santa Cruz', 713, 'Manuel Maria Caballero', 71301, 'Comarapa'),
(7, 'Santa Cruz', 713, 'Manuel Maria Caballero', 71302, 'Saipina'),
(7, 'Santa Cruz', 714, 'German Busch', 71401, 'Puerto Suarez'),
(7, 'Santa Cruz', 714, 'German Busch', 71402, 'Puerto Quijarro'),
(7, 'Santa Cruz', 714, 'German Busch', 71403, 'Carmen Rivero Torrez'),
(7, 'Santa Cruz', 715, 'Guarayos', 71501, 'AscensiÃ³n de Guarayos'),
(7, 'Santa Cruz', 715, 'Guarayos', 71502, 'UrubichÃ¡'),
(7, 'Santa Cruz', 715, 'Guarayos', 71503, 'El Puente'),
(8, 'Beni', 801, 'Cercado', 80101, 'Trinidad'),
(8, 'Beni', 801, 'Cercado', 80102, 'San Javier'),
(8, 'Beni', 802, 'Vaca Diez', 80201, 'Riberalta'),
(8, 'Beni', 802, 'Vaca Diez', 80202, 'GuayaramerÃ­n'),
(8, 'Beni', 803, 'JosÃ© BalliviÃ¡n', 80301, 'Reyes'),
(8, 'Beni', 803, 'JosÃ© BalliviÃ¡n', 80302, 'San Borja'),
(8, 'Beni', 803, 'JosÃ© BalliviÃ¡n', 80303, 'Santa Rosa'),
(8, 'Beni', 803, 'JosÃ© BalliviÃ¡n', 80304, 'Rurrenabaque'),
(8, 'Beni', 804, 'Yacuma', 80401, 'Santa Ana de Yacuma'),
(8, 'Beni', 804, 'Yacuma', 80402, 'ExaltaciÃ³n'),
(8, 'Beni', 805, 'Moxos', 80501, 'San Ignacio'),
(8, 'Beni', 806, 'Marban', 80601, 'Loreto'),
(8, 'Beni', 806, 'Marban', 80602, 'San AndrÃ©s'),
(8, 'Beni', 807, 'Mamore', 80701, 'San JoaquÃ­n'),
(8, 'Beni', 807, 'Mamore', 80702, 'San RamÃ³n'),
(8, 'Beni', 807, 'Mamore', 80703, 'Puerto Siles'),
(8, 'Beni', 808, 'Itenez', 80801, 'Magdalena'),
(8, 'Beni', 808, 'Itenez', 80802, 'Baures'),
(8, 'Beni', 808, 'Itenez', 80803, 'Huacaraje'),
(9, 'Pando', 901, 'NicolÃ¡s SuÃ¡rez', 90101, 'Cobija'),
(9, 'Pando', 901, 'NicolÃ¡s SuÃ¡rez', 90102, 'Porvenir'),
(9, 'Pando', 901, 'NicolÃ¡s SuÃ¡rez', 90103, 'Bolpebra'),
(9, 'Pando', 901, 'NicolÃ¡s SuÃ¡rez', 90104, 'Bella Flor'),
(9, 'Pando', 902, 'Manuripi', 90201, 'Puerto Rico'),
(9, 'Pando', 902, 'Manuripi', 90202, 'San Pedro'),
(9, 'Pando', 902, 'Manuripi', 90203, 'Filadelfia'),
(9, 'Pando', 903, 'Madre de Dios', 90301, 'Puerto Gonzales Moreno'),
(9, 'Pando', 903, 'Madre de Dios', 90302, 'San Lorenzo'),
(9, 'Pando', 903, 'Madre de Dios', 90303, 'Sena'),
(9, 'Pando', 904, 'Abuna', 90401, 'Santa Rosa'),
(9, 'Pando', 904, 'Abuna', 90402, 'Ingavi'),
(9, 'Pando', 905, 'Federico RomÃ¡n', 90501, 'Nueva Esperanza'),
(9, 'Pando', 905, 'Federico RomÃ¡n', 90502, 'Villa Nueva (Loma Alta)'),
(9, 'Pando', 905, 'Federico RomÃ¡n', 90503, 'Santos Mercado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_general`
--

CREATE TABLE `param_general` (
  `id_param_general` int(10) NOT NULL,
  `fecha_elecciones` date NOT NULL,
  `hora_inicio` varchar(10) NOT NULL,
  `hora_fin` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_general`
--

INSERT INTO `param_general` (`id_param_general`, `fecha_elecciones`, `hora_inicio`, `hora_fin`) VALUES
(1, '2019-09-19', '07:30', '15:00');

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
-- Estructura de tabla para la tabla `pruebas`
--

CREATE TABLE `pruebas` (
  `id_prueba` int(10) NOT NULL,
  `mensaje` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pruebas`
--

INSERT INTO `pruebas` (`id_prueba`, `mensaje`) VALUES
(1, 'pruebaassss'),
(2, '{"table":"pruebas","order":"nombre_tipo_alerta","id":"x"}'),
(3, '"que pasa calabaza"'),
(4, '"que pasa calabaza"'),
(5, '"que pasa calabaza"'),
(6, '"estas%20son%20mas%20pruebas"');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto_votacion`
--

CREATE TABLE `puesto_votacion` (
  `id_puesto_votacion` int(10) NOT NULL,
  `fk_id_departamento` int(10) NOT NULL,
  `fk_id_municipio` int(10) NOT NULL,
  `id_localidad` int(10) NOT NULL,
  `nombre_localidad` varchar(150) NOT NULL,
  `circunscripcion` varchar(100) NOT NULL,
  `numero_puesto_votacion` int(10) NOT NULL,
  `nombre_puesto_votacion` varchar(150) NOT NULL,
  `total_mesas` int(1) NOT NULL,
  `total_personas_habilitadas` int(10) NOT NULL,
  `latitud` varchar(200) NOT NULL,
  `longitud` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `puesto_votacion`
--

INSERT INTO `puesto_votacion` (`id_puesto_votacion`, `fk_id_departamento`, `fk_id_municipio`, `id_localidad`, `nombre_localidad`, `circunscripcion`, `numero_puesto_votacion`, `nombre_puesto_votacion`, `total_mesas`, `total_personas_habilitadas`, `latitud`, `longitud`) VALUES
(1, 8, 80802, 10, 'Principal', 'nose', 10001, 'Puesto de votación 1', 25, 0, '2343', '79878'),
(2, 1, 10201, 17, 'Central', 'otro dato', 2001, 'PUESTO DE VOTACIÓN 2', 12, 0, '234234', '23452345'),
(3, 3, 30501, 45, 'nueva localidad', 'dato circuns', 3001, 'Puesto de votación 3', 36, 0, '3245234', '2345234'),
(4, 2, 20701, 457, 'nueva', 'circunscripcion', 40001, 'PUESTO DE VOTACIÓN 4', 7, 0, '70808767', '876876');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `id_registro` int(10) NOT NULL,
  `fk_id_alerta` int(10) NOT NULL,
  `fk_id_usuario_r` int(10) NOT NULL,
  `fk_id_puesto_votacion_r` int(10) NOT NULL,
  `acepta` int(1) NOT NULL COMMENT '1: Acepta; 2: NO acepta',
  `observacion` text,
  `fecha_registro` datetime NOT NULL,
  `fk_id_user_coordinador` int(10) DEFAULT NULL,
  `nota` varchar(250) DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `fk_id_user_actualiza` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`id_registro`, `fk_id_alerta`, `fk_id_usuario_r`, `fk_id_puesto_votacion_r`, `acepta`, `observacion`, `fecha_registro`, `fk_id_user_coordinador`, `nota`, `fecha_actualizacion`, `fk_id_user_actualiza`) VALUES
(1, 1, 1, 1, 1, 'Todo bajo control', '2019-09-17 21:59:01', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_votos`
--

CREATE TABLE `registro_votos` (
  `id_registro_votos` int(10) NOT NULL,
  `fk_id_puesto_votos_rv` int(10) NOT NULL,
  `fk_id_mesa_rv` int(10) NOT NULL,
  `fk_id_candidato_rv` int(10) NOT NULL,
  `fk_id_usuario_rv` int(10) NOT NULL,
  `numero_votos` int(10) NOT NULL,
  `fecha_registro_votos` datetime NOT NULL
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
(1, 12645615, '1', 'AUDITOR', 'APP', '3347766asdfa', '403408992123', 'sinemail@sinemail.com', NULL, '', 'Pepito', '345234', 2, 12645615, 'ce5dbff68c1cb46e1dbf45eb6736ddc2', '12645615', 2, 1),
(2, 79757228, '1', 'ADMINISTRADOR', 'APP', '', '300 275 44 7', 'jelozanoo@gmail.com', NULL, NULL, '', '', NULL, 79757228, '7b544b82d84f041224ca43f597bfc6c9', '79757228', 1, 1);

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
-- Indices de la tabla `log_registro`
--
ALTER TABLE `log_registro`
  ADD PRIMARY KEY (`id_log_registro`),
  ADD KEY `fk_id_alerta` (`fk_id_alerta`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`),
  ADD KEY `fk_id_puesto_votacion` (`fk_id_puesto_votacion`),
  ADD KEY `fk_id_user_coordinador` (`fk_id_user_coordinador`),
  ADD KEY `acepta` (`acepta`),
  ADD KEY `fk_id_user_actualiza` (`fk_id_user_actualiza`);

--
-- Indices de la tabla `log_registro_votos`
--
ALTER TABLE `log_registro_votos`
  ADD PRIMARY KEY (`id_log_registro_votos`),
  ADD KEY `fk_id_puesto_votos_rv` (`fk_id_puesto_votos_rv`),
  ADD KEY `fk_id_mesa_rv` (`fk_id_mesa_rv`),
  ADD KEY `fk_id_candidato_rv` (`fk_id_candidato_rv`),
  ADD KEY `fk_id_usuario_rv` (`fk_id_usuario_rv`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `fk_id_puesto_votacion` (`fk_puesto_votacion_mesas`),
  ADD KEY `fk_id_usuario_auditor` (`fk_id_usuario_auditor`);

--
-- Indices de la tabla `param_divipola`
--
ALTER TABLE `param_divipola`
  ADD PRIMARY KEY (`codigo_municipio`),
  ADD KEY `codigo_departamento` (`codigo_departamento`),
  ADD KEY `codigo_provincia` (`codigo_provincia`);

--
-- Indices de la tabla `param_general`
--
ALTER TABLE `param_general`
  ADD PRIMARY KEY (`id_param_general`);

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
-- Indices de la tabla `pruebas`
--
ALTER TABLE `pruebas`
  ADD PRIMARY KEY (`id_prueba`);

--
-- Indices de la tabla `puesto_votacion`
--
ALTER TABLE `puesto_votacion`
  ADD PRIMARY KEY (`id_puesto_votacion`),
  ADD KEY `fk_id_departamento` (`fk_id_departamento`),
  ADD KEY `fk_id_municipio` (`fk_id_municipio`),
  ADD KEY `id_localidad` (`id_localidad`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `fk_id_alerta` (`fk_id_alerta`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario_r`),
  ADD KEY `fk_id_puesto_votacion` (`fk_id_puesto_votacion_r`),
  ADD KEY `fk_id_user_coordinador` (`fk_id_user_coordinador`),
  ADD KEY `acepta` (`acepta`),
  ADD KEY `fk_id_user_actualiza` (`fk_id_user_actualiza`);

--
-- Indices de la tabla `registro_votos`
--
ALTER TABLE `registro_votos`
  ADD PRIMARY KEY (`id_registro_votos`),
  ADD KEY `fk_id_puesto_votos_rv` (`fk_id_puesto_votos_rv`),
  ADD KEY `fk_id_mesa_rv` (`fk_id_mesa_rv`),
  ADD KEY `fk_id_candidato_rv` (`fk_id_candidato_rv`),
  ADD KEY `fk_id_usuario_rv` (`fk_id_usuario_rv`);

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
  MODIFY `id_candidato` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
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
-- AUTO_INCREMENT de la tabla `log_registro`
--
ALTER TABLE `log_registro`
  MODIFY `id_log_registro` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `log_registro_votos`
--
ALTER TABLE `log_registro_votos`
  MODIFY `id_log_registro_votos` int(10) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT de la tabla `pruebas`
--
ALTER TABLE `pruebas`
  MODIFY `id_prueba` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `puesto_votacion`
--
ALTER TABLE `puesto_votacion`
  MODIFY `id_puesto_votacion` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `id_registro` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `registro_votos`
--
ALTER TABLE `registro_votos`
  MODIFY `id_registro_votos` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `candidatos`
--
ALTER TABLE `candidatos`
  ADD CONSTRAINT `candidatos_ibfk_1` FOREIGN KEY (`fk_id_corporacion`) REFERENCES `corporacion` (`id_corporacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `candidatos_ibfk_2` FOREIGN KEY (`fk_id_partido`) REFERENCES `partidos` (`id_partido`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Filtros para la tabla `puesto_votacion`
--
ALTER TABLE `puesto_votacion`
  ADD CONSTRAINT `puesto_votacion_ibfk_1` FOREIGN KEY (`fk_id_municipio`) REFERENCES `param_divipola` (`codigo_municipio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `registro`
--
ALTER TABLE `registro`
  ADD CONSTRAINT `registro_ibfk_1` FOREIGN KEY (`fk_id_puesto_votacion_r`) REFERENCES `puesto_votacion` (`id_puesto_votacion`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
