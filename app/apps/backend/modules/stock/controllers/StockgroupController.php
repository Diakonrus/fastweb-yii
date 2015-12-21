<?php

class StockgroupController extends Controller
{

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	public function actionView($id)
	{
		// set attributes from get
		if(isset($_GET['StockGroup'])){
			$model->attributes=$_GET['StockGroup'];
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
		$model=new StockGroup;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['StockGroup'])){
			$model->attributes=$_GET['StockGroup'];
        }

		if(isset($_POST['StockGroup']))
		{
			$model->attributes=$_POST['StockGroup'];

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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['StockGroup'])){
			$model->attributes=$_GET['StockGroup'];
        }

		if(isset($_POST['StockGroup']))
		{
			$model->attributes=$_POST['StockGroup'];

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

        $webFolder = '/uploads/stockgroup/';
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
		$dataProvider=new CActiveDataProvider('StockGroup');
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
		$model=new StockGroup('search');
        $model->attachBehavior('dateComparator', array(
            'class' => 'DateComparator',
        ));
		$model->unsetAttributes();  // clear any default values

		// set attributes from get
		if(isset($_GET['StockGroup'])){
			$model->attributes=$_GET['StockGroup'];
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
		$model=StockGroup::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='stock-group-form')
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
                    $model->status = (($model->status==1)?0:1);
                    $model->save();
                    //Меняем статус для новостей в группе
                    foreach (Stock::model()->findAll('group_id = '.$model->id) as $data){
                        $data->status = $model->status;
                        $data->save();
                    }
                    break;
            }

            echo CJavaScript::jsonEncode('ok');
        }

        Yii::app()->end();
    }


}
