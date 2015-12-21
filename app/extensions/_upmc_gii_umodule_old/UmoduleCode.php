<?php
/**
 * BootstrapCode class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudCode');

class UmoduleCode extends CrudCode
{
	public $moduleID;
	public $controller = '';
    public $isNewModule = false;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('moduleID', 'filter', 'filter'=>'trim'),
			array('moduleID', 'required'),
			array('moduleID', 'match', 'pattern'=>'/^[a-zA-Z_]\w*$/', 'message'=>'{attribute} should only contain word characters.'),
			//array('baseControllerClass', 'validateReservedWord', 'skipOnError'=>true),
			//array('model', 'validateModel'),
			//array('baseControllerClass', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'moduleID'=>'Module ID',
		));
	}

	public function requiredTemplates()
	{
		return array(
			//'controller.php',
		);
	}

    /**
     * Подготовка
     */
     /*
	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;

		// Генерим контроллер
		$controllerTemplateFile = $templatePath . DIRECTORY_SEPARATOR.'controller.php';

		$this->files[]=new CCodeFile(
			$this->controllerFile,
			$this->render($controllerTemplateFile)
		);

        // Генерим остальные файлы шаблонов
		$files=scandir($templatePath);

		foreach($files as $file){

			if( is_file($templatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file !== 'controller.php'){

				$this->files[]=new CCodeFile(
					$this->viewPath.DIRECTORY_SEPARATOR.$file,
					$this->render($templatePath.'/'.$file)
				);
			}
		}
	}*/

	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;
		$modulePath=$this->modulePath;
		$moduleTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'module.php';

        // Файл описывающий модуль
        $moduleFile = $modulePath.'/'.$this->moduleClass.'.php';
        $this->isNewModule = file_exists($moduleFile) ? false : true;

        if( $this->isNewModule ){
            $this->files[]=new CCodeFile(
                $moduleFile,
                $this->render($moduleTemplateFile)
            );
		}

		$files=CFileHelper::findFiles($templatePath,array(
			'exclude'=>array(
				'.svn',
				'.gitignore'
			),
		));

		foreach($files as $file)
		{
			if($file!==$moduleTemplateFile)
			{
				if(CFileHelper::getExtension($file)==='php'){
					$content = $this->render($file);
				}
				// an empty directory
				else if(basename($file)==='.yii')
				{
					$file=dirname($file);
					$content=null;
				}
				else {
					$content = file_get_contents($file);
				}

                // Controller custom filename
                if( basename($file) == 'controller.php' ){
                    $filePath = $modulePath . substr( dirname($file) . '/' . ucfirst($this->controllerID) . 'Controller.php' , strlen($templatePath));
                }
                // Views files path
                else {
                    //$filePath = $modulePath . substr($file, strlen($templatePath));
                    $filePath = $modulePath . '/views/' . $this->controllerID . '/' . basename($file);
                }

				$this->files[]=new CCodeFile(
					$filePath,
					$content
				);

			}
		}
	}

    /**
     * Check is text field
     */
    public function isText($column){
        return stripos($column->dbType,'text') !== false ? true : false;
    }

    /**
     * Check is image file
     */
    public function isImageFile($column){
        return substr( $column->name, 0, 6 ) == 'image_' ? true : false;
    }

    /**
     * Get linked model
     */
    public function getLinked($column){

        if( mb_substr( $column->name, -3 ) != '_id' ){
            return false;
        }

        $modelClass = $this->modelClass;
        $name = mb_substr( $column->name, 0, -3 );
        $relations = $modelClass::model()->relations();

        if( !isset($relations[$name]) ){
            return false;
        }

        $relation = $relations[ $name ];
        $relationModel = $relation[1];

        return $relationModel;
    }

    public function isCheckbox($column){
        return $column->type === 'boolean' || mb_substr($column->name, 0, 3) == 'is_' ? true : false;
    }

	public function generateActiveRow($modelClass, $column)
	{
		// Boolean row
		if ( $this->isCheckbox($column) ){
			return "echo \$form->labelEx(\$model,'{$column->name}'); echo \$form->checkBox(\$model,'{$column->name}')";
		}

		// Text row
		if ( $this->isText($column) ){
			return "echo \$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span8'))";
		}

		// Linked list one to many
		if ( $relationModel = $this->getLinked($column) ){

            return 'echo $form->labelEx($model,"' . $column->name . '"); echo $form->dropDownList(
                        $model,
                        "' . $column->name . '",
                        CHtml::listData( ' . $relationModel . '::model()->findAll(), "id", "title"),
                        array("empty" => "Не выбран")
                    )';
		}

		// image
		if( $this->isImageFile($column) ){

            $html = 'echo $form->labelEx($model, "' . $column->name . '");' . "\n";
            $html .= 'echo $form->textField($model, "' . $column->name . '", array("class" => "span5", "maxlength"=>255) );' . "\n";

            $html .= 'echo "<div style=\'height: 30px\'>";' . "\n";

            $html .= '$this->widget("ext.EFineUploader.EFineUploader",
                 array(
                   "id"=>"FineUploader_' . $column->name . '",
                   "config" => array(
                       "autoUpload" => true,
                       "request" => array(
                            "endpoint" => $this->createUrl("'. $this->controllerID .'/upload"),
                            "params" => array("YII_CSRF_TOKEN" => Yii::app()->request->csrfToken),
                        ),
                       "retry" => array("enableAuto"=>true, "preventRetryResponseProperty" => true),
                       "chunking" => array("enable" => true, "partSize" => 100),//bytes
                       "callbacks" => array(
                              "onComplete" => "js:function(id, name, response){
                                  $(\'#' . $this->modelClass .'_' . $column->name . '\').val( response.folder + response.filename );
                                  $(\'#' . $this->modelClass .'_' . $column->name . '_image\').attr( \'src\', response.folder + response.filename ).show() }",
                              //"onError"=>"js:function(id, name, errorReason){ alert(errorReason) }",
                        ),
                       "validation"=>array(
                           "allowedExtensions" => array("jpg", "jpeg", "png"),
                           "sizeLimit" => 2 * 1024 * 1024, //maximum file size in bytes
                           //"minSizeLimit" => 2*1024*1024,// minimum file size in bytes
                        ),
                      )
                  )
              );

              echo "</div>";

              echo "<img class=\'loader_image\' style=\'display: " . ($model->' . $column->name . ' ? "block" : "none") . " \' id=\'' . $this->modelClass .'_' . $column->name . '_image\' src=\'{$model->' . $column->name . '}\' />";

              ';



            return $html;

		}

        // For password fields
        if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)){
            $inputField='passwordField';
        } else {
            $inputField='textField';
        }

        //
        $html = "echo \$form->labelEx(\$model,'{$column->name}');";

        if ($column->type!=='string' || $column->size===null){
            $html .= "echo \$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span5'));";
        } else {
            $html .= "echo \$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span5','maxlength'=>$column->size));";
        }

        return $html;

	}

	public function getModuleClass()
	{
		return ucfirst($this->moduleID).'Module';
	}

	public function getModulePath()
	{
		return Yii::app()->modulePath.DIRECTORY_SEPARATOR.$this->moduleID;
	}
}
