<?php

class m160304_151526_catalog_filters_category extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{catalog_filters_category}}",
			array(
				"id" => "int(11) NOT NULL AUTO_INCREMENT",
				"name" => "varchar(200) NOT NULL DEFAULT ''",
				"status" => "int(11) NOT NULL DEFAULT '0'",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{catalog_filters_category}}');
		return true;
    }

}