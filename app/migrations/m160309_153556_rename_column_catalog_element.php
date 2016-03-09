<?php

class m160309_153556_rename_column_catalog_element extends CDbMigration {

	public function up() {
		$this->renameColumn("{{catalog_elements}}", "page_name", "title");
    }

	public function down() {
		$this->renameColumn("{{catalog_elements}}", "title", "page_name");
		return true;
    }

}