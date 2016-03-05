<?php

class m160304_154926_creating_form_elements extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{creating_form_elements}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"parent_id" => "int(11) unsigned NOT NULL",
				"order_id" => "int(11) unsigned NOT NULL DEFAULT '0'",
				"name" => "varchar(250) NOT NULL",
				"feeld_type" => "int(11) unsigned NOT NULL",
				"feeld_value" => "varchar(350) DEFAULT NULL",
				"feeld_require" => "tinyint(1) unsigned NOT NULL",
				"feeld_template" => "text",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'",
				"creating_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY parent_id (parent_id)",
				"KEY order_id (order_id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{creating_form_elements}}');
		return true;
    }

}