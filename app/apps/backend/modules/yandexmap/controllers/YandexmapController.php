<?php

class YandexmapController extends Controller
{

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	public function actionView($id)
	{
		// set attributes from get
		if(isset($_GET['YandexMap'])){
			$model->attributes=$_GET['YandexMap'];
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
            'Яндекс метки'=>array('/yandexmap/yandexmap'),
            'Новая запись'
        );

		$model=new YandexMap;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['YandexMap'])){
			$model->attributes=$_GET['YandexMap'];
        }

		if(isset($_POST['YandexMap']))
		{
			$model->attributes=$_POST['YandexMap'];

			if($model->save()){
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
        $this->breadcrumbs = array(
            'Яндекс метки'=>array('/yandexmap/yandexmap'),
            'Редактирование'
        );
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['YandexMap'])){
			$model->attributes=$_GET['YandexMap'];
        }

		if(isset($_POST['YandexMap']))
		{
			$model->attributes=$_POST['YandexMap'];

			if($model->save()){
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

        $webFolder = '/uploads/yandexmap/';
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
		$dataProvider=new CActiveDataProvider('YandexMap');
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
            'Яндекс метки'=>array('/yandexmap/yandexmap'),
        );

		$model=new YandexMap('search');
        $model->attachBehavior('dateComparator', array(
            'class' => 'DateComparator',
        ));
		$model->unsetAttributes();  // clear any default values

		// set attributes from get
		if(isset($_GET['YandexMap'])){
			$model->attributes=$_GET['YandexMap'];
        }

        $allPoints = YandexMap::model()->findAll();

		$this->render('list',array(
			'model'=>$model,
            'coords'=>$allPoints,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=YandexMap::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


    public function actionGetcoords(){

        set_time_limit( 18000 );

        foreach (CargoStation::model()->findAll('coords is null') as $data){

            $sContent = file_get_contents('http://geocode-maps.yandex.ru/1.x/?geocode='.$data->name.', Ж/д станция');
            $xml = simplexml_load_string($sContent);

            if (isset($xml->GeoObjectCollection->featureMember->GeoObject->Point->pos)){
                $xml_tmp = $xml->GeoObjectCollection->featureMember->GeoObject->Point->pos;
                $xml_tmp = str_replace(" ", ",", $xml_tmp);
                $model = CargoStation::model()->findByPk($data->id);
                $model->coords = $xml_tmp;
                $model->save();
            }

        }

    }


	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='yandex-map-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
