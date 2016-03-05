<?php

class m160304_131419_geo_item extends CDbMigration {
	public function up() {
		$this->createTable(
			"{{geo_item}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(255) NOT NULL",
				"type_id" => "int(2) NOT NULL",
				"level_1" => "int(3) DEFAULT NULL",
				"level_2" => "int(3) DEFAULT NULL",
				"level_3" => "int(3) DEFAULT NULL",
				"level_4" => "int(3) DEFAULT NULL",
				"level_5" => "int(3) DEFAULT NULL",
				"level_index" => "int(1) NOT NULL",
				"post_index" => "int(6) DEFAULT NULL",
				"PRIMARY KEY (id)"
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT"
		);
	}

	public function down() {
		$this->dropTable('{{geo_item}}');
		return true;
	}
}