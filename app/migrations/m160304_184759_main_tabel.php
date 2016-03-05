<?php

class m160304_184759_main_tabel extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{main_tabel}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(350) NOT NULL",
				"description" => "text NOT NULL",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)"
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{main_tabel}}');
		return true;
    }

}