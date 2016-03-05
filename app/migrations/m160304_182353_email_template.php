<?php

class m160304_182353_email_template extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{email_template}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(350) NOT NULL",
				"body" => "text NOT NULL",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{email_template}}');
		return true;
    }

}