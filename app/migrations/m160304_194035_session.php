<?php

class m160304_194035_session extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{session}}",
			array(
				"id" => "char(32) NOT NULL",
				"expire" => "int(11) DEFAULT NULL",
				"data" => "longblob",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{session}}');
		return true;
    }

}