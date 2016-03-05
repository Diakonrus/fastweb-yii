<?php

class m160304_133312_user_session extends CDbMigration  {

	public function up() {
		$this->createTable(
			"{{user_session}}",
			array(
				"id" => "char(32) NOT NULL",
				"expire" => "int(11) DEFAULT NULL",
				"data" => "longblob",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT"
		);
	}

	public function down() {
		$this->dropTable('{{user_session}}');
		return true;
	}

}