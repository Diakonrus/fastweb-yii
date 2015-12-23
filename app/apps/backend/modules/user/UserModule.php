<?php

class UserModule extends Module
{
	public $defaultController = 'list';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		$this->setImport(array(
			'user.models.*',
			'user.components.*',
			'user.forms.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
	    Yii::app()->controller->menu = array(
            array('label'=>Yii::t('Bootstrap', 'LIST.User'), 'url'=>array('/user/list/index') ),
            array('label'=>Yii::t('Bootstrap', 'CREATE.User'), 'url'=>array('/user/list/create') ),
        );

		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
