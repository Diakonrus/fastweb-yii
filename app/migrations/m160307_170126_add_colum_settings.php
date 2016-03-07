<?php

class m160307_170126_add_colum_settings extends CDbMigration {

	public function up() {
		$this->addColumn('tbl_site_module_settings', 'type_list', 'TINYINT(1) UNSIGNED NOT NULL DEFAULT "1" AFTER `url_form`');
    }

	public function down() {
		$this->dropColumn('tbl_site_module_settings', 'type_list');
		return true;
    }

}