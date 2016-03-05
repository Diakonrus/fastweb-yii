<?php

class m160304_194149_site_module extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{site_module}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(250) NOT NULL", //Название модуля
				"url_to_controller" => "varchar(550) DEFAULT NULL", //Путь к контроллеру на фронте
				"description" => "varchar(450) DEFAULT NULL", //Описание
				"templates" => "varchar(250) DEFAULT NULL", //название темплейта содержащий контроллер, вьюшку
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"UNIQUE KEY name (name)",
				"UNIQUE KEY templates (templates)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{site_module}}');
		return true;
    }

}