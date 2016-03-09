<?php

class m160309_151326_add_columns_catalog_element extends CDbMigration {

	public function up() {
		$this->addColumn('{{catalog_elements}}', 'article', 'varchar(100) NULL AFTER code_3d');
    }

	public function down() {
		$this->dropColumn('{{catalog_elements}}', 'article');
		return true;
    }

}