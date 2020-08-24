CREATE TABLE IF NOT EXISTS `clientes` (
  `nif` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria',
  `nombre` varchar(50) NOT NULL COMMENT 'nombre cliente',
  `apellidos` varchar(100) NOT NULL COMMENT 'Apellidos cliente',
  `telefono` int(9) NOT NULL COMMENT 'móvil',
  `edad` int(3) DEFAULT NULL,
  PRIMARY KEY (`nif`),
  UNIQUE KEY `telefono` (`telefono`),
  KEY `nombre` (`nombre`),
  FULLTEXT KEY `apellidos` (`apellidos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabla de clientes';


INSERT INTO clientes (nombre,apellidos,telefono,edad) VALUES ('Elber','A A','1114413','18');
INSERT INTO clientes (nombre,apellidos,telefono,edad) VALUES ('Elisa','A A','1214441','12'); 


SELECT * FROM `base`.`clientes` LIMIT 1000;
