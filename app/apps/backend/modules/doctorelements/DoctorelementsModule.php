<?php

class DoctorelementsModule extends Module
{
    public $defaultController = 'doctorelements';

	public function init()
	{
		
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'doctorelements.models.*',
			'doctorelements.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
	    Yii::app()->controller->menu = array(
            array('label'=>Yii::t('Bootstrap', 'LIST.DoctorElements'), 'url'=>array('index'), 'active' => $action->id === 'index' ),
            array('label'=>Yii::t('Bootstrap', 'CREATE.DoctorElements'), 'url'=>array('create'), 'active' => $action->id === 'create' ),
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
