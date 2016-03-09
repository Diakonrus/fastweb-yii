<?php

class m160309_155110_add_column_catalog_rubrics extends CDbMigration {

	public function up() {
		$this->addColumn('{{catalog_rubrics}}', 'image', 'varchar(5) NULL');
    }

	public function down() {
		$this->dropColumn('{{catalog_rubrics}}', 'image');
		return true;
    }

}