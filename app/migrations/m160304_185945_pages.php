<?php

class m160304_185945_pages extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{pages}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"parent_id" => "int(11) unsigned NOT NULL DEFAULT '0'",
				"level" => "int(11) unsigned NOT NULL",
				"left_key" => "int(11) unsigned NOT NULL",
				"right_key" => "int(11) unsigned NOT NULL",
				"url" => "varchar(250) NOT NULL",
				"title" => "varchar(250) NOT NULL",
				"header" => "varchar(350) DEFAULT NULL",
				"image" => "varchar(350) DEFAULT NULL",
				"access_lvl" => "int(11) DEFAULT NULL",
				"main_template" => "varchar(250) DEFAULT 'main'",
				"type_module" => "int(11) unsigned NOT NULL",
				"content" => "text",
				"main_page" => "tinyint(1) unsigned NOT NULL", //Главная страница
				"meta_title" => "varchar(250) DEFAULT NULL",
				"meta_keywords" => "varchar(255) DEFAULT NULL",
				"meta_description" => "varchar(255) DEFAULT NULL",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-активно 0 -нет
				"created_at" => "timestamp NULL DEFAULT CURRENT_TIMESTAMP",
				"in_footer" => "int(11) NOT NULL DEFAULT '0'", //Страница находится в футере
				"in_header" => "int(11) NOT NULL",
				"PRIMARY KEY (id)",
				"UNIQUE KEY url (url)",
				"KEY left_key (left_key)",
				"KEY right_key (right_key)",
				"KEY level (level)",
				"KEY type_module (type_module)",
				"KEY parent_id (parent_id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{pages}}');
		return true;
    }

}