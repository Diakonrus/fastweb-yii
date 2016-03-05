<?php

class m160304_183607_feedback extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{feedback}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"fio" => "varchar(550) NOT NULL",
				"phone" => "varchar(20) NOT NULL",
				"email" => "varchar(550) NOT NULL",
				"question" => "text NOT NULL",
				"answer" => "text",
				"status" => "tinyint(1) NOT NULL DEFAULT '1'", //1-новая 2-отключено
				"answer_at" => "datetime DEFAULT NULL",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)"
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{feedback}}');
		return true;
    }

}