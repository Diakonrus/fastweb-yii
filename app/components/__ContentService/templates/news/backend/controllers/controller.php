<?php

class NewsController extends Controller
{

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	public function actionView($id)
	{
		// set attributes from get
		if(isset($_GET['Pages'])){
			$model->attributes=$_GET['Pages'];
        }

	    $model = $this->loadModel($id);

		$this->render('view',array(
			'model'=>$model,
		));
	}
	*/

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'update' page.
	 */
    public function actionCreate()
    {
        $model = new News;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        // set attributes from get
        if(isset($_GET['News'])){
            $model->attributes=$_GET['News'];
        }

        if(isset($_POST['News']))
        {
            $model->attributes=$_POST['News'];

            if(isset($_FILES)){
                $model->image = "jpeg";
            }

            if($model->save()){

                if(isset($_FILES)){
                    move_uploaded_file($_FILES["images"]["tmp_name"], Yii::getPathOfAlias('webroot')."/../uploads/filestorage/news/elements/".$model->id.'.jpeg');
                    $this->chgImg(Yii::getPathOfAlias('webroot')."/../uploads/filestorage/news/elements/", $model->id.'.jpeg', "small-".$model->id.'.jpeg');
                }



                $url = isset($_POST['go_to_list'])
                    ? $this->listUrl('index')
                    : $this->itemUrl('update', $model->id);
                $this->redirect( $url );
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'update' page.
	 * @param integer $id the ID of the model to be updated
	 */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        // set attributes from get
        if(isset($_GET['News'])){
            $model->attributes=$_GET['News'];
        }

        if(isset($_POST['News']))
        {

            $model->attributes=$_POST['News'];
            if(isset($_FILES)){
                $model->image = "jpeg";
            }

            //$model->images=CUploadedFile::getInstance($model, "News[image][$i]");
            if($model->save()){


                if(isset($_FILES)){
                    move_uploaded_file($_FILES["images"]["tmp_name"], Yii::getPathOfAlias('webroot')."/../uploads/filestorage/news/elements/".$model->id.'.jpeg');
                    $this->chgImg(Yii::getPathOfAlias('webroot')."/../uploads/filestorage/news/elements/", $model->id.'.jpeg', "small-".$model->id.'.jpeg');
                }

                $url = isset($_POST['go_to_list'])
                    ? $this->listUrl('index')
                    : $this->itemUrl('update', $model->id);
                $this->redirect( $url );
            }
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * File uploader controller
     */
	public function actionUpload(){

        $webFolder = '/uploads/pages/';
        $tempFolder = Yii::app()->basePath . '/../'.SITE_PUBLIC_NAME . $webFolder;

        @mkdir($tempFolder, 0777, TRUE);
        @mkdir($tempFolder.'chunks', 0777, TRUE);

        Yii::import("ext.EFineUploader.qqFileUploader");

        $uploader = new qqFileUploader();
        $uploader->allowedExtensions = array('jpg','jpeg', 'png', 'gif');
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

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
            $id = Yii::app()->request->getParam('id', array());
            $list = is_array($id) ? $id : array($id);
            foreach($list as $id){
                $this->loadModel($id)->delete();
            }
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 *
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Pages');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	*/

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new News('search');
        $model->attachBehavior('dateComparator', array(
            'class' => 'DateComparator',
        ));
		$model->unsetAttributes();  // clear any default values

		// set attributes from get
		if(isset($_GET['News'])){
			$model->attributes=$_GET['News'];
        }

		$this->render('list',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionImageUpload() {

        $webFolder = '/uploads/news/';
        $tempFolder = Yii::app()->basePath . '/../'.SITE_PUBLIC_NAME . $webFolder;

        @mkdir($tempFolder, 0777, TRUE);
        @mkdir($tempFolder.'chunks', 0777, TRUE);

        Yii::import("ext.image.CImageComponent");

        $image=CUploadedFile::getInstanceByName('file');
        $filename = 'a_'.date('YmdHis').'_'.substr(md5(time()), 0, rand(7, 13)).'.'.$image->extensionName;
        $path = $tempFolder.$filename;
        $image->saveAs($tempFolder.$filename);

        if ( $result = $this->widget('application.extensions.kyimages.KYImages',array('patch'=>$webFolder, 'file'=>$filename)) ){
            //ToDo Вернет данные о ресайзеном изображении (патч и имя файла). Если надо использовать - то тут
        }

        /*
        $image_open = Yii::app()->image->load($tempFolder.$filename);
        if (isset($image_open)) { if ($image_open->width > $image_open->height) $dim = Image::HEIGHT;
        else $dim = Image::WIDTH; $image_open->resize(100, 100, $dim)->crop(100, 100);
            $image_open->save($tempFolder.$filename); }
        */
        $array = array( 'filelink' => Yii::app()->request->hostInfo.$webFolder.$filename, 'filename' => $filename );
        echo stripslashes(json_encode($array));
    }


    private function chgImg($patch, $imgOld, $imgNew){
        $size = getimagesize($patch.$imgOld);
        $source = imagecreatefromjpeg($patch.$imgOld);
        $target = imagecreatetruecolor('151', '100');
        imagecopyresampled(
            $target,  // Идентификатор нового изображения
            $source,  // Идентификатор исходного изображения
            0,0,      // Координаты (x,y) верхнего левого угла
            // в новом изображении
            0,0,      // Координаты (x,y) верхнего левого угла копируемого
            // блока существующего изображения
            151,     // Новая ширина копируемого блока
            100,     // Новая высота копируемого блока
            $size[0], // Ширина исходного копируемого блока
            $size[1]  // Высота исходного копируемого блока
        );
        imagejpeg($target, $patch.$imgNew, 100);
        imagedestroy($target);
        imagedestroy($source);
        return true;
    }

}
