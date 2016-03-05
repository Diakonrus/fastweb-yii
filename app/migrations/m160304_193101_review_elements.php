<?php

class m160304_193101_review_elements extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{review_elements}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"parent_id" => "int(11) unsigned NOT NULL",
				"author_id" => "int(11) unsigned DEFAULT NULL",
				"brieftext" => "text",
				"review" => "text NOT NULL",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-включено 0-выключено
				"review_data" => "date DEFAULT NULL",
				"created_at" => "timestamp NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY FK_tbl_review_elements_tbl_review_rubrics (parent_id)",
				"KEY FK_tbl_review_elements_tbl_review_author (author_id)",
				"CONSTRAINT FK_tbl_review_elements_tbl_review_author FOREIGN KEY (author_id) REFERENCES tbl_review_author (id)",
				"CONSTRAINT FK_tbl_review_elements_tbl_review_rubrics FOREIGN KEY (parent_id) REFERENCES tbl_review_rubrics (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{review_elements}}');
		return true;
    }

}