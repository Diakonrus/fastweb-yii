<?php

class m160304_142436_catalog_chars extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{catalog_chars}}",
			array(
				"id" => "int(20) unsigned NOT NULL AUTO_INCREMENT",
				"parent_id" => "int(20) unsigned DEFAULT NULL",
				"order_id" => "int(20) unsigned NOT NULL DEFAULT '0'",
				"name" => "varchar(250) NOT NULL",
				"scale" => "varchar(550) DEFAULT NULL",
				"inherits" => "tinyint(4) NOT NULL DEFAULT '0'",
				"type_scale" => "int(11) unsigned NOT NULL DEFAULT '1'",
				"type_parent" => "tinyint(1) unsigned NOT NULL DEFAULT '1'",
				"status" => "tinyint(1) NOT NULL DEFAULT '1'",
				"is_deleted" => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY name (name)",
				"KEY parent_id (parent_id)",
				"KEY scale (scale(255))",
				"KEY order_id (order_id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{catalog_chars}}');
		return true;
    }

}