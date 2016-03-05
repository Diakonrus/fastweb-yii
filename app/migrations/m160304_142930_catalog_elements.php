<?php

class m160304_142930_catalog_elements extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{catalog_elements}}",
			array(
				"id" => "bigint(20) NOT NULL AUTO_INCREMENT",
				"parent_id" => "bigint(20) NOT NULL",
				"order_id" => "bigint(20) NOT NULL",
				"name" => "varchar(250) NOT NULL",
				"brieftext" => "text NOT NULL",
				"status" => "tinyint(4) NOT NULL DEFAULT '1'",
				"ansvtype" => "tinyint(3) unsigned NOT NULL",
				"shares" => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
				"primary" => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
				"url" => "varchar(250) DEFAULT NULL",
				"hit" => "smallint(6) NOT NULL",
				"image" => "varchar(5) NOT NULL",
				"page_name" => "varchar(250) NOT NULL",
				"description" => "text NOT NULL",
				"fkey" => "varchar(250) NOT NULL",
				"code" => "varchar(100) NOT NULL",
				"qty" => "int(10) unsigned DEFAULT NULL",
				"price" => "double DEFAULT '0'",
				"price_old" => "double DEFAULT '0'",
				"price_entering" => "double NOT NULL",
				"code_3d" => "text",
				"PRIMARY KEY (id)",
				"KEY order_id (order_id)",
				"KEY parent_id (parent_id,order_id)",
				"KEY status (status)",
				//"FULLTEXT KEY name (name,page_name,brieftext,description)" //InnoBD не поддерживает
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{catalog_elements}}');
		return true;
    }

}