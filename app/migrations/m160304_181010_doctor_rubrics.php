<?php

class m160304_181010_doctor_rubrics extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{doctor_rubrics}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(350) NOT NULL",
				"title" => "varchar(250) DEFAULT NULL",
				"description" => "text",
				"description_short" => "text",
				"url" => "varchar(250) NOT NULL",
				"status" => "tinyint(3) unsigned NOT NULL DEFAULT '1'", //1-активно 0-не активно
				"meta_title" => "varchar(350) DEFAULT NULL",
				"meta_keywords" => "varchar(255) DEFAULT NULL",
				"meta_description" => "varchar(255) DEFAULT NULL",
				"created_at" => "timestamp NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"UNIQUE KEY url (url)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{doctor_rubrics}}');
		return true;
    }

}