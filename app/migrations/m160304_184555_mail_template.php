<?php

class m160304_184555_mail_template extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{mail_template}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"subject" => "varchar(450) NOT NULL", //Тема письма
				"body" => "text NOT NULL", //Текст письма
				"type" => "tinyint(2) unsigned NOT NULL", //1-шаблон при регистрации
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{mail_template}}');
		return true;
    }

}