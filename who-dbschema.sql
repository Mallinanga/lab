--
-- Table structure for table `tz_who_is_online`
--

CREATE TABLE `tz_who_is_online` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ip` int(11) NOT NULL default '0',
  `country` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `countrycode` varchar(2) collate utf8_unicode_ci NOT NULL default '',
  `city` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `dt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `countrycode` (`countrycode`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;