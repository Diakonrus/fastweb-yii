<?php

class m160304_184352_loadxml_rubrics extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{loadxml_rubrics}}",
			array(
				"id" => "bigint(20) NOT NULL AUTO_INCREMENT",
				"name" => "varchar(250) NOT NULL",
				"status" => "tinyint(4) NOT NULL DEFAULT '1'",
				"module" => "int(10) unsigned NOT NULL",
				"tableadd1" => "varchar(50) NOT NULL",
				"tableadd2" => "varchar(50) NOT NULL",
				"tableadd3" => "varchar(50) NOT NULL",
				"tableadd4" => "varchar(50) NOT NULL",
				"brieftext" => "text NOT NULL",
				"content1" => "text NOT NULL",
				"content_add1" => "text NOT NULL",
				"content_add2" => "text NOT NULL",
				"content_add3" => "text NOT NULL",
				"content_add4" => "text NOT NULL",
				"content_link1" => "text NOT NULL",
				"content_link2" => "text NOT NULL",
				"content_link3" => "text NOT NULL",
				"content_link4" => "text NOT NULL",
				"content_link5" => "text NOT NULL",
				"content2" => "text NOT NULL",
				"groups" => "text NOT NULL",
				"ext" => "varchar(20) NOT NULL",
				"unique" => "varchar(50) NOT NULL",
				"splitter" => "tinyint(3) unsigned NOT NULL",
				"tag" => "varchar(60) NOT NULL",
				"tags" => "varchar(1024) NOT NULL",
				"class" => "varchar(100) NOT NULL",
				"PRIMARY KEY (id)",
				"KEY status (status)",
				"KEY module (module)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{loadxml_rubrics}}');
		return true;
    }

}