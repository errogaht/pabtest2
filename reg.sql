CREATE TABLE `ri_pregs` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` varchar(16) DEFAULT NULL,
  `addt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fio` varchar(255) NOT NULL DEFAULT '',
  `bdt` varchar(32) DEFAULT NULL,
  `gender` char(1) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `skype` varchar(32) NOT NULL DEFAULT '',
  `subjs` text NOT NULL,
  `edu` text NOT NULL,
  `edu2` text NOT NULL,
  `exams` text NOT NULL,
  `exp1` text NOT NULL,
  `exp2` text NOT NULL,
  `wprc` text NOT NULL,
  `rasp` text NOT NULL,
  `mmtr` text NOT NULL,
  `mreg` text NOT NULL,
  `ugc1` text NOT NULL,
  `wishes` text NOT NULL,
  `comments` text NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT '',
  `kfrom` tinyint(4) NOT NULL DEFAULT '0',
  `oferta` int(11) NOT NULL,
  `oferta_ver` tinyint(4) NOT NULL,
  `teste` tinyint(4) NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `doreg` tinyint(4) NOT NULL,
  `chkby` int(11) NOT NULL DEFAULT '0',
  `prep_id` varchar(32) NOT NULL DEFAULT '',
  `obv` varchar(255) NOT NULL DEFAULT '',
  `fnd` int(11) NOT NULL DEFAULT '0',
  `prr` varchar(32) NOT NULL,
  `clb` tinyint(4) NOT NULL,
  `site_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=584267 DEFAULT CHARSET=cp1251 ROW_FORMAT=COMPACT;