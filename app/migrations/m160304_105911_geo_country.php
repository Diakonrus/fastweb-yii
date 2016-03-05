<?php

class m160304_105911_geo_country extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{geo_country}}",
			array(
				"id" => " int(11) NOT NULL AUTO_INCREMENT",
				"name_ru" => "varchar(50) NOT NULL",
				"name_en" => "varchar(50) NOT NULL",
				"code" => "varchar(5) NOT NULL",
				"sort" => "int(11) NOT NULL DEFAULT '0'",
				"PRIMARY KEY (id)",
				"KEY sort (sort)",
				"KEY name_ru (name_ru)",
				"KEY name_en (name_en)",
				"KEY code (code)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT"
		);
	}

	public function down() {
		$this->dropTable('{{geo_country}}');
		return true;
	}

}