<?php

class m160304_141845_before_after_rubrics extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{before_after_rubrics}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(350) NOT NULL",
				"parent_id" => "int(11) unsigned NOT NULL DEFAULT '0'",
				"level" => "int(11) unsigned NOT NULL",
				"left_key" => "int(11) unsigned NOT NULL",
				"right_key" => "int(11) unsigned NOT NULL",
				"url" => "varchar(250) NOT NULL",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-активно 0 -нет
				"description" => "text",
				"meta_title" => "varchar(250) DEFAULT NULL",
				"meta_keywords" => "varchar(255) DEFAULT NULL",
				"meta_description" => "varchar(255) DEFAULT NULL",
				"created_at" => "timestamp NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"UNIQUE KEY url (url)",
				"KEY left_key (left_key)",
				"KEY right_key (right_key)",
				"KEY level (level)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{before_after_rubrics}}');
		return true;
    }

}