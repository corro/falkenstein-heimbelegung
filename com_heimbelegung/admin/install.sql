DROP TABLE IF EXISTS `#__belegung_info`;
DROP TABLE IF EXISTS `#__belegung`;

CREATE TABLE `#__belegung_info` (
  `aktualisiert` datetime NULL
);

CREATE TABLE `#__belegung` (
  `id` int NOT NULL AUTO_INCREMENT,
  `von` date NOT NULL,
  `bis` date NOT NULL,
  `vonTageszeit` char NOT NULL,
  `bisTageszeit` char NOT NULL,
  `heim` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `#__belegung_info` (aktualisiert)
VALUES (NOW());