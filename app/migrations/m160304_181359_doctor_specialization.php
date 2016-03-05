<?php

class m160304_181359_doctor_specialization extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{doctor_specialization}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"doctor_rubrics_id" => "int(11) unsigned NOT NULL",
				"doctor_elements_id" => "int(11) unsigned NOT NULL",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY FK_tbl_doctor_specialization_tbl_doctor_rubrics (doctor_rubrics_id)",
				"KEY FK_tbl_doctor_specialization_tbl_doctor_elements (doctor_elements_id)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{doctor_specialization}}');
		return true;
    }

}