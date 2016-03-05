<?php

class m160304_194410_site_module_settings extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{site_module_settings}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"site_module_id" => "int(11) unsigned NOT NULL",
				"version" => "varchar(10) NOT NULL",
				"r_cover_small" => "varchar(50) DEFAULT '100x100'",
				"r_cover_small_crop" => "enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL",
				"r_cover_medium" => "varchar(50) DEFAULT '200x200'",
				"r_cover_medium_crop" => "enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL",
				"r_cover_large" => "varchar(50) NOT NULL DEFAULT '300X300'",
				"r_cover_large_crop" => "enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL",
				"r_cover_quality" => "int(11) DEFAULT '90'",
				"r_small_color" => "varchar(10) NOT NULL DEFAULT 'ffffff'",
				"r_medium_color" => "varchar(10) NOT NULL DEFAULT 'ffffff'",
				"r_large_color" => "varchar(10) NOT NULL DEFAULT 'ffffff'",
				"e_cover_small" => "varchar(50) DEFAULT '100x100'",
				"e_cover_small_crop" => "enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL",
				"e_cover_medium" => "varchar(50) DEFAULT '200x200'",
				"e_cover_medium_crop" => "enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL",
				"e_cover_large" => "varchar(50) NOT NULL DEFAULT '300X300'",
				"e_cover_large_crop" => "enum('Resize','insertResize','exactResize','horResize','verResize') NOT NULL",
				"e_cover_quality" => "int(11) DEFAULT '90'",
				"e_small_color" => "varchar(10) NOT NULL DEFAULT 'ffffff'",
				"e_medium_color" => "varchar(10) NOT NULL DEFAULT 'ffffff'",
				"e_large_color" => "varchar(10) NOT NULL DEFAULT 'ffffff'",
				"elements_page_admin" => "int(11) NOT NULL DEFAULT '20'",
				"watermark" => "varchar(255) NOT NULL",
				"watermark_pos" => "int(11) NOT NULL",
				"watermark_type" => "tinyint(3) unsigned NOT NULL",
				"watermark_transp" => "int(10) unsigned NOT NULL",
				"watermark_color" => "varchar(80) NOT NULL",
				"watermask_font" => "int(10) unsigned NOT NULL",
				"watermask_fontsize" => "varchar(20) NOT NULL",
				"email" => "varchar(200) DEFAULT NULL",
				"url_form" => "tinyint(1) DEFAULT '0'",
				"status" => "tinyint(1) unsigned NOT NULL DEFAULT '1'", //1-активно 0-не активно
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"PRIMARY KEY (id)",
				"KEY site_module_id (site_module_id)",
				"KEY status (status)",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
		);
    }

	public function down() {
	    $this->dropTable('{{site_module_settings}}');
		return true;
    }

}