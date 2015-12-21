<?php

class UserModule extends CWebModule {

    public $defaultController = 'registration';

	public function init() {
		$this->setImport(array(
			'user.models.*',
			'user.components.*',
			'user.forms.*',
		));
	}
}
