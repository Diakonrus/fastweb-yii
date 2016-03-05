<?php

class m160304_135635_basket_items extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{basket_items}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"basket_order_id" => "int(11) unsigned NOT NULL",
				"module" => "varchar(350) DEFAULT NULL",
				"url" => "varchar(350) DEFAULT NULL",
				"item" => "int(11) DEFAULT NULL", //товар
				"quantity" => "int(11) DEFAULT '0'", //количество
				"price" => "decimal(10,2) unsigned DEFAULT '0.00'", //Цена (со скидкой если она предоставлена)
				"trueprice" => "decimal(10,2) unsigned DEFAULT '0.00'", //Реальная цена на товар
				"comments" => "text",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY FK_tbl_basket_items_tbl_basket_order (basket_order_id)",
				"CONSTRAINT FK_tbl_basket_items_tbl_basket_order FOREIGN KEY (basket_order_id) REFERENCES tbl_basket_order (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
	}

	public function down() {
		$this->dropTable('{{basket_items}}');
		return true;
	}

}