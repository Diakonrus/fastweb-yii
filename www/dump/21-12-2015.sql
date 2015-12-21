-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 21 2015 г., 12:10
-- Версия сервера: 5.5.27
-- Версия PHP: 5.5.24

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `fastweb-yii`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_baners_elements`
--

CREATE TABLE IF NOT EXISTS `tbl_baners_elements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL,
  `name` varchar(450) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `url` varchar(450) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-активно 0-не активно',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_baners_rubrics`
--

CREATE TABLE IF NOT EXISTS `tbl_baners_rubrics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `left_key` int(11) unsigned NOT NULL,
  `right_key` int(11) unsigned NOT NULL,
  `level` int(11) unsigned NOT NULL,
  `url` varchar(250) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `name` varchar(450) NOT NULL,
  `description` text,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `meta_title` varchar(250) DEFAULT NULL,
  `meta_keywords` text,
  `meta_description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `right_key` (`right_key`),
  KEY `level` (`level`),
  KEY `left_key` (`left_key`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_basket_items`
--

CREATE TABLE IF NOT EXISTS `tbl_basket_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `basket_order_id` int(11) unsigned NOT NULL,
  `module` varchar(350) DEFAULT NULL,
  `url` varchar(350) DEFAULT NULL,
  `item` int(11) DEFAULT NULL COMMENT 'товар',
  `quantity` int(11) DEFAULT '0' COMMENT 'количество',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT 'Цена (со скидкой если она предоставлена)',
  `trueprice` decimal(10,2) DEFAULT '0.00' COMMENT 'Реальная цена на товар',
  `comments` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_basket_items_tbl_basket_order` (`basket_order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_basket_order`
--

CREATE TABLE IF NOT EXISTS `tbl_basket_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `address` varchar(550) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `comments` text,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-поступление, 1-регистрация',
  `status_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_basket_order_tbl_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_before_after_elements`
--

CREATE TABLE IF NOT EXISTS `tbl_before_after_elements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `before_photo` varchar(50) DEFAULT NULL,
  `after_photo` varchar(50) DEFAULT NULL,
  `briftext` text,
  `before_text` text,
  `after_text` text,
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '1-активно 0 -нет',
  `on_main` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_before_after_rubrics`
--

CREATE TABLE IF NOT EXISTS `tbl_before_after_rubrics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(350) NOT NULL,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `level` int(11) unsigned NOT NULL,
  `left_key` int(11) unsigned NOT NULL,
  `right_key` int(11) unsigned NOT NULL,
  `url` varchar(250) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-активно 0 -нет',
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `left_key` (`left_key`),
  KEY `right_key` (`right_key`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_catalog_chars`
--

CREATE TABLE IF NOT EXISTS `tbl_catalog_chars` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(20) unsigned DEFAULT NULL COMMENT 'id товара/категории',
  `order_id` int(20) unsigned NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL COMMENT 'имя',
  `scale` varchar(550) DEFAULT NULL COMMENT 'значение',
  `inherits` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Наследование',
  `type_scale` int(11) unsigned NOT NULL DEFAULT '1' COMMENT 'тип значения scale 1-текст, 2-групповой выбор(например, размер), 3-цвет',
  `type_parent` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-категория 2-товар 3-общие характеристики',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-активно 0-неактивно',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `parent_id` (`parent_id`),
  KEY `scale` (`scale`(255)),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_catalog_elements`
--

CREATE TABLE IF NOT EXISTS `tbl_catalog_elements` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `brieftext` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `ansvtype` tinyint(3) unsigned NOT NULL,
  `execute` tinyint(4) NOT NULL,
  `hit` smallint(6) NOT NULL,
  `image` varchar(5) NOT NULL,
  `page_name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `fkey` varchar(250) NOT NULL,
  `code` varchar(100) NOT NULL,
  `qty` int(10) unsigned DEFAULT NULL,
  `price` double DEFAULT '0',
  `price_entering` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `parent_id` (`parent_id`,`order_id`),
  KEY `status` (`status`),
  FULLTEXT KEY `name` (`name`,`page_name`,`brieftext`,`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_catalog_elements_discount`
--

CREATE TABLE IF NOT EXISTS `tbl_catalog_elements_discount` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `element_id` bigint(20) NOT NULL,
  `count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Количество',
  `values` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT 'Значение',
  `type` tinyint(1) unsigned NOT NULL COMMENT '1-Фиксированая 2-В процентах',
  `user_role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '0-Все, остальные значения - применить к группе из списка ролей',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0-отключен 1-включен',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `element_id` (`element_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Скидки на товары' AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_catalog_rubrics`
--

CREATE TABLE IF NOT EXISTS `tbl_catalog_rubrics` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) NOT NULL,
  `left_key` bigint(20) NOT NULL,
  `level` bigint(20) NOT NULL,
  `right_key` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `url` varchar(220) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `meta_title` varchar(250) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `execute` tinyint(4) NOT NULL,
  `fkey` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `left_key` (`left_key`,`level`,`right_key`),
  KEY `left_key_2` (`left_key`,`right_key`,`level`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_creating_form_elements`
--

CREATE TABLE IF NOT EXISTS `tbl_creating_form_elements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Порядок',
  `name` varchar(250) NOT NULL,
  `feeld_type` int(11) unsigned NOT NULL COMMENT 'Тип поля',
  `feeld_value` varchar(350) DEFAULT NULL COMMENT 'Значение',
  `feeld_require` tinyint(1) unsigned NOT NULL COMMENT 'Обязательность',
  `feeld_template` text COMMENT 'Шаблон поля',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-активно 0-не активно',
  `creating_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_creating_form_rubrics`
--

CREATE TABLE IF NOT EXISTS `tbl_creating_form_rubrics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `subject_recipient` varchar(350) NOT NULL COMMENT 'Тема письма',
  `email_recipient` varchar(350) NOT NULL COMMENT 'Емайл на который будут уходить письма',
  `complete_mess` varchar(450) DEFAULT NULL COMMENT 'Сообщение по завершении',
  `form_template` text,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-активно 0-нет',
  `creating_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_doctor_elements`
--

CREATE TABLE IF NOT EXISTS `tbl_doctor_elements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(350) NOT NULL,
  `anonse` text,
  `anonse_dop` text,
  `description` text,
  `image` varchar(5) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-активно 0-не активно',
  `chief_doctor` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Главный врач 0-нет 1-да',
  `meta_title` varchar(350) DEFAULT NULL,
  `meta_keywords` text,
  `meta_description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `name` (`name`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_doctor_rubrics`
--

CREATE TABLE IF NOT EXISTS `tbl_doctor_rubrics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(350) NOT NULL,
  `url` varchar(250) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1-активно 0-не активно',
  `meta_title` varchar(350) DEFAULT NULL,
  `meta_keywords` text,
  `meta_description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_doctor_specialization`
--

CREATE TABLE IF NOT EXISTS `tbl_doctor_specialization` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_rubrics_id` int(11) unsigned NOT NULL,
  `doctor_elements_id` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_doctor_specialization_tbl_doctor_rubrics` (`doctor_rubrics_id`),
  KEY `FK_tbl_doctor_specialization_tbl_doctor_elements` (`doctor_elements_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_email_group`
--

CREATE TABLE IF NOT EXISTS `tbl_email_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_email_messages`
--

CREATE TABLE IF NOT EXISTS `tbl_email_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `to_email` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `body` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0-не отправлено 1-отправлено',
  `template_id` int(11) unsigned DEFAULT NULL,
  `send_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type_messages` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-отправка письма 2-рассылка',
  PRIMARY KEY (`id`),
  KEY `FK_email_messages_tbl_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_email_template`
--

CREATE TABLE IF NOT EXISTS `tbl_email_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(350) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_faq_author`
--

CREATE TABLE IF NOT EXISTS `tbl_faq_author` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(450) DEFAULT NULL,
  `email` varchar(450) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_faq_elements`
--

CREATE TABLE IF NOT EXISTS `tbl_faq_elements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL,
  `author_id` int(11) unsigned DEFAULT NULL,
  `question` text NOT NULL,
  `answer` text,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-включено 0-выключено',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_faq_elements_tbl_faq_rubrics` (`parent_id`),
  KEY `FK_tbl_faq_elements_tbl_faq_author` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_faq_rubrics`
--

CREATE TABLE IF NOT EXISTS `tbl_faq_rubrics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `left_key` int(11) unsigned NOT NULL,
  `level` int(11) unsigned NOT NULL,
  `right_key` int(11) NOT NULL,
  `name` varchar(350) NOT NULL,
  `url` varchar(250) DEFAULT NULL,
  `description` text,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-включено 0-выключено',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_feedback`
--

CREATE TABLE IF NOT EXISTS `tbl_feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fio` varchar(550) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(550) NOT NULL,
  `question` text NOT NULL,
  `answer` text,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-новая 2-отыечено',
  `answer_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_geo_city`
--

CREATE TABLE IF NOT EXISTS `tbl_geo_city` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `name_ru` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`),
  KEY `country_id` (`country_id`),
  KEY `region_id` (`region_id`),
  KEY `name_ru` (`name_ru`),
  KEY `name_en` (`name_en`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=17590 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_geo_country`
--

CREATE TABLE IF NOT EXISTS `tbl_geo_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_ru` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `code` varchar(5) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`),
  KEY `name_ru` (`name_ru`),
  KEY `name_en` (`name_en`),
  KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=219 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_geo_item`
--

CREATE TABLE IF NOT EXISTS `tbl_geo_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type_id` int(2) NOT NULL,
  `level_1` int(3) DEFAULT NULL,
  `level_2` int(3) DEFAULT NULL,
  `level_3` int(3) DEFAULT NULL,
  `level_4` int(3) DEFAULT NULL,
  `level_5` int(3) DEFAULT NULL,
  `level_index` int(1) NOT NULL,
  `post_index` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=212306 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_geo_region`
--

CREATE TABLE IF NOT EXISTS `tbl_geo_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `name_ru` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`),
  KEY `country_id` (`country_id`),
  KEY `name_ru` (`name_ru`),
  KEY `name_en` (`name_en`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1612 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_geo_type`
--

CREATE TABLE IF NOT EXISTS `tbl_geo_type` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `shortname` varchar(255) NOT NULL,
  `level_index` int(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=315 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_loadxml_rubrics`
--

CREATE TABLE IF NOT EXISTS `tbl_loadxml_rubrics` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `module` int(10) unsigned NOT NULL,
  `tableadd1` varchar(50) NOT NULL,
  `tableadd2` varchar(50) NOT NULL,
  `tableadd3` varchar(50) NOT NULL,
  `tableadd4` varchar(50) NOT NULL,
  `brieftext` text NOT NULL,
  `content1` text NOT NULL,
  `content_add1` text NOT NULL,
  `content_add2` text NOT NULL,
  `content_add3` text NOT NULL,
  `content_add4` text NOT NULL,
  `content_link1` text NOT NULL,
  `content_link2` text NOT NULL,
  `content_link3` text NOT NULL,
  `content_link4` text NOT NULL,
  `content_link5` text NOT NULL,
  `content2` text NOT NULL,
  `groups` text NOT NULL,
  `ext` varchar(20) NOT NULL,
  `unique` varchar(50) NOT NULL,
  `splitter` tinyint(3) unsigned NOT NULL,
  `tag` varchar(60) NOT NULL,
  `tags` varchar(1024) NOT NULL,
  `class` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `module` (`module`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=229 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_mail_template`
--

CREATE TABLE IF NOT EXISTS `tbl_mail_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(450) NOT NULL COMMENT 'Тема письма',
  `body` text NOT NULL COMMENT 'Текст письма',
  `type` tinyint(2) unsigned NOT NULL COMMENT '1-шаблон при регистрации',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_main_tabel`
--

CREATE TABLE IF NOT EXISTS `tbl_main_tabel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(350) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_news`
--

CREATE TABLE IF NOT EXISTS `tbl_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned DEFAULT NULL,
  `primary` enum('0','1') NOT NULL COMMENT 'Главные новости',
  `name` varchar(250) NOT NULL,
  `brieftext` text,
  `description` text,
  `image` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `meta_title` varchar(250) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `maindate` datetime NOT NULL,
  `keyword` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  FULLTEXT KEY `name` (`name`,`brieftext`,`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=163 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_news_group`
--

CREATE TABLE IF NOT EXISTS `tbl_news_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(350) NOT NULL,
  `url` varchar(250) NOT NULL,
  `brieftext` text,
  `description` text,
  `image` varchar(50) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-включено 0-выключено',
  `param_design` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-оформление на белом,  2-сером',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_pages`
--

CREATE TABLE IF NOT EXISTS `tbl_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `level` int(11) unsigned NOT NULL,
  `left_key` int(11) unsigned NOT NULL,
  `right_key` int(11) unsigned NOT NULL,
  `url` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `image` varchar(350) DEFAULT NULL,
  `access_lvl` int(11) DEFAULT NULL,
  `main_template` varchar(250) DEFAULT 'main',
  `type_module` int(11) unsigned NOT NULL,
  `content` text,
  `main_page` tinyint(1) unsigned NOT NULL COMMENT 'Главная страница',
  `meta_title` varchar(250) DEFAULT NULL,
  `meta_keywords` text,
  `meta_description` text,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-активно 0 -нет',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `left_key` (`left_key`),
  KEY `right_key` (`right_key`),
  KEY `level` (`level`),
  KEY `type_module` (`type_module`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_pages_tabs`
--

CREATE TABLE IF NOT EXISTS `tbl_pages_tabs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Порядок вывода',
  `pages_id` int(11) unsigned NOT NULL,
  `site_module_id` int(11) unsigned NOT NULL COMMENT 'Используемый модуль',
  `site_module_value` varchar(350) NOT NULL COMMENT 'выбраное id элементов - пишутся через |',
  `template_id` int(11) unsigned NOT NULL COMMENT 'Оформление',
  `title` varchar(350) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pages_id` (`pages_id`),
  KEY `tabs_id` (`site_module_id`),
  KEY `template_id` (`template_id`),
  KEY `site_module_value` (`site_module_value`(255)),
  KEY `title` (`title`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Вкладки' AUTO_INCREMENT=99 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_photo_elements`
--

CREATE TABLE IF NOT EXISTS `tbl_photo_elements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL,
  `name` varchar(450) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `url` varchar(450) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-активно 0-не активно',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_photo_rubrics`
--

CREATE TABLE IF NOT EXISTS `tbl_photo_rubrics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `left_key` int(11) unsigned NOT NULL,
  `right_key` int(11) unsigned NOT NULL,
  `level` int(11) unsigned NOT NULL,
  `url` varchar(250) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `name` varchar(450) NOT NULL,
  `description` text,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `meta_title` varchar(250) DEFAULT NULL,
  `meta_keywords` text,
  `meta_description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `right_key` (`right_key`),
  KEY `level` (`level`),
  KEY `left_key` (`left_key`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_photo_template`
--

CREATE TABLE IF NOT EXISTS `tbl_photo_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(350) NOT NULL,
  `val` text NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_press`
--

CREATE TABLE IF NOT EXISTS `tbl_press` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned DEFAULT NULL,
  `primary` enum('0','1') NOT NULL COMMENT 'Главные новости',
  `name` varchar(250) NOT NULL,
  `brieftext` text,
  `description` text,
  `image` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `meta_title` varchar(250) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `maindate` datetime NOT NULL,
  `keyword` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  FULLTEXT KEY `name` (`name`,`brieftext`,`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_press_group`
--

CREATE TABLE IF NOT EXISTS `tbl_press_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(350) NOT NULL,
  `url` varchar(250) NOT NULL,
  `brieftext` text,
  `description` text,
  `image` varchar(50) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-включено 0-выключено',
  `param_design` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-оформление на белом,  2-сером',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_sale`
--

CREATE TABLE IF NOT EXISTS `tbl_sale` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned DEFAULT NULL,
  `primary` enum('0','1') NOT NULL COMMENT 'Главные новости',
  `name` varchar(250) NOT NULL,
  `brieftext` text,
  `description` text,
  `image` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `meta_title` varchar(250) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `maindate` datetime NOT NULL,
  `keyword` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  FULLTEXT KEY `name` (`name`,`brieftext`,`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_sale_group`
--

CREATE TABLE IF NOT EXISTS `tbl_sale_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(350) NOT NULL,
  `url` varchar(250) NOT NULL,
  `brieftext` text,
  `description` text,
  `image` varchar(50) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-включено 0-выключено',
  `param_design` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-оформление на белом,  2-сером',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_session`
--

CREATE TABLE IF NOT EXISTS `tbl_session` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_site_module`
--

CREATE TABLE IF NOT EXISTS `tbl_site_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL COMMENT 'Название модуля',
  `url_to_controller` varchar(550) DEFAULT NULL COMMENT 'Путь к контроллеру на фронте',
  `description` varchar(450) DEFAULT NULL COMMENT 'Описание',
  `templates` varchar(250) DEFAULT NULL COMMENT 'название темплейта содержащий контроллер, вьюшку',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `templates` (`templates`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Список подклюеных модулей' AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_site_module_settings`
--

CREATE TABLE IF NOT EXISTS `tbl_site_module_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_module_id` int(11) unsigned NOT NULL,
  `version` varchar(10) NOT NULL,
  `r_cover_small` varchar(50) DEFAULT '100x100',
  `r_cover_small_crop` enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL,
  `r_cover_medium` varchar(50) DEFAULT '200x200',
  `r_cover_medium_crop` enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL,
  `r_cover_medium2` varchar(50) NOT NULL DEFAULT '300X300',
  `r_cover_medium2_crop` enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL,
  `r_cover_quality` int(11) DEFAULT '90',
  `r_small_color` varchar(10) NOT NULL DEFAULT 'ffffff',
  `r_medium_color` varchar(10) NOT NULL DEFAULT 'ffffff',
  `r_medium2_color` varchar(10) NOT NULL DEFAULT 'ffffff',
  `e_cover_small` varchar(50) DEFAULT '100x100',
  `e_cover_small_crop` enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL,
  `e_cover_medium` varchar(50) DEFAULT '200x200',
  `e_cover_medium_crop` enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL,
  `e_cover_medium2` varchar(50) NOT NULL DEFAULT '300X300',
  `e_cover_medium2_crop` enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL,
  `e_cover_quality` int(11) DEFAULT '90',
  `e_small_color` varchar(10) NOT NULL DEFAULT 'ffffff',
  `e_medium_color` varchar(10) NOT NULL DEFAULT 'ffffff',
  `e_medium2_color` varchar(10) NOT NULL DEFAULT 'ffffff',
  `elements_page_admin` int(11) NOT NULL DEFAULT '20',
  `watermark` varchar(255) NOT NULL,
  `watermark_pos` int(11) NOT NULL,
  `watermark_type` tinyint(3) unsigned NOT NULL,
  `watermark_transp` int(10) unsigned NOT NULL,
  `watermark_color` varchar(80) NOT NULL,
  `watermask_font` int(10) unsigned NOT NULL,
  `watermask_fontsize` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-активно 0-не активно',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `site_module_id` (`site_module_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_stock`
--

CREATE TABLE IF NOT EXISTS `tbl_stock` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned DEFAULT NULL,
  `primary` enum('0','1') NOT NULL COMMENT 'Главная статья',
  `name` varchar(250) NOT NULL,
  `brieftext` text,
  `description` text,
  `image` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `meta_title` varchar(250) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `maindate` datetime NOT NULL,
  `keyword` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  FULLTEXT KEY `name` (`name`,`brieftext`,`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_stock_group`
--

CREATE TABLE IF NOT EXISTS `tbl_stock_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(350) NOT NULL,
  `description` text,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1-включено 0-выключено',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_user`
--

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

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_user_role`
--

CREATE TABLE IF NOT EXISTS `tbl_user_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` varchar(150) NOT NULL,
  `access_level` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `descriptions` (`description`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_user_session`
--

CREATE TABLE IF NOT EXISTS `tbl_user_session` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_yandex_map`
--

CREATE TABLE IF NOT EXISTS `tbl_yandex_map` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `coord` varchar(50) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tbl_basket_items`
--
ALTER TABLE `tbl_basket_items`
  ADD CONSTRAINT `FK_tbl_basket_items_tbl_basket_order` FOREIGN KEY (`basket_order_id`) REFERENCES `tbl_basket_order` (`id`);

--
-- Ограничения внешнего ключа таблицы `tbl_basket_order`
--
ALTER TABLE `tbl_basket_order`
  ADD CONSTRAINT `FK_tbl_basket_order_tbl_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`);

--
-- Ограничения внешнего ключа таблицы `tbl_email_messages`
--
ALTER TABLE `tbl_email_messages`
  ADD CONSTRAINT `FK_email_messages_tbl_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`);

--
-- Ограничения внешнего ключа таблицы `tbl_faq_elements`
--
ALTER TABLE `tbl_faq_elements`
  ADD CONSTRAINT `FK_tbl_faq_elements_tbl_faq_author` FOREIGN KEY (`author_id`) REFERENCES `tbl_faq_author` (`id`),
  ADD CONSTRAINT `FK_tbl_faq_elements_tbl_faq_rubrics` FOREIGN KEY (`parent_id`) REFERENCES `tbl_faq_rubrics` (`id`);

--
-- Ограничения внешнего ключа таблицы `tbl_geo_city`
--
ALTER TABLE `tbl_geo_city`
  ADD CONSTRAINT `tbl_geo_city_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `tbl_geo_country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_geo_city_ibfk_2` FOREIGN KEY (`region_id`) REFERENCES `tbl_geo_region` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_geo_region`
--
ALTER TABLE `tbl_geo_region`
  ADD CONSTRAINT `tbl_geo_region_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `tbl_geo_country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `fk_user_city` FOREIGN KEY (`city_id`) REFERENCES `tbl_geo_city` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
