
CREATE TABLE `#__fieldsattachsearch_layout` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `fields` text NOT NULL,
  `catids` varchar(255) NOT NULL,
  `ordering` varchar(50) NOT NULL,
  `limit` int(11) NOT NULL,
  `templateform` text NOT NULL,
  `templatestate` tinyint(1) NOT NULL COMMENT '0- automatic | 1 - Manual',
  `templatejavascript` text NOT NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;