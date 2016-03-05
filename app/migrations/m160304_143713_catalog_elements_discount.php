<?php

class m160304_143713_catalog_elements_discount extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{catalog_elements_discount}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"element_id" => "bigint(20) NOT NULL",
				"count" => "int(11) unsigned NOT NULL DEFAULT '0'", //Количество
				"values" => "decimal(10,2) unsigned NOT NULL DEFAULT '0.00'", //Значение
				"type" => "tinyint(1) unsigned NOT NULL", //1-Фиксированая 2-В процентах
				"user_role_id" => "int(11) unsigned NOT NULL DEFAULT '0'", //0-Все, остальные значения - применить к группе из списка ролей
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //0-отключен 1-включен
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY element_id (element_id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{catalog_elements_discount}}');
		return true;
    }

}