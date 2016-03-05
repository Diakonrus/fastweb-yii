<?php

class m160304_125454_geo_city extends CDbMigration {
	public function up() {
		$this->createTable(
			"{{geo_city}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"country_id" => "int(11) NOT NULL",
				"region_id" => "int(11) NOT NULL",
				"name_ru" => "varchar(50) NOT NULL",
				"name_en" => "varchar(50) NOT NULL",
				"sort" => "int(11) NOT NULL DEFAULT '0'",
				"PRIMARY KEY (id)",
				"KEY sort (sort)",
				"KEY country_id (country_id)",
				"KEY region_id (region_id)",
				"KEY name_ru (name_ru)",
				"KEY name_en (name_en)",
				"CONSTRAINT tbl_geo_city_ibfk_1 FOREIGN KEY (country_id) REFERENCES tbl_geo_country (id) ON DELETE CASCADE ON UPDATE CASCADE",
				"CONSTRAINT tbl_geo_city_ibfk_2 FOREIGN KEY (region_id) REFERENCES tbl_geo_region (id) ON DELETE CASCADE ON UPDATE CASCADE",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT"
		);
	}

	public function down() {
		$this->dropTable('{{geo_city}}');
		return true;
	}
}