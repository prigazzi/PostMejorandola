-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 09-02-2012 a las 13:01:42
-- Versión del servidor: 5.1.49
-- Versión de PHP: 5.3.3-1ubuntu9.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bancodeideas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ideas`
--

CREATE TABLE IF NOT EXISTS `Ideas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idea` text NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `votos` int(11) NOT NULL,
  `aprobada` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
