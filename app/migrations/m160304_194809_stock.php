<?php

class m160304_194809_stock extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{stock}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"group_id" => "int(11) unsigned DEFAULT NULL",
				"primary" => "enum('0','1') NOT NULL", //Главная статья
				"name" => "varchar(250) NOT NULL",
				"brieftext" => "text",
				"description" => "text",
				"image" => "varchar(50) NOT NULL DEFAULT ''",
				"status" => "tinyint(4) NOT NULL DEFAULT '1'",
				"meta_title" => "varchar(250) NOT NULL",
				"meta_keywords" => "text NOT NULL",
				"meta_description" => "text NOT NULL",
				"maindate" => "datetime NOT NULL",
				"keyword" => "bigint(20) DEFAULT NULL",
				"PRIMARY KEY (id)",
				"KEY status (status)",
				//"FULLTEXT KEY name (name,brieftext,description)", //InnoBD не поддерживает
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{stock}}');
		return true;
    }

}