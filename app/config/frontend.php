<?php


Yii::setPathOfAlias('bootstrap', realpath( dirname(__FILE__).'/../extensions/yiibooster' ) );


/* стандартные контроллеры */
$url = array(

    //'/' => 'user/login/index',
    //'/' => 'content/default/index',

    //ajax
    '/ajax' => 'content/ajax',

    // регистрация
    'registration' => 'user/registration/index',
    'registration/success' => 'user/registration/success',


    //каталог
    '/catalog' => '/catalog/catalog/index',
    '/catalog/<param:.+>' => '/catalog/catalog/list',


    //Профиль
    '/register' => 'user/registration/index',
    '/register/success' => 'user/registration/success',
    '/login/restore' => 'user/registration/recovery',
    '/recoverypassword/<key>' => 'user/registration/resetPassword/key/<key>',
    '/cabinet' => 'user/profile/index',
    '/cabinet/settings' => 'user/profile/settings',
    '/cabinet/profile' => 'user/profile/profile',

    //авторизация
    'login' => 'user/login/login',

    //Выход
    'logout' => 'user/login/logout',



    // captcha
    '/user/registration/captcha_registration',
    '/user/registration/captcha_recovery',
    '/activity/code/captcha_code',
    '/feedback/default/captcha',

    '/noaccess' => 'content/default/noaccess',

    //news
    '/news' => '/news/news',
    '/news/<key>' => 'news/news/news/key/<key>',

    //карта сайта
    '/sitemap' => '/sitemap/sitemap',

    //поиск на сайте
    '/siteserch' => '/siteserch/siteserch',

    //Корзина
    '/basket' => 'content/basket/index',
    '/basket/success' => 'content/basket/success',

    //фотоальбом
    '/photo' => '/photo/photo',
    'photo/<param:.+>' => '/photo/photo/element',

    //Вопрос-ответ
    '/question' => '/question/question',
    'question/<param:.+>' => '/question/question/element',
    '<param:.+>/question' => '/question/question/element',

    //Отзывы
    '/review' => '/review/review',
    'review/<param:.+>' => '/review/review/element',
    '<param:.+>/review' => '/review/review/element',

    //Статьи
    '/article' => '/article/article',
    'article/<param:.+>' => '/article/article/element',
    '<param:.+>/article' => '/article/article/element',

    //Проверка данных формы
    '/send-form' => '/content/default/index',


    //Врачи
    '/doctor' => '/doctor/doctor',
    'doctor/<param:.+>' => '/doctor/doctor/element',
    //До и После
    '/beforeafter' => '/beforeafter/beforeafter',
    'beforeafter/<param:.+>' => '/beforeafter/beforeafter/element',
    //Пресса
    '/press' => '/press/press',
    'press/<param:.+>' => '/press/press/element',
    //Мои сконструированые формы
    '/apply_auto_form' => '/forms/forms',



    //Стандартная обработка URL
    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
    '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
    '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',



);
/* подключаем созданые страницы */
$url =  CMap::mergeArray(
    require_once(dirname(__FILE__).'/pages.php'),
    $url
);



return CMap::mergeArray(

    require_once(dirname(__FILE__).'/main.php'),

    array(


        'preload' => array('bootstrap'),

        'viewPath' => __DIR__ . '/../apps/frontend/views',
        'modulePath' => __DIR__ . '/../apps/frontend/modules',

	    'import'=>array(
		    'application.apps.frontend.components.*',
		    'application.extensions.*',
        ),

        // компоненты
        'components'=>array(

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
                ),
            ),

            // uncomment the following to enable URLs in path-format

            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName' => false,
                'useStrictParsing'=>true,
                #'class' => 'UrlManager',
                'rules'=>$url
            ),


            // mailer
            'mailer'=>array(
                'pathViews' => 'application.views.backend.email',
                'pathLayouts' => 'application.views.email.backend.layouts'
            ),
            //подключение bootstrap - если не нужно, закоментировать

            /*
            'bootstrap'=>array(
                'class'=>'application.extensions.yiiboosterfront.components.Bootstrap',
            ),
            */


        ),

        // frontend модули
        'modules' => array(
		    'oauth' => array(),
        ),

    )
);
