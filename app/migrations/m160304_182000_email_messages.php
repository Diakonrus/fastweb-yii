<?php

class m160304_182000_email_messages extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{email_messages}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"user_id" => "int(11) unsigned NOT NULL",
				"to_email" => "varchar(250) NOT NULL",
				"title" => "varchar(250) NOT NULL",
				"body" => "text NOT NULL",
				"status" => "int(1) NOT NULL DEFAULT '0'", //0-не отправлено 1-отправлено
				"template_id" => "int(11) unsigned DEFAULT NULL",
				"send_date" => "datetime NOT NULL",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"type_messages" => "tinyint(1) NOT NULL DEFAULT '1'",
				"PRIMARY KEY (id)",
				"KEY FK_email_messages_tbl_user (user_id)",
				"CONSTRAINT FK_email_messages_tbl_user FOREIGN KEY (user_id) REFERENCES tbl_user (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{email_messages}}');
		return true;
    }

}