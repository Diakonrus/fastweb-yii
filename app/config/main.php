<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// Define a path alias for the Bootstrap extension as it's used internally.
// In this example we assume that you unzipped the extension under protected/extensions.




// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.


$base = array(

    'name'=>'Application',
    'language'=>'ru',

    'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'modulePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'../apps/frontend/modules',

    // preloading 'log' component
    'preload'=>array('log'),

    'aliases'=> array('back' => 'application.apps.backend', 'front' => 'application.apps.frontend'),

    // autoloading model and component classes
    'import'=>array(

        'ext.upmc.widgets.*',

        'ext.dbutils.*',
        'ext.sortable.*',
        'ext.ckeditor.*',

        'application.models.*',
        'application.components.*',


        'ext.easyimage.EasyImage',

        //sections
        #'application.apps.frontend.modules.sections.components.*',
        #'application.apps.frontend.modules.sections.models.*',
        #'application.apps.frontend.modules.sections.widgets.*',

        // activities
        //'application.apps.backend.modules.activity.models.*',
        //'application.apps.backend.modules.activity.components.*',

        //voting
        //'application.apps.frontend.modules.votes.models.*',
        //'application.apps.frontend.modules.votes.widgets.*',

        //user
        'application.apps.backend.modules.user.models.*',
        'application.apps.backend.modules.user.components.*',
        'application.apps.frontend.modules.user.forms.*',
    ),



);
$modules = array(
    'modules'=>array(

        'gii'=>array(

            'class'=>'system.gii.GiiModule',
            'password'=>'12345',
            'ipFilters' => explode(' ', GII_IPFILTERS),

            'generatorPaths'=>array(
                'ext.upmc.gii',
                'ext.yiibooster.gii'
            ),
        ),

        // Oauth install
        'oauth' => array(
            'apps' => array(

            )
        ),

        // Yandex search install
        #'yandexsearch' => array(
        #    'server' => YANDEX_SERVER_HOST,
        #),

        'files' => array(
            'uploadImagePath' => dirname(__FILE__).'/../../www/uploads/images',
            'uploadImageUrl' => '/uploads/images',
        ),

    ),

);


//Получаем модули
$dirUrl =  __DIR__ ."/../apps/backend/modules";
$dir = opendir($dirUrl);
while($module = readdir($dir)) {
    if (is_dir($dirUrl.'/'.$module) && $module != '.' && $module != '..') {
        $modules['modules'][$module] = array();
    }
}
$dirUrl =  __DIR__ ."/../apps/frontend/modules";
$dir = opendir($dirUrl);
while($module = readdir($dir)) {
    if (is_dir($dirUrl.'/'.$module) && $module != '.' && $module != '..') {
        $modules['modules'][$module] = array();
    }
}


$components = array(
    'components'=>array(

        # Сервис работы с настройками, устанавливаемыми в админке
        'setting' => array(
            'class' => 'back.modules.setting.components.SettingService',
        ),

        'format' => array(
            'dateFormat' => 'd.m.Y'
        ),

        # Сервис отправки почты SMTP
        'mailer'=>array(
            'class'=>'MailService',
            'pathViews' => 'application.views.backend.email',
            'pathLayouts' => 'application.views.email.backend.layouts'
        ),

        /*
                'Smtpmail'=>array(
                    'class'=>'application.extensions.smtpmail.PHPMailer',
                    'Host'=>"localhost",
                    'Username'=>'test@yourdomain.com',
                    'Password'=>'',
                    'Mailer'=>'smtp',
                    'Port'=>26,
                    'SMTPAuth'=>true,
                ),
        */

        # Сервис создания excel документа
        'excel'=>array(
            'class'=>'ExcelService',
        ),

        # Сервис запросов curl
        'curl' => array(
            'class' => 'CurlService',
            'timeout' => 5,
        ),

        # сервис работы с изображения (уменьшение, crop и т.п.)
        'image' => array(
            'class' => 'ImageService',
        ),
        # Сервис хелпер с популярными методами (форма слова и т.п.)
        'helper'=>array(
            'class' => 'HelperService'
        ),
        # Сервис генерации контроллера/вьюшки
        'contentcrt'=>array(
            'class' => 'ContentService'
        ),

        # Пользователь и авторизация
        'user'=>array(
            'class' => 'UserWebUser',
            'allowAutoLogin'=>true,
        ),

        'authManager' => array(
            'class' => 'UserAuthManager',
            'defaultRoles' => array('guest'),
        ),

        # Сервис фиксации автивностей пользователя
        'activity' => array(
            'class' => 'ActivityService'
        ),

        # Сервис отправки СМС уведомлений
        'sms' => array(
            'class' => 'SmsService'
        ),

        #Расширение для работы с изображениями
        'easyImage' => array(
            'class' => 'application.extensions.easyimage.EasyImage',
            //'driver' => 'GD',
            //'quality' => 100,
            //'cachePath' => '/assets/easyimage/',
            //'cacheTime' => 2592000,
            //'retinaSupport' => false,
        ),



        # Кеширование memcache (самый эффективный метод, должен быть установлен memcache)
        /*
        'cache'=> array(
            'class'=>'CMemCache',
            'servers'=>array( array( 'host'=>'localhost', 'port'=>11211 )),
            //'useMemcached'=>true,
        ),
        */
        # Кеширование ApcCache (быстрое, должен быть установлен apc)
        /*
        'cache'=> array(
            'class'=>'CApcCache',
        ),
        */

        # Файловое кеширование (медленное)
        /*
        'cache'=>array(
            'class'=>'system.caching.CFileCache'
        ),
        */

        # Memcache/Apc сессия (быстро, рекомендуется)
        # На сервер должна быть выключена опция session_auto_start, иначе будет глючить вход в админку
        /*
		'session' => array(
			'class' => 'system.web.CCacheHttpSession',
            'cacheID' => 'cache',
            // Сессия не стартует для каждого, только для авторизованных пользователей!
            'autoStart' => false,
		),
        */
        # Database сессия (медленная)
        /*
        'session' => array(
            'class' => 'system.web.CDbHttpSession',
            'connectionID' => 'db',
            'autoStart' => false,
            'autoCreateSessionTable' => true,
            'sessionTableName' => 'tbl_session',
            'sessionName' => 'YII',
        ),
        */

        // Url
        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName' => false,
            //'rules'=>array(),
        ),

        # Настройки базы данных
        'db'=>array(

            'connectionString' => 'mysql:host=' . DB_HOST . ';dbname=' . DB_DBNAME,
            'username' => DB_USERNAME,
            'password' => DB_PASSWORD,

            'tablePrefix' => 'tbl_',
            'charset' => 'utf8',

            // perfomance
            'emulatePrepare' => false,
            'autoConnect' => false,
            'schemaCachingDuration' => DB_SCHEME_CACHETIME,
            'enableProfiling'=> DEBUG_PANEL ? true : false,
            'enableParamLogging'=> DEBUG_PANEL ? true : false,
        ),

        # Выдает панель с дебагом действий системы ( активно при включенном debug_mode )
        'log'=>array(
            'class'=>'CLogRouter',
            'enabled' => DEBUG_PANEL,
            'routes'=>array(
                array(
                    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    # выводится только для ip из списка
                    'ipFilters' => explode(' ', DEBUG_IPFILTERS),
                ),
            ),
        ),

        'pdf' => array(
            'class'         => 'PDFService',
        ),

        'ePdf' => array(
            'class'         => 'application.components.PDFService.yii-pdf.EYiiPdf',
            'params'        => array(
                'HTML2PDF' => array(
                    'librarySourcePath' => 'application.components.PDFService.html2pdf.*',
                    'classFile'         => 'html2pdf.class.php',
                )
            ),
        ),


        # Отображает лог системных данных внизу страницы
        /*
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CWebLogRoute',
                ),
            ),
        ),
        */

        # Обычное файловое логирование
        /*
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
        */

    ),
);

$result = array_merge($base, $modules, $components);

return $result;
