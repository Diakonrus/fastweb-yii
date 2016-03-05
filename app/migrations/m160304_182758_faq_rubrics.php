<?php

class m160304_182758_faq_rubrics extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{faq_rubrics}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
			    "parent_id" => "int(11) unsigned NOT NULL DEFAULT '0'",
			    "left_key" => "int(11) unsigned NOT NULL",
			    "level" => "int(11) unsigned NOT NULL",
			    "right_key" => "int(11) NOT NULL",
			    "name" => "varchar(350) NOT NULL",
			    "title" => "varchar(250) DEFAULT NULL",
			    "url" => "varchar(250) DEFAULT NULL",
			    "description" => "text",
			    "description_short" => "text",
			    "status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-включено 0-выключено
			    "meta_title" => "varchar(250) DEFAULT NULL",
			    "meta_keywords" => "varchar(255) DEFAULT NULL",
			    "meta_description" => "varchar(255) DEFAULT NULL",
			    "created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"UNIQUE KEY url (url)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{faq_rubrics}}');
		return true;
    }

}