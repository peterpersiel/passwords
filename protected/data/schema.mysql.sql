-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 16. Mrz 2013 um 16:11
-- Server Version: 5.5.29
-- PHP-Version: 5.4.6-1ubuntu1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `passwords`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `AuthAssignment`
--

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '1', NULL, 'N;'),
('Authenticated', '3', NULL, 'N;');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `AuthItem`
--

CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Admin', 2, NULL, NULL, 'N;'),
('Authenticated', 2, NULL, NULL, 'N;'),
('Client.*', 1, NULL, NULL, 'N;'),
('Guest', 2, NULL, NULL, 'N;'),
('Password.*', 1, NULL, NULL, 'N;'),
('Project.*', 1, NULL, NULL, 'N;'),
('Security.*', 1, NULL, NULL, 'N;'),
('Site.*', 1, NULL, NULL, 'N;'),
('Type.*', 1, NULL, NULL, 'N;'),
('User.*', 1, NULL, NULL, 'N;');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `AuthItemChild`
--

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('Authenticated', 'Client.*'),
('Authenticated', 'Password.*'),
('Authenticated', 'Project.*'),
('Authenticated', 'Security.*'),
('Authenticated', 'Site.*'),
('Guest', 'Site.*'),
('Authenticated', 'Type.*');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Rights`
--

CREATE TABLE IF NOT EXISTS `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_client`
--

CREATE TABLE IF NOT EXISTS `tbl_client` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `tbl_client`
--

INSERT INTO `tbl_client` (`id`, `name`) VALUES
(5, 'Max Mustermann'),
(6, 'Susi Müller');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_password`
--

CREATE TABLE IF NOT EXISTS `tbl_password` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` text NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Daten für Tabelle `tbl_password`
--

INSERT INTO `tbl_password` (`id`, `password`, `title`, `username`, `type_id`, `project_id`) VALUES
(45, 'MTIzNDU2Nzhhc2RhbHNkamsxMmprMjNqNDJqM2psMmxqbGxqYWxzYWxzc3hteG1ud2VybndlbnJtd2Vybm13bzMzMyUlJQ==', NULL, 'ftpuser', 5, 5),
(46, 'ZGFzcHcxMjNhc2RhbHNkamsxMmprMjNqNDJqM2psMmxqbGxqYWxzYWxzc3hteG1ud2VybndlbnJtd2Vybm13bzMzMyUlJQ==', NULL, 'websitessh', 6, 5),
(47, 'ZGV2dGVzdDEyMzEyM2FzZGFsc2RqazEyamsyM2o0MmozamwybGpsbGphbHNhbHNzeG14bW53ZXJud2Vucm13ZXJubXdvMzMzJSUl', 'Devmailer', '123abc@asd.de', 7, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_project`
--

CREATE TABLE IF NOT EXISTS `tbl_project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `tbl_project`
--

INSERT INTO `tbl_project` (`id`, `name`, `client_id`) VALUES
(5, 'Website', 5),
(6, 'CMS', 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_type`
--

CREATE TABLE IF NOT EXISTS `tbl_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `tbl_type`
--

INSERT INTO `tbl_type` (`id`, `name`) VALUES
(5, 'FTP'),
(7, 'SMTP'),
(6, 'SSH');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `profile` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `email`, `profile`) VALUES
(1, 'admin', '$2a$10$G.tnzuFX4McrCok2I3hYPu9HAlSB2iG2qYcKPb8Zp473xxEaarcOG', 'webmaster@example.com', ''),
(3, 'demo', '$2a$10$pnrmEsdFCcAi3Uzf.2KfFO6p8qWzaQIDXgi8v9.KlyR0/nACXzP6i', 'test1234', '');

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `AuthAssignment`
--
ALTER TABLE `AuthAssignment`
  ADD CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `AuthItemChild`
--
ALTER TABLE `AuthItemChild`
  ADD CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `Rights`
--
ALTER TABLE `Rights`
  ADD CONSTRAINT `Rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_password`
--
ALTER TABLE `tbl_password`
  ADD CONSTRAINT `tbl_password_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `tbl_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_password_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_project`
--
ALTER TABLE `tbl_project`
  ADD CONSTRAINT `tbl_project_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `tbl_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
