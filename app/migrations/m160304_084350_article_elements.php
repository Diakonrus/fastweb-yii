<?php

class m160304_084350_article_elements extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{article_elements}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"parent_id" => "int(11) unsigned DEFAULT NULL",
				"primary" => "enum('0','1') NOT NULL", //Главная статья
				"name" => "varchar(250) NOT NULL",
				"brieftext" => "text",
				"description" => "text",
				"image" => "varchar(50) NOT NULL DEFAULT ''",
				"status" => "tinyint(4) NOT NULL DEFAULT '1'",
				"maindate" => "datetime NOT NULL",
				"keyword" => "bigint(20) DEFAULT NULL",
				"created_at" => "bigint(20) DEFAULT NULL",
				"PRIMARY KEY (id)",
				"KEY status (status)",
				//"FULLTEXT KEY name (status, brieftext, description)", //InnoDB не поддерживает FULLTEXT
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
	}

	public function down() {
		$this->dropTable('{{article_elements}}');
		return true;
	}

}