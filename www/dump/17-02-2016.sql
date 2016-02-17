-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 17 2016 г., 12:17
-- Версия сервера: 5.5.47-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `middle_name` varchar(128) DEFAULT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `birthday` timestamp NULL DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `city_id` int(11) unsigned DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `subscribe` tinyint(1) NOT NULL DEFAULT '0',
  `stype` enum('vk','ok','fb','mail','foursquare','twitter','instagram','google') DEFAULT NULL,
  `sid` varchar(128) DEFAULT NULL,
  `mail_index` int(10) DEFAULT NULL,
  `mail_street` varchar(64) DEFAULT NULL,
  `mail_street_house` varchar(15) DEFAULT NULL,
  `mail_street_corps` varchar(15) DEFAULT NULL,
  `mail_street_apartment` varchar(15) DEFAULT NULL,
  `email_group` int(11) unsigned DEFAULT NULL,
  `email_accept_time` datetime DEFAULT NULL,
  `email_accept_code` varchar(32) DEFAULT NULL,
  `role_id` varchar(10) DEFAULT NULL,
  `organization` varchar(500) DEFAULT NULL,
  `ur_addres` varchar(500) DEFAULT NULL,
  `fiz_addres` varchar(500) DEFAULT NULL,
  `inn` varchar(100) DEFAULT NULL,
  `kpp` varchar(100) DEFAULT NULL,
  `okpo` varchar(100) DEFAULT NULL,
  `recovery_password_at` datetime DEFAULT NULL,
  `recovery_code` varchar(32) DEFAULT NULL,
  `balance` int(11) DEFAULT '0',
  `score` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_email` (`email`),
  KEY `fk_user_city` (`city_id`),
  KEY `user_role_idx` (`role_id`),
  KEY `idx_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `tbl_user`
--

INSERT INTO `tbl_user` VALUES(7, 'admin@example.com', 'superuser', '0baea2f0ae20150db78f58cddac442a9', 'Чусов', '', 'Петр', '2010-02-19 23:00:00', 1, NULL, '79620173456', NULL, '0000-00-00 00:00:00', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '0000-00-00 00:00:00', NULL, 'admin', 'Рога 2', 'Москва', 'Железнодорожный', '55345', '9754646', '21413123123', '2015-07-30 21:02:06', '6PanO0gnBDo4M8xOC2Djnbga2SB5PrGK', 0, 0);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `fk_user_city` FOREIGN KEY (`city_id`) REFERENCES `tbl_geo_city` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
