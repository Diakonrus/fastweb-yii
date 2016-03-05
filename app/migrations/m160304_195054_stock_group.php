<?php

class m160304_195054_stock_group extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{stock_group}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(350) NOT NULL",
				"description" => "text",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-включено 0-выключено
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{stock_group}}');
		return true;
    }

}