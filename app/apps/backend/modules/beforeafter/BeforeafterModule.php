<?php

class BeforeafterModule extends Module
{
    public $defaultController = 'beforeafterrubrics';

	public function init()
	{
		
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'beforeafter.models.*',
			'beforeafter.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
	    Yii::app()->controller->menu = array(
            array('label'=>Yii::t('Bootstrap', 'LIST.BeforeAfterRubrics'), 'url'=>array('index'), 'active' => $action->id === 'index' ),
            array('label'=>Yii::t('Bootstrap', 'CREATE.BeforeAfterRubrics'), 'url'=>array('create'), 'active' => $action->id === 'create' ),
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
