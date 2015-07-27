CREATE TABLE `navigation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `when` varchar(100) DEFAULT NULL,
  `get` tinyint(4) DEFAULT NULL,
  `post` tinyint(4) DEFAULT NULL,
  `controller` varchar(40) DEFAULT NULL,
  `controllerParams` varchar(200) DEFAULT NULL,
  `view` varchar(40) DEFAULT NULL,
  `viewParams` varchar(200) DEFAULT NULL,
  `parent` int(10) unsigned DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `title` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
