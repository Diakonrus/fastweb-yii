<?php

class m160304_151724_catalog_filters_in_category extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{catalog_filters_in_category}}",
			array(
				"id" => "int(11) NOT NULL AUTO_INCREMENT",
				"id_filter" => "int(11) NOT NULL DEFAULT '0'", //Ссылка на фильтр
				"id_catalog_rubrics" => "int(11) NOT NULL DEFAULT '0'", //Ссылка на категорию
				"position" => "int(11) NOT NULL DEFAULT '0'", //Позиция фильтра в категории
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{catalog_filters_in_category}}');
		return true;
    }

}