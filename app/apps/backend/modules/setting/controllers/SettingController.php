<?php

class SettingController extends Controller
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'update' page.
	 */

	public function actionCreate()
	{
		$model=new Setting;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['Setting'])){
			$model->attributes=$_GET['Setting'];
        }

		if(isset($_POST['Setting']))
		{
			$model->attributes=$_POST['Setting'];

			if($model->save()){
			    if( isset($_POST['go_to_list']) ){
				    $this->redirect( $this->listUrl('index') );
			    } else {
				    $this->redirect( $this->itemUrl('update', $model->id) );
		        }
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

		// set attributes from get
		if(isset($_GET['Setting'])){
			$model->attributes=$_GET['Setting'];
        }

		if(isset($_POST['Setting']))
		{
			$model->attributes = array( 'name' => $model->name ) + $_POST['Setting'];

			if($model->save()){
			    
                            if( isset($_POST['go_to_list']) ){
				    $this->redirect( $this->listUrl('index') );
			    } else {
				    $this->redirect( $this->itemUrl( 'update', $model->id) );
		        }
		    }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new Setting('search');
		$model->unsetAttributes();  // clear any default values

		// set attributes from get
		if(isset($_GET['Setting'])){
			$model->attributes=$_GET['Setting'];
        }

		$this->render('admin',array(
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
		$model=Setting::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='setting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
