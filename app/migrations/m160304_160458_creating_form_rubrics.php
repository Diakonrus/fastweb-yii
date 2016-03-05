<?php

class m160304_160458_creating_form_rubrics extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{creating_form_rubrics}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"name" => "varchar(250) NOT NULL",
				"subject_recipient" => "varchar(350) NOT NULL",
				"email_recipient" => "varchar(350) NOT NULL",
				"complete_mess" => "varchar(450) DEFAULT NULL",
				"form_template" => "text",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'",
				"creating_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY status (status)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{creating_form_rubrics}}');
		return true;
    }

}