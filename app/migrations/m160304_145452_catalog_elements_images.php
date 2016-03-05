<?php

class m160304_145452_catalog_elements_images extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{catalog_elements_images}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"elements_id" => "int(11) unsigned NOT NULL",
				"image_name" => "varchar(250) NOT NULL",
				"image" => "char(10) NOT NULL",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{catalog_elements_images}}');
		return true;
    }

}