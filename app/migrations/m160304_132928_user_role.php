<?php

class m160304_132928_user_role extends CDbMigration  {

	public function up() {
		$this->createTable(
			"{{user_role}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(150) NOT NULL",
				"description" => "varchar(150) NOT NULL",
				"access_level" => "tinyint(1) NOT NULL DEFAULT '1'",
				"PRIMARY KEY (id)",
				"UNIQUE KEY descriptions (description)",
				"UNIQUE KEY name (name)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
	}

	public function down() {
		$this->dropTable('{{user_role}}');
		return true;
	}

}