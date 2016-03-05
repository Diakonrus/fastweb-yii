<?php

class m160304_195331_yandex_map extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{yandex_map}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"coord" => "varchar(50) NOT NULL",
				"description" => "text",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{yandex_map}}');
		return true;
    }

}