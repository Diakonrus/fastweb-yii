<?php

date_default_timezone_set('Europe/Moscow');

// Вывод ошибок
define('YII_DEBUG', true);
define('YII_TRACE_LEVEL',3);
define('SITE_TITLE','');

ini_set("display_errors", "1");
ini_set("display_startup_errors","1");
ini_set('error_reporting', E_ALL);

// Режим отладки
define('DEBUG_PANEL', true);
define('DEBUG_IPFILTERS', '109.194.67.101');

// Доступы к бд
define('DB_USERNAME', 'user');
define('DB_PASSWORD', 'pass');
define('DB_DBNAME', 'dbname');
define('DB_HOST', 'localhost');
define('DB_SCHEME_CACHETIME', 0);

// Время абсолютного кеширования статических страниц
// Кешируются все get запросы не авторизованного юзера
define('PAGE_CACHETIME', 0);

// Настройки filemanager
define('FILEANAGER_ROOT', dirname(__FILE__) . '/../../www/uploads' );
define('FILEANAGER_WEBROOT', '/uploads');
define('FILEANAGER_FILETYPES', 'jpg jpeg pdf png gif');

// Настройки поискового сервера
define('YANDEX_SERVER_HOST', 'http://upmc.ru:17000/jbaby');

// ip адреса, для доступа в gii, разделенные пробелом
define('GII_IPFILTERS', '109.161.48.80 95.106.171.143 95.31.249.53 ::1 127.0.0.1 92.55.5.232 109.194.67.101 178.46.163.221');

// данные для работы соц. систем
define('SOCIAL_VK_ID', '3608647');
define('SOCIAL_VK_SECRET', 'KUSeHNFkV0v2ytTCfYD0');

define('SOCIAL_OK_ID', '127915264');
define('SOCIAL_OK_SECRET', '508E0625682D64E26F8B500E');
define('SOCIAL_OK_PUBLIC', 'CBAGNQJIABABABABA');

define('SOCIAL_FB_ID', '187320061418825');
define('SOCIAL_FB_SECRET', '3c76e16ea8865d30d5679fa8c1730a33');

define('SOCIAL_MAIL_ID', '709336');
define('SOCIAL_MAIL_PRIVATE', '851017b16b4fc3367d28b0423048f4c2');
define('SOCIAL_MAIL_SECRET', 'b195971c5badab458c851e38fdc3105c');

define('SOCIAL_TWITTER_ID', '5076121');
define('SOCIAL_TWITTER_KEY', '0HPbfbjAQImXhcSCmf2HlA');
define('SOCIAL_TWITTER_SECRET', 'bVF30OsoXbvUa5lFRVvLP0WT8qHevk3tISU2nCPKk');

define('SOCIAL_FOURSQUARE_ID', 'TGLXKC2B5NJHVKLJI5TWB3GDQH31ROHBK1JIDDQBRBCV00H2');
define('SOCIAL_FOURSQUARE_SECRET', 'CH2HUSOG1HX1HASR1TRPSKPWUYNPJ3W0GKQQNOHLK5KUW0EA');

define('SOCIAL_INSTAGRAM_ID', 'f8e3c129456344289b645cba6226c8bc');
define('SOCIAL_INSTAGRAM_SECRET', '7f4799ebd3f14f7797cfa625ba434e3a');

define('SOCIAL_GOOGLEPLUS_ID', '859443960254-9lhildvbbl6moukc47lmokln1l2e5d6m.apps.googleusercontent.com');
define('SOCIAL_GOOGLEPLUS_SECRET', 'pLdQ2LL_ISbpMO-y682P_-kD');

define('SITE_PUBLIC_NAME', ''); //Директория публичной части домена