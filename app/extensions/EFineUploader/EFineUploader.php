<?php
/**
 * EFineUploader class file.
 * This extension is a wrapper of https://github.com/Widen/fine-uploader
 *
 * @author Vladimir Papaev <kosenka@gmail.com>
 * @version 0.1
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
        How to use:

        view:
$this->widget('ext.EFineUploader.EFineUploader',
 array(
       'id'=>'FineUploader',
       'config'=>array(
               'autoUpload'=>true,
               'request'=>array(
                                'endpoint'=>'/files/upload',// OR $this->createUrl('files/upload'),
                                'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                               ),
               'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
               'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
               'callbacks'=>array(
                                  'onComplete'=>"js:function(id, name, response){  }",
                                  //'onError'=>"js:function(id, name, errorReason){ }",
                                 ),
               'validation'=>array(
                                   'allowedExtensions'=>array('jpg','jpeg'),
                                   'sizeLimit'=>2 * 1024 * 1024,//maximum file size in bytes
                                   'minSizeLimit'=>2*1024*1024,// minimum file size in bytes
                                  ),
               'messages'=>array(
                                 'typeError'=>"Файл {file} имеет неверное расширение. Разрешены файлы только с расширениями: {extensions}.",
                                 'sizeError'=>"Размер файла {file} велик, максимальный размер {sizeLimit}.",
                                 'minSizeError'=>"Размер файла {file} мал, минимальный размер {minSizeLimit}.",
                                 'emptyError'=>"{file} is empty, please select files again without it.",
                                 'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                ),
              )
      ));

        controller:

        public function actionUpload()
        {
                $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';

                mkdir($tempFolder, 0777, TRUE);
                mkdir($tempFolder.'chunks', 0777, TRUE);

                Yii::import("ext.EFineUploader.qqFileUploader");

                $uploader = new qqFileUploader();
                $uploader->allowedExtensions = array('jpg','jpeg');
                $uploader->sizeLimit = 2 * 1024 * 1024;//maximum file size in bytes
                $uploader->chunksFolder = $tempFolder.'chunks';

                $result = $uploader->handleUpload($tempFolder);
                $result['filename'] = $uploader->getUploadName();
                $result['folder'] = $webFolder;

                $uploadedFile=$tempFolder.$result['filename'];

                header("Content-Type: text/plain");
                $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
                echo $result;
                Yii::app()->end();
        }

*/
class EFineUploader extends CWidget
{
    public $version="3.4.1";
    public $id="fineUploader";
	public $config=array();
	public $css=null;
    public $htmlOptions = array();

    public function run(){

        if(empty($this->config['request']['endpoint'])){
            throw new CException('EFineUploader: param "request::endpoint" cannot be empty.');
        }

		if(!is_array($this->config['validation']['allowedExtensions'])){
		    throw new CException('EFineUploader: param "validation::allowedExtensions" must be an array.');
        }

		if(empty($this->config['validation']['sizeLimit'])){
		    throw new CException('EFineUploader: param "validation::sizeLimit" cannot be empty.');
        }

        unset($this->config['element']);

        echo CHtml::openTag('div', array_merge($this->htmlOptions, array('id'=>$this->id)));
        echo '<noscript><p>Please enable JavaScript to use file uploader.</p></noscript>';
        echo CHtml::closeTag('div');

		$assets = dirname(__FILE__).'/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);

        $fJs = (YII_DEBUG) ? $baseUrl."/jquery.fineuploader-{$this->version}.js" : $baseUrl."/jquery.fineuploader-{$this->version}.min.js";

        Yii::app()->clientScript->registerScriptFile($fJs, CClientScript::POS_HEAD);

        $this->css=(!empty($this->css))?$this->css:$baseUrl."/fineuploader-{$this->version}.css";
        Yii::app()->clientScript->registerCssFile($this->css);

		$config = array(

            'element'=>'js:document.getElementById("'.$this->id.'")',
            'debug'=>false,
            'multiple'=>false,

            'messages'=>array(
                 'tooManyItemsError'=>'Too many items error',
                 'typeError'=>"Файл {file} имеет неверное расширение. Разрешены файлы только с расширениями: {extensions}.",
                 'sizeError'=>"Размер файла {file} велик, максимальный размер {sizeLimit}.",
                 'minSizeError'=>"Размер файла {file} мал, минимальный размер {minSizeLimit}.",
                 'emptyError'=>"{file} is empty, please select files again without it.",
                 'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
            ),

            'text' => array(
                'uploadButton' => '<div><i class="icon-upload icon-white"></i> Загрузить</div>'
            ),

            'template' => '<div class="qq-uploader span12" style="margin: 0px">' .
                  '<pre class="qq-upload-drop-area span12"><span>{dragZoneText}</span></pre>' .
                  '<div class="qq-upload-button btn btn-success" style="width: auto;">{uploadButtonText}</div>' .
                  '<span class="qq-drop-processing"><span>{dropProcessingText}</span><span class="qq-drop-processing-spinner"></span></span>' .
                  '<ul class="qq-upload-list" style="margin-top: 10px; margin-bottom: 10px; text-align: center;"></ul>' .
                '</div>',

        );

		$config = array_merge($config, $this->config);
		$config['params']= isset($postParams) ? $postParams : array();

		$config = CJavaScript::encode($config);
        Yii::app()->getClientScript()->registerScript("FineUploader_".$this->id, "var FineUploader_".$this->id." = new qq.FineUploader($config);",CClientScript::POS_LOAD);
	}
}