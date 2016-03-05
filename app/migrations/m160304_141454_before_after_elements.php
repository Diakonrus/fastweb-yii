<?php

class m160304_141454_before_after_elements extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{before_after_elements}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"parent_id" => "int(11) unsigned DEFAULT NULL",
				"before_photo" => "varchar(50) DEFAULT NULL",
				"after_photo" => "varchar(50) DEFAULT NULL",
				"briftext" => "text",
				"before_text" => "text",
				"after_text" => "text",
				"status" => "tinyint(1) unsigned DEFAULT '1'", //1-активно 0 -нет
				"on_main" => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY parent_id (parent_id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{before_after_elements}}');
		return true;
    }

}