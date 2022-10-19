CREATE TABLE IF NOT EXISTS `expenses_justification_settings` (
  `setting_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `setting_name` (`setting_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; #

CREATE TABLE IF NOT EXISTS `expenses_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` text COLLATE utf8_unicode_ci NOT NULL,
  `profileid` int NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `comments` text COLLATE utf8_unicode_ci,
  `type` text COLLATE utf8_unicode_ci,
  `status` text COLLATE utf8_unicode_ci,
  `data` text COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ; #
