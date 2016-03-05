<?php

class m160304_184220_html_code extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{html_code}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(250) NOT NULL",
				"code" => "text NOT NULL",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-активно 0-не кативно
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{html_code}}');
		return true;
    }

}