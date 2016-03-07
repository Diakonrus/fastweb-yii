<?php

class m160307_170126_add_colum_settings extends CDbMigration {

	public function up() {
		$this->addColumn('{{site_module_settings}}', 'type_list', 'TINYINT(1) UNSIGNED NOT NULL DEFAULT "1" AFTER `url_form`');
    }

	public function down() {
		$this->dropColumn('{{site_module_settings}}', 'type_list');
		return true;
    }

}