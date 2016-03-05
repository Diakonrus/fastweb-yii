<?php

class m160304_154037_catalog_rubrics extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{catalog_rubrics}}",
			array(
				"id" => "bigint(20) NOT NULL AUTO_INCREMENT",
				"parent_id" => "bigint(20) NOT NULL",
				"left_key" => "int(10) unsigned DEFAULT '0'",
				"right_key" => "int(10) unsigned DEFAULT '0'",
				"level" => "bigint(20) NOT NULL",
				"name" => "varchar(250) NOT NULL",
				"title" => "varchar(250) DEFAULT NULL",
				"description" => "text",
				"description_short" => "text",
				"url" => "varchar(220) NOT NULL",
				"status" => "tinyint(4) NOT NULL DEFAULT '1'",
				"meta_title" => "varchar(250) NOT NULL",
				"meta_keywords" => "varchar(255) NOT NULL",
				"meta_description" => "varchar(255) NOT NULL",
				"execute" => "tinyint(4) NOT NULL",
				"fkey" => "varchar(250) CHARACTER SET cp1251 DEFAULT NULL",
				"PRIMARY KEY (id)",
				"KEY left_key (left_key,level,right_key)",
				"KEY left_key_2 (left_key,right_key,level)",
				"KEY parent_id (parent_id)",
				"KEY status (status)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{catalog_rubrics}}');
		return true;
    }

}