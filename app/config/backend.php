<?php

Yii::setPathOfAlias('bootstrap', realpath( dirname(__FILE__).'/../extensions/yiibooster-admin' ) );

return CMap::mergeArray(

	require_once(dirname(__FILE__).'/main.php'),

    array(

        'preload' => array('bootstrap'),

	    'import'=>array(
		    'application.apps.backend.components.*',
            'application.apps.backend.behaviors.*',

            'ext.backendfilter.*',
        ),

        // стандартный контроллер
        'defaultController' => 'user',
        'viewPath' => __DIR__ . '/../apps/backend/views',
        'modulePath' => __DIR__ . '/../apps/backend/modules',

        'modules' => array(
            'filemanager' => array(),
        ),

        // компоненты
        'components'=>array(

            // пользователь
            'user'=>array(
                'allowAutoLogin' => true,
                'loginUrl'=>array('/login'),
            ),

            'session' => array(
                'SessionName' => 'ADMSESSID',
            ),

            // Добавляем jquery нужной версии
            // Для добавления скриптов используем следующий код в общем контроллере (лейауте)
            // Yii::app()->clientScript->registerCoreScript('jquery.ui')
            'clientScript'=>array(
                'packages'=>array(
                    'jquery'=>array(
                        'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jquery/1.9.1/',
                        'js'=>array('jquery.min.js'),
                    ),
                    'jquery.ui'=>array(
                        'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/',
                        'js'=>array('jquery-ui.min.js'),
                    ),
                    'glyphicons'=>array(
                        'baseUrl' => '/admin',
                        'css' => array(
                            'css/glyphicons.css'
                        )
                    )
                ),
            ),

			// uncomment the following to enable URLs in path-format
			'urlManager'=>array(
				'urlFormat'=>'path',
				'showScriptName' => false,
                'appendParams'=>false,
				'rules'=>array(
				    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                    '/login' => '/user/login',
                    'simpletree' => 'admin/gallery/photo/simpletree',
                ),
			),

			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
                    /*array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'trace, info, profile',
                        'categories'=>'system.*',
                    ),*/
					array(
						'class' => 'CWebLogRoute',
						'categories' => 'application',
						'levels'=>'error, warning, trace, profile, info',
					),
			    ),
		    ),

            // mailer
            'mailer'=>array(
                'pathViews' => 'application.views.backend.email',
                'pathLayouts' => 'application.views.email.backend.layouts'
            ),

            'bootstrap'=>array(
                'class'=>'application.extensions.yiibooster-admin.components.Bootstrap',
            ),



        ),
    )
);
