<?php

class m160304_181723_email_group extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{email_group}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(250) NOT NULL",
				"PRIMARY KEY (id)"
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{email_group}}');
		return true;
    }

}