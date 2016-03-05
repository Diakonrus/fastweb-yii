<?php

class m160304_183320_faq_elements extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{faq_elements}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"parent_id" => "int(11) unsigned NOT NULL",
				"author_id" => "int(11) unsigned DEFAULT NULL",
				"question" => "text NOT NULL",
				"answer" => "text",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-включено 0-выключено
				"question_data" => "date DEFAULT NULL",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY FK_tbl_faq_elements_tbl_faq_rubrics (parent_id)",
				"KEY FK_tbl_faq_elements_tbl_faq_author (author_id)",
				"CONSTRAINT FK_tbl_faq_elements_tbl_faq_author FOREIGN KEY (author_id) REFERENCES tbl_faq_author (id)",
				"CONSTRAINT FK_tbl_faq_elements_tbl_faq_rubrics FOREIGN KEY (parent_id) REFERENCES tbl_faq_rubrics (id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{faq_elements}}');
		return true;
    }

}