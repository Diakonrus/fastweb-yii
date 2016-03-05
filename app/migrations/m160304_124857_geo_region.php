<?php

class m160304_124857_geo_region extends CDbMigration {
	public function up() {
		$this->createTable(
			"{{geo_region}}",
			array(
				"id" => "int(11) NOT NULL AUTO_INCREMENT",
				"country_id" => "int(11) NOT NULL",
				"name_ru" => "varchar(50) NOT NULL",
				"name_en" => "varchar(50) NOT NULL",
				"sort" => "int(11) NOT NULL DEFAULT '0'",
				"PRIMARY KEY (id)",
				"KEY sort (sort)",
				"KEY country_id (country_id)",
				"KEY name_ru (name_ru)",
				"KEY name_en (name_en)",
				"CONSTRAINT tbl_geo_region_ibfk_1 FOREIGN KEY (country_id) REFERENCES tbl_geo_country (id) ON DELETE CASCADE ON UPDATE CASCADE",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT"
		);
	}

	public function down() {
		$this->dropTable('{{geo_region}}');
		return true;
	}
}