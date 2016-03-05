<?php

class m160304_185043_news_elements extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{news_elements}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"parent_id" => "int(11) unsigned NOT NULL",
				"primary" => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
				"name" => "varchar(250) NOT NULL",
				"brieftext" => "text",
				"description" => "text",
				"image" => "varchar(50) NOT NULL DEFAULT ''",
				"maindate" => "datetime NOT NULL",
				"keyword" => "bigint(20) DEFAULT NULL",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-включено 0-выключено
				"meta_title" => "varchar(250) DEFAULT NULL",
				"meta_keywords" => "varchar(255) DEFAULT NULL",
				"meta_description" => "varchar(255) DEFAULT NULL",
				"created_at" => "timestamp NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{news_elements}}');
		return true;
    }

}