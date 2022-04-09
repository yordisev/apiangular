-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.22-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para apifunciones
CREATE DATABASE IF NOT EXISTS `apifunciones` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `apifunciones`;

-- Volcando estructura para tabla apifunciones.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_doc` varchar(50) DEFAULT NULL,
  `numero_doc` int(11) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `estado` varchar(60) DEFAULT 'A',
  `fecha_registro` timestamp NULL DEFAULT NULL,
  `editado` datetime DEFAULT NULL,
  `nivel` int(11) DEFAULT 1,
  PRIMARY KEY (`id_admin`) USING BTREE,
  UNIQUE KEY `usuario` (`usuario`) USING BTREE,
  UNIQUE KEY `numero_doc` (`numero_doc`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla apifunciones.usuarios: 5 rows
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id_admin`, `tipo_doc`, `numero_doc`, `usuario`, `nombres`, `apellidos`, `password`, `estado`, `fecha_registro`, `editado`, `nivel`) VALUES
	(3, 'CC', 123, 'dairo@mail.com', 'Dairo Rafael', 'Barrios Ramos', '$2y$12$nuYWSX12NkjZ99T35a0KnudJKyM7d.7o9u4pXTz2vElQuYQlBWHUq', 'A', NULL, NULL, NULL),
	(5, 'CC', 123456, 'yordis@redes.com', 'Yordis', 'Escorcia', '$2y$12$5keXTBZQhRWC9RddHhs/IOTeVGaqFbXD6zKCmsYxi3ODDUCZulh9W', 'A', NULL, NULL, 1),
	(6, 'CC', 987654, 'regina@redes.com', 'Regina', 'TRILLO', '$2y$12$m4.0dxzziVQ/TKQieH/AQePdWaypEOsU2P15SaYdfBCF7wFPyI5Y2', 'A', NULL, NULL, 3),
	(7, 'CC', 12345, 'carlos@redes.com', 'Carlos', 'freile', '$2y$12$V3HzV4Hp3Df3BkN2cPTrzeSsIgBOUh55gm9anksmrd./3dx.g494S', 'A', NULL, NULL, 2),
	(11, 'cc', 123123123, 'yordis', 'Andres Escorcia', 'Escoriciais', '$2y$12$WkHm8sntWQFJ5feI2oBKV.FTWIvyFsY13xdk3NyTrPx', 'A', NULL, NULL, 1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla apifunciones.usuarios_token
CREATE TABLE IF NOT EXISTS `usuarios_token` (
  `TokenId` int(11) NOT NULL AUTO_INCREMENT,
  `UsuarioId` varchar(45) DEFAULT NULL,
  `Token` varchar(250) DEFAULT NULL,
  `Estado` varchar(45) CHARACTER SET armscii8 DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`TokenId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla apifunciones.usuarios_token: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios_token` DISABLE KEYS */;
INSERT INTO `usuarios_token` (`TokenId`, `UsuarioId`, `Token`, `Estado`, `Fecha`) VALUES
	(6, '1', 'e78819629982106e3496746c3e05283e', 'Activo', '2021-09-27 20:19:00'),
	(7, '1', 'b32c8e50a30df2cdec22c5ef8510574d', 'Activo', '2021-09-28 15:44:00'),
	(8, '6', 'e02ba4b575db4b5a5e2f-b9576306575445656701-1da8c43144db3b7fa206-6cddbbb4472d97de784c', 'Activo', '2021-09-28 21:53:00'),
	(9, '3', '0e363585677c27dc0fd1-a00b0a53a14b51939700-ab6937d3aca028a457be-6bc15a98ab0677e39e42', 'Activo', '2021-09-29 19:06:00'),
	(11, '1', '4c4f4affd58d4f28e9f6-000472107329c4c62110-24d5e473d5133c7edc2d-84212a8f145fd3650ba9', 'Activo', '2021-12-25 01:01:00'),
	(84, '14', 'c9ba8b3cd5bdb8bd14a3-58c2c3508bdf42bfaa25-08c86b1c4e80731c53cb-1e29675a29c36e3123ab', 'Activo', '2022-02-20 21:34:00');
/*!40000 ALTER TABLE `usuarios_token` ENABLE KEYS */;

-- Volcando estructura para procedimiento apifunciones.actualizarusuario
DELIMITER //
CREATE PROCEDURE `actualizarusuario`(
	IN `v_tipo_doc` VARCHAR(50),
	IN `v_nombres` VARCHAR(50),
	IN `v_apellidos` VARCHAR(50),
	IN `v_usuario` VARCHAR(50),
	IN `v_nivel` VARCHAR(50),
	IN `v_numero_doc` VARCHAR(50)
)
BEGIN
		DECLARE existe_usuario INT;
		DECLARE salida VARCHAR(30);
		set existe_usuario = (SELECT count(*) from usuarios where numero_doc = v_numero_doc);
		if existe_usuario  > 0 then
				update usuarios set tipo_doc = v_tipo_doc,nombres = v_nombres,apellidos = v_apellidos,usuario = v_usuario 
				where numero_doc = v_numero_doc;
				set salida = v_numero_doc;
		else
			set salida = 'Usuario no existe';
		end if;
		select salida;
END//
DELIMITER ;

-- Volcando estructura para procedimiento apifunciones.buscarusuario
DELIMITER //
CREATE PROCEDURE `buscarusuario`(
	IN `v_busqueda` VARCHAR(50)
)
BEGIN
	SELECT 'id_usuario',u.id_admin, 'tipo_documento',u.tipo_doc, 'numero',u.numero_doc, 'usuario',u.usuario,
	'nombres',u.nombres,'apellidos',u.apellidos,'estado',u.estado,'nivel',u.nivel from usuarios u where
		(u.numero_doc LIKE CONCAT('%',v_busqueda,'%') or
		u.usuario LIKE CONCAT('%',v_busqueda,'%') or
		u.nombres LIKE CONCAT('%',v_busqueda,'%') or
		u.apellidos LIKE CONCAT('%',v_busqueda,'%'))
		and
		u.estado = 'A';
END//
DELIMITER ;

-- Volcando estructura para procedimiento apifunciones.buscarusuarios
DELIMITER //
CREATE PROCEDURE `buscarusuarios`()
BEGIN
	SELECT u.id_admin,u.tipo_doc,u.numero_doc,u.usuario,
	u.nombres,u.apellidos,u.estado,u.nivel from usuarios u;
END//
DELIMITER ;

-- Volcando estructura para procedimiento apifunciones.insertarusuario
DELIMITER //
CREATE PROCEDURE `insertarusuario`(
	IN `v_tipo_documento` VARCHAR(50),
	IN `v_numero` VARCHAR(50),
	IN `v_usuario` VARCHAR(50),
	IN `v_nombres` VARCHAR(50),
	IN `v_apellidos` VARCHAR(50),
	IN `v_password` VARCHAR(50),
	IN `v_nivel` VARCHAR(50)
)
BEGIN
declare existe_usuario INT;
		DECLARE id INT;
		set existe_usuario = (SELECT count(*) from usuarios where usuario = v_usuario);
		if existe_usuario  = 0 then
			INSERT INTO usuarios (tipo_doc,numero_doc, usuario, nombres,apellidos,password,nivel) 
			VALUES (v_tipo_documento,v_numero,v_usuario,v_nombres,v_apellidos,v_password,v_nivel);
			SET id = last_insert_id();
		else
			set id = 0;
		end if;
		select id;

END//
DELIMITER ;

-- Volcando estructura para procedimiento apifunciones.seleccionarusuario
DELIMITER //
CREATE PROCEDURE `seleccionarusuario`(
	IN `v_id_usuario` VARCHAR(50)
)
BEGIN
-- SELECT id_admin, tipo_doc, numero_doc, usuario, nombres, apellidos, nivel, estado FROM usuarios WHERE id_admin = v_id_usuario;

SELECT JSON_ARRAY(JSON_OBJECT('nombres', nombres, 'apellidos', apellidos)) from usuarios WHERE id_admin = v_id_usuario;
END//
DELIMITER ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
