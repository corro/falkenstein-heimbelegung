DROP TABLE IF EXISTS `#__belegung_info`;
DROP TABLE IF EXISTS `#__belegung`;
DROP TABLE IF EXISTS `#__belegung_heime`;

CREATE TABLE `#__belegung_info` (
  `aktualisiert` date NULL
);

CREATE TABLE `#__belegung_heime` (
  `heim` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`heim`)
);

CREATE TABLE `#__belegung` (
  `id` int NOT NULL AUTO_INCREMENT,
  `von` date NOT NULL,
  `bis` date NOT NULL,
  `vonTageszeit` char NOT NULL,
  `bisTageszeit` char NOT NULL,
  `heim` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`heim`) REFERENCES #__belegung_heime(heim) ON DELETE CASCADE
);

INSERT INTO `#__belegung_heime` (heim, name)
VALUES ('buschi', 'Büschiheim');

INSERT INTO `#__belegung_heime` (heim, name)
VALUES ('weiermatt', 'Weiermattheim');

INSERT INTO `#__belegung` (von, bis, vonTageszeit, bisTageszeit, heim)
VALUES ('2010-07-26', '2010-07-31', 'N', 'V', 'buschi');

INSERT INTO `#__belegung` (von, bis, vonTageszeit, bisTageszeit, heim)
VALUES ('2010-06-28', '2010-07-8', 'B', 'B', 'weiermatt');