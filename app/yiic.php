<?php
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once(__DIR__ . '/../framework/yii.php');
$config = dirname(__FILE__) . '/config/console.php';


$app = Yii::createConsoleApplication($config);
$app->commandRunner->addCommands(YII_PATH . '/cli/commands');

$env = @getenv('YII_CONSOLE_COMMANDS');
if (!empty($env)) {
    $app->commandRunner->addCommands($env);
}

$app->run();