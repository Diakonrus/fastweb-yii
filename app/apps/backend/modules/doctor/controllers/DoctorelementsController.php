<?php

class DoctorelementsController extends Controller
{

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	public function actionView($id)
	{
		// set attributes from get
		if(isset($_GET['DoctorElements'])){
			$model->attributes=$_GET['DoctorElements'];
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
		$model=new DoctorElements;
        $modelSpecialization = new DoctorSpecialization();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['DoctorElements'])){
			$model->attributes=$_GET['DoctorElements'];
        }

		if(isset($_POST['DoctorElements']))
		{
			$model->attributes=$_POST['DoctorElements'];


            $model->imagefile = CUploadedFile::getInstance($model,'imagefile');
            if (isset($model->imagefile)){$ext=pathinfo($model->imagefile);$model->image = $ext['extension'];}


            if($model->save()){

                //Пишем специализацию
                DoctorSpecialization::model()->deleteAll('doctor_elements_id = '.$model->id);
                foreach ($model->doctor_rubrics_id as $key=>$val){
                    $modelSpec = new DoctorSpecialization();
                    $modelSpec->doctor_rubrics_id = $val;
                    $modelSpec->doctor_elements_id = $model->id;
                    $modelSpec->save();
                }

                if (isset($model->imagefile) && $modelSettings = SiteModuleSettings::model()->find('site_module_id = 10')){
                    $filename = $model->id.'.'.$model->image;
                    $filepatch = '/../uploads/filestorage/doctor/elements/';
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                    //Обработка изображения
                    SiteModuleSettings::model()->chgImgModel($modelSettings, 'GD', 2,$model->id);
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
		if(isset($_GET['DoctorElements'])){
			$model->attributes=$_GET['DoctorElements'];
        }

		if(isset($_POST['DoctorElements']))
		{
			$model->attributes=$_POST['DoctorElements'];

            $model->imagefile = CUploadedFile::getInstance($model,'imagefile');
            if (isset($model->imagefile)){$ext=pathinfo($model->imagefile);$model->image = $ext['extension'];}


            if($model->save()){

                //Пишем специализацию
                DoctorSpecialization::model()->deleteAll('doctor_elements_id = '.$model->id);
                foreach ($model->doctor_rubrics_id as $key=>$val){
                    $modelSpec = new DoctorSpecialization();
                    $modelSpec->doctor_rubrics_id = $val;
                    $modelSpec->doctor_elements_id = $model->id;
                    $modelSpec->save();
                }

                if (isset($model->imagefile) && $modelSettings = SiteModuleSettings::model()->find('site_module_id = 10') ){
                    $filename = $model->id.'.'.$model->image;
                    $filepatch = '/../uploads/filestorage/doctor/elements/';
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                    //Обработка изображения
                    SiteModuleSettings::model()->chgImgModel($modelSettings, 'GD', 2,$model->id);
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

        $webFolder = '/uploads/doctorelements/';
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
	public function actionDelete($id = null)
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
		$dataProvider=new CActiveDataProvider('DoctorElements');
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
		$model=new DoctorElements('search');
        $model->attachBehavior('dateComparator', array(
            'class' => 'DateComparator',
        ));
		$model->unsetAttributes();  // clear any default values

		// set attributes from get
		if(isset($_GET['DoctorElements'])){
			$model->attributes=$_GET['DoctorElements'];
        }

        $param = null;
        if (!empty($_GET['doctor_rubrics_id']) && (int)$_GET['doctor_rubrics_id']>0){
            $arr = array();
            foreach (DoctorSpecialization::model()->findAll('doctor_rubrics_id = '.(int)$_GET['doctor_rubrics_id']) as $data){
                $arr[] = $data->doctor_elements_id;
            }
            $param = ' id in ('.implode(",", $arr).') ';
        }

		$this->render('list',array(
			'model'=>$model,
            'param'=>$param,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=DoctorElements::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='doctor-elements-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


    public function actionAjax()
    {
        if (isset($_POST)) {
            switch ((int)$_POST['type']) {
                case 1:
                    //Смена статуса
                    $model = $this->loadModel((int)$_POST['id']);
                    $model->doctor_rubrics_id = 0;
                    $model->status = (($model->status==1)?0:1);
                    $model->save();
                    break;
                case 2:
                    //Сохранение данных списка
                    foreach ($_POST['order'] as $order){
                        $orderArr = explode("|", $order);
                        if ( count($orderArr)!=0 ){
                            $model = $this->loadModel((int)$orderArr[0]);
                            if ($model){
                                $model->doctor_rubrics_id = 0;
                                $model->order_id = $orderArr[1];
                                $model->save();
                            }
                        }
                    }
                    break;
            }

            echo CJavaScript::jsonEncode('ok');
        }

        Yii::app()->end();
    }
}
