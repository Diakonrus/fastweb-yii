<?php

class m160304_182525_faq_author extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{faq_author}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(450) DEFAULT NULL",
				"email" => "varchar(450) DEFAULT NULL",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{faq_author}}');
		return true;
    }

}