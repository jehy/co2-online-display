CREATE TABLE `data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL,
  `sensor_id` int(11) unsigned NOT NULL,
  `ppm` int(10) unsigned DEFAULT NULL,
  `ssid` varchar(200) NOT NULL,
  `ram` int(10) unsigned DEFAULT NULL,
  `temp` int(10) unsigned DEFAULT NULL,
  `humidity` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE INDEX added ON data(added);
