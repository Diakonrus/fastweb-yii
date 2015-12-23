<?php

class NewsController extends Controller
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
		$model=new WebsiteMessages;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['WebsiteMessages'])){
			$model->attributes=$_GET['WebsiteMessages'];
        }

		if(isset($_POST['WebsiteMessages']))
		{
			$model->attributes=$_POST['WebsiteMessages'];
            $errFlag = 0;
            $delivery_name = md5(date('Y-m-d H:i:s'));
            //Создаю сообщения для пользователей в группах
            $modelUsers = User::model()->findAll( ($model->recipient_id=="all_users_BD")?'':'role_id LIKE ("'.$model->recipient_id.'")');
            foreach ($modelUsers as $data){

                $model=new WebsiteMessages;
                $model->author_id = Yii::app()->user->id;
                $model->recipient_id = $data->id;
                $model->title = $_POST['WebsiteMessages']['title'];
                $model->body = $_POST['WebsiteMessages']['body'];
                $model->delivery_name = $delivery_name;
                $model->read = 0;
                if ($model->validate()) {
                    $model->save();
                } else { $errFlag = 1; }
            }

            if ($errFlag == 0){
                $this->redirect( $this->listUrl('index') );
                /*
                $url = isset($_POST['go_to_list'])
                    ? $this->listUrl('index')
                    : $this->itemUrl('update', $model->id);
                $this->redirect( $url );
                */
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
		if(isset($_GET['EmailMessages'])){
			$model->attributes=$_GET['EmailMessages'];
        }

		if(isset($_POST['EmailMessages']))
		{

            $model->attributes=$_POST['WebsiteMessages'];
            $errFlag = 0;
            $delivery_name = $model->delivery_name;
            //Создаю сообщения для пользователей в группах
            $modelUsers = User::model()->findAll( ($model->recipient_id=="all_users_BD")?'':'role_id LIKE ("'.$model->recipient_id.'")');
            //Удаляю старую рассылку
            WebsiteMessages::model()->deleteAll("delivery_name LIKE ('".$model->delivery_name."')");
            foreach ($modelUsers as $data){

                $model=new WebsiteMessages;
                $model->author_id = Yii::app()->user->id;
                $model->recipient_id = $data->id;
                $model->title = $_POST['WebsiteMessages']['title'];
                $model->body = $_POST['WebsiteMessages']['body'];
                $model->read = 0;
                if ($model->validate()) {
                    $model->save();
                } else { $errFlag = 1; }
            }

            if ($errFlag == 0){
                $url = isset($_POST['go_to_list'])
                    ? $this->listUrl('index')
                    : $this->itemUrl('update', $model->id);
                $this->redirect( $url );
            }

            /*
			$model->attributes=$_POST['EmailMessages'];

			if($model->save()){
					$url = isset($_POST['go_to_list'])
						? $this->listUrl('index')
						: $this->itemUrl('update', $model->id);
					$this->redirect( $url );
		    }
            */
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
                $model = $this->loadModel($id);
                WebsiteMessages::model()->deleteAll("delivery_name LIKE ('".$model->delivery_name."')");
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
		$model=new WebsiteMessages('search');

        /*
        $model->attachBehavior('dateComparator', array(
            'class' => 'DateComparator',
        ));
        */

		$model->unsetAttributes();  // clear any default values

        $provider['inbox']=new CActiveDataProvider('WebsiteMessages', array(
            'criteria'=>array(
                //'group'=>'delivery_name',
                'condition'=>'recipient_id='.Yii::app()->user->id,
            ),
            'sort'=>array(
                'defaultOrder'=>'id DESC',
            ),
            'Pagination' => array (
                'PageSize' => 10,
            ),
        ));

        $provider['outbox']=new CActiveDataProvider('WebsiteMessages', array(
            'criteria'=>array(
               // 'group'=>'delivery_name',
                'condition'=>'author_id='.Yii::app()->user->id,
            ),
            'sort'=>array(
                'defaultOrder'=>'id DESC',
            ),
            'Pagination' => array (
                'PageSize' => 10,
            ),
        ));

		// set attributes from get
		if(isset($_GET['WebsiteMessages'])){
			$model->attributes=$_GET['WebsiteMessages'];
        }

		$this->render('index',array(
			'model'=>$model,
            'provider'=>$provider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=WebsiteMessages::model()->findByPk($id);
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
        $tempFolder = Yii::app()->basePath . '/../'.SITE_PUBLIC_NAME.'' . $webFolder;

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

    public function actionAnswer($id){

        $msgSelected = WebsiteMessages::model()->findByPk($id);
        $model = WebsiteMessages::model()->findAll('delivery_name LIKE ("'.$msgSelected->delivery_name.'") AND recipient_id IN ('.$msgSelected->recipient_id.','.$msgSelected->author_id.') ORDER BY id DESC');

        if (isset($_POST['WebsiteMessages'])) {

            $modelAnswer = new WebsiteMessages;
            $modelAnswer->attributes = $_POST['WebsiteMessages'];
            $modelAnswer->author_id = Yii::app()->user->id;
            $modelAnswer->recipient_id = $msgSelected->author_id;
            $modelAnswer->title = 'RE: '.$msgSelected->title;
            $modelAnswer->read = 0;
            $modelAnswer->delivery_name = $msgSelected->delivery_name;
            $modelAnswer->save();

            $this->redirect( $this->listUrl('index') );
        }

        $this->render('answer',array(
            'model'=>$model
        ));
    }

    function  sendSMS($phone){

        foreach ($phone as $key=>$value){
            $value = str_replace("(", "", $value);
            $value = str_replace(")", "", $value);
            if ($value[0] == "+" && $value[1] == "7"){
                $value = substr($value, 2);
                $value = "8".$value;
            }
            Yii::app()->sms->setPhone($value);
        }

        Yii::app()->sms->setText('Вам пришло новое сообщение с сайта '.SITE_NAME_FULL);
        $result = Yii::app()->sms->sendsms();
        return $result;
    }


}
