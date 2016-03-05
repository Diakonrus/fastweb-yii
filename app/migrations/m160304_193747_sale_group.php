<?php

class m160304_193747_sale_group extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{sale_group}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(350) NOT NULL",
				"title" => "varchar(250) DEFAULT NULL",
				"url" => "varchar(250) NOT NULL",
				"brieftext" => "text",
				"description" => "text",
				"image" => "varchar(50) DEFAULT NULL",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-включено 0-выключено
				"param_design" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-оформление на белом,  2-сером
				"meta_title" => "varchar(250) DEFAULT NULL",
				"meta_keywords" => "varchar(255) DEFAULT NULL",
				"meta_description" => "varchar(255) DEFAULT NULL",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"UNIQUE KEY url (url)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{sale_group}}');
		return true;
    }

}