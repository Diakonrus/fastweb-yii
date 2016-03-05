<?php

class m160304_130003_geo_type extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{geo_type}}",
			array(
			    "id" => "int(2) unsigned NOT NULL AUTO_INCREMENT",
                "shortname" => "varchar(255) NOT NULL",
                "level_index" => "int(1) NOT NULL",
                "name" => "varchar(255) NOT NULL",
                "code" => "int(3) NOT NULL",
                "PRIMARY KEY (id)"
            ),
            "ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT"
		);
	}

	public function down() {
		$this->dropTable('{{geo_type}}');
		return true;
	}

}