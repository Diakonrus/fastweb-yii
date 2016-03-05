<?php

class m160304_191558_photo_template extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{photo_template}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(350) NOT NULL",
				"val" => "text NOT NULL",
				"active" => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)"
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{photo_template}}');
		return true;
    }

}