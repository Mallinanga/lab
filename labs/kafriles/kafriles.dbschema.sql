CREATE TABLE `kafriles` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `header` text,
  `body` text,
  `timeGenerated` date default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=1 ;
