<?php

require_once( __DIR__ . '/../app/config/settings.php' );
require_once( __DIR__ . '/../framework/yiilite.php');

Yii::createWebApplication( __DIR__ . '/../app/config/frontend.php' )->run();
