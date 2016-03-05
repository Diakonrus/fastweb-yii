<?php

/**
 * Инсталяция дампа БД
 *
 * Class InstallCommand
 */
class InstallCommand extends CConsoleCommand {

    public function run($args) {
        $path = __DIR__ . '/../migrations/data';
        if (!file_exists($path)) {
            echo "\r\n\r\nDirectory with dump no exists\r\n\r\n";
            Yii::app()->end();
        } else {
            echo "\r\n\r\nInstallation started\r\n\r\n";
        }
        $handle = opendir($path);
        while( ($file=readdir($handle)) !== false ) {
            $filePath = $path;
            if ($file === '.' || $file === '..') {
                continue;
            }
            $filePath .= '/' . $file;
            $fileData = file($filePath);
            echo "\r\nDumping " . $file;
            if (!empty($fileData)) {
                foreach ($fileData as $lineData) {
                    Yii::app()->db->createCommand($lineData)->execute();
                }
            }
        }
        closedir($handle);
        echo "\r\n\r\nAll rows have been inserted\r\n\r\n";
    }

}