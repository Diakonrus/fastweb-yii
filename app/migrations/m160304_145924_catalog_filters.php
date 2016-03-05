<?php

class m160304_145924_catalog_filters extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{catalog_filters}}",
			array(
				"id" => "int(11) NOT NULL AUTO_INCREMENT",
				"name" => "varchar(200) NOT NULL DEFAULT ''",
				"type" => "int(11) NOT NULL DEFAULT '0'", //Тип: 0-checkbox, 1-scroll, 2-select
				"charsname" => "varchar(200) NOT NULL DEFAULT ''", //Имя характеристики
				"status" => "varchar(200) NOT NULL DEFAULT '0'", //Статус
				"position" => "varchar(200) NOT NULL DEFAULT '0'", //Позиция фильтра в нулевой категории
				"PRIMARY KEY (id)"
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{catalog_filters}}');
		return true;
    }

}