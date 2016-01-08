-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.27 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              7.0.0.4390
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица fastweb-yii.tbl_site_module
DROP TABLE IF EXISTS `tbl_site_module`;
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='Список подклюеных модулей';

-- Дамп данных таблицы fastweb-yii.tbl_site_module: ~17 rows (приблизительно)
/*!40000 ALTER TABLE `tbl_site_module` DISABLE KEYS */;
INSERT INTO `tbl_site_module` (`id`, `name`, `url_to_controller`, `description`, `templates`, `created_at`) VALUES
	(1, 'Новости', '/news/news', NULL, NULL, '2015-10-20 13:24:34'),
	(2, 'Карта сайта', '/sitemap/sitemap', NULL, NULL, '2015-10-20 13:24:52'),
	(3, 'Поиск на сайте', '/siteserch/siteserch', NULL, NULL, '2015-10-20 13:25:08'),
	(4, 'Каталог', '/catalog/catalog', NULL, NULL, '2015-12-09 17:02:42'),
	(5, 'Корзина', '/content/basket', NULL, NULL, '2015-12-09 17:02:45'),
	(6, 'Статьи', '/stock/stock', NULL, NULL, '2015-11-23 11:26:01'),
	(7, 'Вопросы-ответы', '/question/question', NULL, NULL, '2015-11-24 23:01:20'),
	(8, 'URL ссылка (пишите адрес ссылки в Url адрес )', '/urllink/urllink', NULL, NULL, '2015-11-26 17:32:07'),
	(9, 'Акции', '/sale/sale', NULL, NULL, '2015-11-27 14:09:12'),
	(10, 'Врачи', '/doctor/doctor', NULL, NULL, '2015-12-01 10:41:41'),
	(11, 'Фотогалерея', '/photo/photo', NULL, NULL, '2015-12-01 14:44:11'),
	(12, 'До и После', '/beforeafter/beforeafter', NULL, NULL, '2015-12-02 16:08:02'),
	(13, 'Таблицы', '/maintabel/maintabel', NULL, NULL, '2015-12-03 11:36:11'),
	(14, 'Пресса', '/press/press', NULL, NULL, '2015-12-04 19:20:24'),
	(15, 'Банеры', '/baners/baners', NULL, NULL, '2015-12-11 14:35:29'),
	(16, 'Отзывы', '/review/review', NULL, NULL, '2015-12-23 19:34:28'),
	(17, 'HTML код', '/htmlcode/htmlcode', NULL, NULL, '2015-12-29 13:19:24');
/*!40000 ALTER TABLE `tbl_site_module` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
