<?php

class m160304_131832_user extends CDbMigration {

	public function up() {
		$this->createTable(
			"{{user}}",
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"email" => "varchar(254) NOT NULL",
				"username" => "varchar(32) NOT NULL",
				"password" => "varchar(64) DEFAULT NULL",
				"last_name" => "varchar(128) DEFAULT NULL",
				"middle_name" => "varchar(128) DEFAULT NULL",
				"first_name" => "varchar(128) DEFAULT NULL",
				"birthday" => "timestamp NULL DEFAULT NULL",
				"sex" => "tinyint(1) DEFAULT NULL",
				"city_id" => "int(11) unsigned DEFAULT NULL",
				"phone" => "varchar(15) DEFAULT NULL",
				"login_at" => "timestamp NULL DEFAULT NULL",
				"created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				"state" => "tinyint(1) NOT NULL DEFAULT '0'",
				"subscribe" => "tinyint(1) NOT NULL DEFAULT '0'",
				"stype" => "enum('vk','ok','fb','mail','foursquare','twitter','instagram','google') DEFAULT NULL",
				"sid" => "varchar(128) DEFAULT NULL",
				"mail_index" => "int(10) DEFAULT NULL",
				"mail_street" => "varchar(64) DEFAULT NULL",
				"mail_street_house" => "varchar(15) DEFAULT NULL",
				"mail_street_corps" => "varchar(15) DEFAULT NULL",
				"mail_street_apartment" => "varchar(15) DEFAULT NULL",
				"email_group" => "int(11) unsigned DEFAULT NULL",
				"email_accept_time" => "datetime DEFAULT NULL",
				"email_accept_code" => "varchar(32) DEFAULT NULL",
				"role_id" => "varchar(10) DEFAULT NULL",
				"organization" => "varchar(500) DEFAULT NULL",
				"ur_addres" => "varchar(500) DEFAULT NULL",
				"fiz_addres" => "varchar(500) DEFAULT NULL",
				"inn" => "varchar(100) DEFAULT NULL",
				"kpp" => "varchar(100) DEFAULT NULL",
				"okpo" => "varchar(100) DEFAULT NULL",
				"recovery_password_at" => "datetime DEFAULT NULL",
				"recovery_code" => "varchar(32) DEFAULT NULL",
				"balance" => "int(11) DEFAULT '0'",
				"score" => "int(11) unsigned NOT NULL DEFAULT '0'",
				"PRIMARY KEY (id)",
				"UNIQUE KEY uniq_email (email)",
				"KEY fk_user_city (city_id)",
				"KEY user_role_idx (role_id)",
				"KEY idx_username (username)",
				"CONSTRAINT fk_user_city FOREIGN KEY (city_id) REFERENCES tbl_geo_city (id)"
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT"
		);
	}


	public function down() {
		$this->dropTable('{{user}}');
		return true;
	}

}