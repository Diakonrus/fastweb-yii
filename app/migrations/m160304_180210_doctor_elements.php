<?php

class m160304_180210_doctor_elements extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{doctor_elements}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"order_id" => "int(11) unsigned NOT NULL DEFAULT '0'",
				"name" => "varchar(350) NOT NULL",
				"anonse" => "text",
				"anonse_dop" => "text",
				"description" => "text",
				"image" => "varchar(5) DEFAULT NULL",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-активно 0-не активно
				"chief_doctor" => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY order_id (order_id)",
				"KEY name (name(255))",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{doctor_elements}}');
		return true;
    }

}