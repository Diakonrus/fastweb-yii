<?php

class {ClassName} extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{}}",
			array(
				"" => "",

			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{}}');
		return true;
    }

}