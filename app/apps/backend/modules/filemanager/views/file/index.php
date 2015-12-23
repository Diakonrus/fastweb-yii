<legend>File Manager</legend>

<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">

<div id="file-uploader" style="margin-bottom: 50px"></div>
<?php
//$this->widget("ext.ezzeelfinder.ElFinderWidget", array(
//    'selector' => "div#file-uploader",
//    'clientOptions' => array(
//        'lang' => "ru",
//        'resizable' => false,
//        //'wysiwyg' => "ckeditor"
//        //'onlyMimes'    => array('image'),
//    ),
//    'connectorRoute' => "/filemanager/file/connector",
//    'connectorOptions' => array(
//        'roots' => array(
//            array(
//                'driver'  => "LocalFileSystem",
//                'path' => FILEANAGER_ROOT,
//                'URL' => FILEANAGER_WEBROOT,
//                'tmbPath' => FILEANAGER_ROOT . DIRECTORY_SEPARATOR . ".thumbs",
//
//                'accessControl' => "access",
//                'dotFiles' => false,
//
//                'mimeDetect' => "auto",
//
//                // Upload mime types control
//                //'uploadOrder' => 'deny, allow',
//                //'uploadDeny' => array('php'),
//                //'uploadAllow' => array('image'),
//
//                'attributes' => array(
//                    array(
//                        'pattern' => '/^\/\./',
//                        'read' => false,
//                        'write' => false,
//                        'hidden' => true,
//                        'locked' => true
//                    )
//                ),
//            )
//        ),
//
//    )
//));

$this->widget("ext.ezzeelfinder.ElFinderWidget", Yii::app()->getModule('filemanager')->clientOptions(array(
    'selector' => "div#file-uploader",
)));

?>