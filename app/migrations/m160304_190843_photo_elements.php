<?php

class m160304_190843_photo_elements extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{photo_elements}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"parent_id" => "int(11) unsigned NOT NULL",
				"name" => "varchar(450) DEFAULT NULL",
				"image" => "varchar(50) DEFAULT NULL",
				"description" => "text",
				"url" => "varchar(450) DEFAULT NULL",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-активно 0-не активно
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{photo_elements}}');
		return true;
    }

}