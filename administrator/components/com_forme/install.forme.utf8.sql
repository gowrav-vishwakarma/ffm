CREATE TABLE IF NOT EXISTS `#__forme_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(64) NOT NULL DEFAULT '',
  `setting_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__forme_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uip` varchar(15) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__forme_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `fieldstyle` text NOT NULL,
  `description` text NOT NULL,
  `inputtype` varchar(255) NOT NULL DEFAULT 'text',
  `default_value` text NOT NULL,
  `params` text NOT NULL,
  `validation_rule` varchar(50) NOT NULL DEFAULT '',
  `validation_message` varchar(255) NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__forme_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `formstyle` text NOT NULL,
  `fieldstyle` text NOT NULL,
  `thankyou` text NOT NULL,
  `email` text NOT NULL,
  `emailto` text NOT NULL,
  `emailfrom` varchar(255) NOT NULL DEFAULT '',
  `emailfromname` varchar(255) NOT NULL DEFAULT '',
  `emailsubject` varchar(255) NOT NULL DEFAULT '',
  `emailmode` tinyint(4) NOT NULL DEFAULT '1',
  `return_url` varchar(255) NOT NULL DEFAULT '',
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lang` varchar(10) NOT NULL,
  `script_process` text NOT NULL,
  `script_display` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


INSERT IGNORE INTO `#__forme_config` (`id`, `setting_name`, `setting_value`) VALUES(1, 'global.register.code', '');
INSERT IGNORE INTO `#__forme_config` (`id`, `setting_name`, `setting_value`) VALUES(2, 'global.update.check', '0000-00-00');