<?php

class m160304_135217_basket_order extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{basket_order}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"user_id" => "int(11) unsigned DEFAULT NULL",
				"address" => "varchar(550) DEFAULT NULL",
				"phone" => "varchar(100) DEFAULT NULL",
				"comments" => "text",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '0'", //0-поступление, 1-регистрация
				"status_at" => "datetime DEFAULT NULL",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY FK_tbl_basket_order_tbl_user (user_id)",
				"CONSTRAINT FK_tbl_basket_order_tbl_user FOREIGN KEY (user_id) REFERENCES tbl_user (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{basket_order}}');
		return true;
    }

}