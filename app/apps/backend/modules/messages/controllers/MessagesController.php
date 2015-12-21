<?php

class MessagesController extends Controller
{

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	public function actionView($id)
	{
		// set attributes from get
		if(isset($_GET['EmailMessages'])){
			$model->attributes=$_GET['EmailMessages'];
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
        $this->breadcrumbs = array(
            'Отправить письмо на Email '=>array('/messages/messages'),
            'Новая запись'
        );

		$model=new EmailMessages;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['EmailMessages'])){
			$model->attributes=$_GET['EmailMessages'];
        }

		if(isset($_POST['EmailMessages']))
		{
			$model->attributes=$_POST['EmailMessages'];

            if($model->save()) {
                $this->redirect('/admin/messages/messages/');
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
        $this->breadcrumbs = array(
            'Отправить письмо на Email '=>array('/messages/messages'),
            'Редактирование'
        );

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['EmailMessages'])){
			$model->attributes=$_GET['EmailMessages'];
        }

		if(isset($_POST['EmailMessages']))
		{
			$model->attributes=$_POST['EmailMessages'];

            if($model->save()) {
                $this->redirect('/admin/messages/messages/');
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

        $webFolder = '/uploads/emailmessages/';
        $tempFolder = Yii::app()->basePath . '/../www' . $webFolder;

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
		$dataProvider=new CActiveDataProvider('EmailMessages');
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
        $this->breadcrumbs = array(
            'Отправить письмо на Email '=>array('/messages/messages'),
        );

		$model=new EmailMessages('search');

        $model->attachBehavior('dateComparator', array(
            'class' => 'DateComparator',
        ));
		$model->unsetAttributes();  // clear any default values

		// set attributes from get
		if(isset($_GET['EmailMessages'])){
			$model->attributes=$_GET['EmailMessages'];
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
		$model=EmailMessages::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='email-messages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionImageUpload() {

        $webFolder = '/uploads/websitemessages/';
        $tempFolder = Yii::app()->basePath . '/../'.SITE_PUBLIC_NAME . $webFolder;
        //$tempFolder = YiiBase::getPathOfAlias('webroot'). '/..'.$webFolder;

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

        $array = array( 'filelink' => Yii::app()->request->hostInfo.$webFolder.$filename, 'filename' => $filename );
        echo stripslashes(json_encode($array));

    }



}
