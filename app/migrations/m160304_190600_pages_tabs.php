<?php

class m160304_190600_pages_tabs extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{pages_tabs}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"order_id" => "int(11) NOT NULL DEFAULT '0'", //Порядок вывода
				"pages_id" => "int(11) unsigned NOT NULL",
				"site_module_id" => "int(11) unsigned NOT NULL", //Используемый модуль
				"site_module_value" => "varchar(350) NOT NULL", //выбраное id элементов - пишутся через |
				"template_id" => "int(11) unsigned NOT NULL", //Оформление
				"title" => "varchar(350) DEFAULT NULL",
				"description" => "text",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY pages_id (pages_id)",
				"KEY tabs_id (site_module_id)",
				"KEY template_id (template_id)",
				"KEY site_module_value (site_module_value(255))",
				"KEY title (title(255))"
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{pages_tabs}}');
		return true;
    }

}