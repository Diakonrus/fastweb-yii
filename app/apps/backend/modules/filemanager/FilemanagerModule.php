<?php

class FilemanagerModule extends Module
{
	public $defaultController = 'file';

    public function clientOptions($initialOptions = array()) {
        return CMap::mergeArray(array(
            'clientOptions' => array(
                'lang' => "ru",
                'resizable' => false,
                //'wysiwyg' => "ckeditor"
                //'onlyMimes'    => array('image'),
            ),
            'connectorRoute' => "/filemanager/file/connector",
            'connectorOptions' => array(
                'roots' => array(
                    array(
                        'driver'  => "LocalFileSystem",
                        'path' => FILEANAGER_ROOT,
                        'URL' => FILEANAGER_WEBROOT,
                        'tmbPath' => FILEANAGER_ROOT . DIRECTORY_SEPARATOR . ".thumbs",

                        'accessControl' => "access",
                        'dotFiles' => false,

                        'mimeDetect' => "auto",

                        // Upload mime types control
                        //'uploadOrder' => 'deny, allow',
                        //'uploadDeny' => array('php'),
                        //'uploadAllow' => array('image'),

                        'attributes' => array(
                            array(
                                'pattern' => '/^\/\./',
                                'read' => false,
                                'write' => false,
                                'hidden' => true,
                                'locked' => true
                            )
                        ),
                    )
                ),

            )
        ), $initialOptions);
    }

	public function init()
	{
		$this->setImport(array(
			'application.apps.frontend.modules.feedback.models.*',
			'application.apps.frontend.modules.feedback.components.*',
		));

	}

	public function beforeControllerAction($controller, $action)
	{
	    // Module menu
	    /*
        Yii::app()->controller->menu = array(

            array('label'=> Yii::app()->controller->t('FEEDBACK_MANAGE'),'url'=>array('/feedback/feedback/admin') ),

            false,
            array('label' => Yii::app()->controller->t('SUBJECT_MANAGE'), 'url' => array('/feedback/subject/admin')),
            array('label' => 'Новая тема', 'url' => array('/feedback/subject/create')),

            false,
            array('label' =>  Yii::app()->controller->t('STATUS_MANAGE'), 'url' => array('/feedback/status/admin')),
            array('label' => 'Новый статус', 'url' => array('/feedback/status/create')),

        );*/

		return parent::beforeControllerAction($controller, $action) ? true : false;
	}
}
