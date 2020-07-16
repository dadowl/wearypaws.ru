-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июл 17 2020 г., 00:17
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `accounts`
--
CREATE DATABASE `accounts` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `accounts`;

-- --------------------------------------------------------

--
-- Структура таблицы `gamers`
--

CREATE TABLE IF NOT EXISTS `gamers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `referall` varchar(20) CHARACTER SET utf8 NOT NULL,
  `regTime` datetime NOT NULL,
  `ip` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `money` double NOT NULL,
  `onoffansw` tinyint(1) NOT NULL DEFAULT '0',
  `question` varchar(255) CHARACTER SET utf8 NOT NULL,
  `answer` varchar(100) CHARACTER SET utf8 NOT NULL,
  `cloakDostyp` tinyint(1) NOT NULL DEFAULT '0',
  `cloakDate` datetime NOT NULL,
  `cloakStop` datetime NOT NULL,
  `vanillaDostyp` tinyint(1) NOT NULL DEFAULT '0',
  `vanillaDate` datetime NOT NULL,
  `vanillaStop` datetime NOT NULL,
  `tempConfirmCod` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=81 ;

--
-- Дамп данных таблицы `gamers`
--

INSERT INTO `gamers` (`id`, `login`, `password`, `email`, `uuid`, `gender`, `referall`, `regTime`, `ip`, `money`, `onoffansw`, `question`, `answer`, `cloakDostyp`, `cloakDate`, `cloakStop`, `vanillaDostyp`, `vanillaDate`, `vanillaStop`, `tempConfirmCod`) VALUES
(1, 'temaFay', '8Ppj#e|HmH?Yc6aae64fa7d11eaeec13638962e8f841Xg#Rm}62o~Kz', 'fayence@yandex.ru', 'cd4f918e-14bb-37ef-8c31-3a5f102eaad7', 0, 'momlynx', '2019-08-21 13:48:14', '127.0.0.1', 0, 1, 'Ваша любимая игра', 'Кубы', 1, '2019-08-09 00:00:00', '3019-08-09 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(4, 'fayence', '8Ppj#e|HmH?Yf7334c402573e94f221ff15184978a43Xg#Rm}62o~Kz', 'fayence@yandex.ru', 'c310a988-6c6d-387c-80e0-81c476bf9426', 0, 'temaFay', '2019-08-21 15:18:40', '127.0.0.1', 0, 1, 'Ваш любимый ютубер', 'temaFay', 1, '2019-12-25 08:21:47', '2019-12-20 12:17:40', 1, '2019-12-19 17:18:29', '2019-12-25 13:17:51', ''),
(80, 'test', '8Ppj#e|HmH?Y2a0ccc868ccec8f9a90f6791dc1fa266Xg#Rm}62o~Kz', 'test@test.ru', '530fa97a-357f-3c19-94d3-0c5c65c18fe8', 0, '0', '2020-07-16 23:08:04', '127.0.0.1', 0, 1, 'Ваша любимая игра', 'Minecraft', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `permission` mediumtext NOT NULL,
  `world` varchar(50) NOT NULL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`name`,`type`),
  KEY `world` (`world`,`name`,`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=170 ;

--
-- Дамп данных таблицы `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `type`, `permission`, `world`, `value`) VALUES
(1, 'system', 2, 'schema_version', '', '2'),
(6, 'default', 0, 'essentials.warp.list', '', ''),
(7, 'default', 0, 'essentials.warp', '', ''),
(8, 'default', 0, 'essentials.ping', '', ''),
(9, 'default', 0, 'essentials.mute.notify', '', ''),
(10, 'default', 0, 'essentials.kick.notify', '', ''),
(11, 'default', 0, 'essentials.ban.notify', '', ''),
(12, 'default', 0, 'essentials.rules', '', ''),
(13, 'default', 0, 'essentials.recipe', '', ''),
(14, 'default', 0, 'essentials.msg.magic', '', ''),
(15, 'default', 0, 'essentials.msg.format', '', ''),
(16, 'default', 0, 'essentials.msg.color', '', ''),
(17, 'default', 0, 'essentials.msg', '', ''),
(18, 'default', 0, 'essentials.motd', '', ''),
(19, 'default', 0, 'essentials.me', '', ''),
(20, 'default', 0, 'essentials.ignore', '', ''),
(21, 'default', 0, 'essentials.helpop', '', ''),
(22, 'default', 0, 'essentials.book', '', ''),
(23, 'default', 0, 'essentials.afk.auto', '', ''),
(24, 'default', 0, 'essentials.afk', '', ''),
(25, 'default', 0, 'essentials.kits.color', '', ''),
(26, 'default', 0, 'essentials.kits.start', '', ''),
(27, 'default', 0, 'essentials.kit', '', ''),
(28, 'default', 0, 'chatmanager.chat.magic', '', ''),
(29, 'default', 0, 'chatmanager.chat.color', '', ''),
(30, 'default', 0, 'achievement.toggle', '', ''),
(31, 'default', 0, 'achievement.month', '', ''),
(32, 'default', 0, 'achievement.week', '', ''),
(33, 'default', 0, 'achievement.top', '', ''),
(34, 'default', 0, 'achievement.stats', '', ''),
(35, 'default', 0, 'achievement.list', '', ''),
(36, 'default', 0, 'achievement.book', '', ''),
(37, 'default', 0, 'modifyworld.*', '', ''),
(38, 'default', 0, 'default', '', 'true'),
(39, 'default', 0, 'suffix', '', '&f'),
(40, 'default', 0, 'prefix', '', '&a&lИгрок'),
(41, 'tebeetonenada', 0, '-pex.*', '', ''),
(42, 'tebeetonenada', 0, 'default', '', 'false'),
(43, 'roler', 0, 'authme.admin.accounts', '', ''),
(44, 'roler', 0, 'worldguard.region.list.own', '', ''),
(45, 'roler', 0, 'worldguard.region.flag.flags.*', '', ''),
(46, 'roler', 0, 'worldguard.region.flag.regions.member.*', '', ''),
(47, 'roler', 0, 'worldguard.region.flag.regions.own.*', '', ''),
(48, 'roler', 0, 'worldguard.region.removeowner.own.*', '', ''),
(49, 'roler', 0, 'worldguard.region.removemember.own.*', '', ''),
(50, 'roler', 0, 'worldguard.region.addowner.own.*', '', ''),
(51, 'roler', 0, 'worldguard.region.addmember.own.*', '', ''),
(52, 'roler', 0, 'worldguard.region.info.own.*', '', ''),
(53, 'roler', 0, 'worldguard.region.remove.own.*', '', ''),
(54, 'roler', 0, 'worldguard.region.claim', '', ''),
(55, 'roler', 0, 'worldedit.selection.expand', '', ''),
(56, 'roler', 0, 'worldedit.selection.hpos', '', ''),
(57, 'roler', 0, 'worldedit.selection.pos', '', ''),
(58, 'roler', 0, 'worldedit.wand.toggle', '', ''),
(59, 'roler', 0, 'worldedit.wand', '', ''),
(60, 'roler', 0, 'worldguard.region.wand', '', ''),
(61, 'roler', 0, 'worldguard.region.bypass.*', '', ''),
(62, 'roler', 0, 'worldguard.region.info.*', '', ''),
(63, 'roler', 0, 'chatmanager.staffchat', '', ''),
(64, 'roler', 0, 'chatmanager.broadcast', '', ''),
(65, 'roler', 0, 'essentials.back.ondeath', '', ''),
(66, 'roler', 0, 'essentials.back', '', ''),
(67, 'roler', 0, 'essentials.tppos', '', ''),
(68, 'roler', 0, 'essentials.tpo', '', ''),
(69, 'roler', 0, 'essentials.tphere', '', ''),
(70, 'roler', 0, 'essentials.tp.others', '', ''),
(71, 'roler', 0, 'essentials.tp', '', ''),
(72, 'roler', 0, 'essentials.warp.overwrite.*', '', ''),
(73, 'roler', 0, 'essentials.setwarp', '', ''),
(74, 'roler', 0, 'essentials.delwarp', '', ''),
(75, 'roler', 0, 'essentials.spawn.others', '', ''),
(76, 'roler', 0, 'essentials.spawn', '', ''),
(77, 'roler', 0, 'essentials.weather', '', ''),
(78, 'roler', 0, 'essentials.vanish.see', '', ''),
(79, 'roler', 0, 'essentials.vanish.interact', '', ''),
(80, 'roler', 0, 'essentials.vanish.effect', '', ''),
(81, 'roler', 0, 'essentials.vanish', '', ''),
(82, 'roler', 0, 'essentials.unbanip', '', ''),
(83, 'roler', 0, 'essentials.unban', '', ''),
(84, 'roler', 0, 'essentials.tempban.offline', '', ''),
(85, 'roler', 0, 'essentials.tempban.exempt', '', ''),
(86, 'roler', 0, 'essentials.tempban', '', ''),
(87, 'roler', 0, 'essentials.setjail', '', ''),
(88, 'roler', 0, 'essentials.mute', '', ''),
(89, 'roler', 0, 'essentials.kick', '', ''),
(90, 'roler', 0, 'essentials.jails', '', ''),
(91, 'roler', 0, 'essentials.invsee.modify', '', ''),
(92, 'roler', 0, 'essentials.invsee', '', ''),
(93, 'roler', 0, 'essentials.gc', '', ''),
(94, 'roler', 0, 'essentials.enderchest.modify', '', ''),
(95, 'roler', 0, 'essentials.enderchest', '', ''),
(96, 'roler', 0, 'essentials.banip', '', ''),
(97, 'roler', 0, 'essentials.ban.offline', '', ''),
(98, 'roler', 0, 'essentials.ban.notify', '', ''),
(99, 'roler', 0, 'essentials.ban.exempt', '', ''),
(100, 'roler', 0, 'essentials.ban', '', ''),
(101, 'roler', 0, 'essentials.near', '', ''),
(102, 'roler', 0, 'essentials.list.hidden', '', ''),
(103, 'roler', 0, 'essentials.list', '', ''),
(104, 'roler', 0, 'essentials.helpop.receive', '', ''),
(105, 'roler', 0, 'essentials.getpos.others', '', ''),
(106, 'roler', 0, 'essentials.getpos', '', ''),
(107, 'roler', 0, 'essentials.depth', '', ''),
(108, 'roler', 0, 'essentials.compass', '', ''),
(109, 'roler', 0, 'essentials.time.set', '', ''),
(110, 'roler', 0, 'essentials.time', '', ''),
(111, 'roler', 0, 'essentials.speed.fly', '', ''),
(112, 'roler', 0, 'essentials.speed', '', ''),
(113, 'roler', 0, 'essentials.kit.others', '', ''),
(114, 'roler', 0, 'essentials.kits.fireworks', '', ''),
(115, 'roler', 0, 'essentials.heal.others', '', ''),
(116, 'roler', 0, 'essentials.heal', '', ''),
(117, 'roler', 0, 'essentials.hat', '', ''),
(118, 'roler', 0, 'essentials.feed.others', '', ''),
(119, 'roler', 0, 'essentials.feed', '', ''),
(120, 'roler', 0, 'essentials.fly', '', ''),
(121, 'roler', 0, 'default', '', 'false'),
(122, 'roler', 0, 'suffix', '', '&d'),
(123, 'roler', 0, 'prefix', '', '&d&lРолер'),
(124, 'helper', 0, 'chatmanager.cmdspy', '', ''),
(125, 'helper', 0, 'essentials.socialspy', '', ''),
(126, 'helper', 0, 'essentials.backup', '', ''),
(127, 'helper', 0, 'essentials.whois', '', ''),
(128, 'helper', 0, 'essentials.geoip.show', '', ''),
(129, 'helper', 0, 'essentials.seen.ipsearch', '', ''),
(130, 'helper', 0, 'essentials.seen.extra', '', ''),
(131, 'helper', 0, 'essentials.seen.banreason', '', ''),
(132, 'helper', 0, 'essentials.seen', '', ''),
(133, 'helper', 0, 'essentials.repair.enchanted', '', ''),
(134, 'helper', 0, 'essentials.repair.armor', '', ''),
(135, 'helper', 0, 'essentials.repair', '', ''),
(136, 'helper', 0, 'essentials.oversizedstacks', '', ''),
(137, 'helper', 0, 'essentials.more', '', ''),
(138, 'helper', 0, 'default', '', 'false'),
(139, 'helper', 0, 'suffix', '', '&9'),
(140, 'helper', 0, 'prefix', '', '&9&lХелпер'),
(141, 'builder', 0, 'worldedit.region.faces', '', ''),
(142, 'builder', 0, 'worldedit.region.walls', '', ''),
(143, 'builder', 0, 'worldedit.brush.*', '', ''),
(144, 'builder', 0, 'worldedit.region.set', '', ''),
(145, 'builder', 0, 'worldedit.region.stack', '', ''),
(146, 'builder', 0, 'worldedit.region.move', '', ''),
(147, 'builder', 0, 'worldedit.navigation.up', '', ''),
(148, 'builder', 0, 'worldedit.history.redo', '', ''),
(149, 'builder', 0, 'worldedit.history.undo', '', ''),
(150, 'builder', 0, 'worldedit.generation.pyramid', '', ''),
(151, 'builder', 0, 'worldedit.generation.sphere', '', ''),
(152, 'builder', 0, 'worldedit.generation.cylinder', '', ''),
(153, 'builder', 0, 'worldedit.clipboard.rotate', '', ''),
(154, 'builder', 0, 'worldedit.clipboard.cut', '', ''),
(155, 'builder', 0, 'worldedit.clipboard.paste', '', ''),
(156, 'builder', 0, 'worldedit.clipboard.copy', '', ''),
(157, 'builder', 0, 'essentials.gamemode', '', ''),
(158, 'builder', 0, 'default', '', 'false'),
(159, 'builder', 0, 'suffix', '', '&6'),
(160, 'builder', 0, 'prefix', '', '&6&lБилдер'),
(161, 'buildergl', 0, 'worldedit.*', '', ''),
(162, 'buildergl', 0, 'essentials.gamemode', '', ''),
(163, 'buildergl', 0, 'default', '', 'false'),
(164, 'buildergl', 0, 'suffix', '', '&6'),
(165, 'buildergl', 0, 'prefix', '', '&6&lАрхитектор'),
(166, 'staff', 0, '*', '', ''),
(167, 'staff', 0, 'default', '', 'false'),
(168, 'staff', 0, 'suffix', '', '&c'),
(169, 'staff', 0, 'prefix', '', '&c&lStaff');

-- --------------------------------------------------------

--
-- Структура таблицы `permissions_entity`
--

CREATE TABLE IF NOT EXISTS `permissions_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`type`),
  KEY `default` (`default`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `permissions_entity`
--

INSERT INTO `permissions_entity` (`id`, `name`, `type`, `default`) VALUES
(1, 'default', 0, 0),
(2, 'tebeetonenada', 0, 0),
(3, 'roler', 0, 0),
(4, 'helper', 0, 0),
(5, 'builder', 0, 0),
(6, 'buildergl', 0, 0),
(7, 'staff', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `permissions_inheritance`
--

CREATE TABLE IF NOT EXISTS `permissions_inheritance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child` varchar(50) NOT NULL,
  `parent` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `world` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `child` (`child`,`parent`,`type`,`world`),
  KEY `child_2` (`child`,`type`),
  KEY `parent` (`parent`,`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `permissions_inheritance`
--

INSERT INTO `permissions_inheritance` (`id`, `child`, `parent`, `type`, `world`) VALUES
(6, 'builder', 'default', 0, NULL),
(5, 'builder', 'roler', 0, NULL),
(7, 'buildergl', 'builder', 0, NULL),
(9, 'buildergl', 'default', 0, NULL),
(8, 'buildergl', 'roler', 0, NULL),
(4, 'helper', 'default', 0, NULL),
(3, 'helper', 'roler', 0, NULL),
(2, 'roler', 'default', 0, NULL),
(1, 'roler', 'tebeetonenada', 0, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
