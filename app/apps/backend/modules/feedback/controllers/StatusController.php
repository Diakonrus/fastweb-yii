<?php

class StatusController extends Controller
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new FeedbackStatus();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FeedbackStatus']))
		{
			$model->attributes=$_POST['FeedbackStatus'];

			if($model->save()) {
				//$this->redirect(array('status/admin'));
                $url = isset($_POST['go_to_list'])
                    ? $this->listUrl('admin')
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
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FeedbackStatus']))
		{
			$model->attributes=$_POST['FeedbackStatus'];

			if($model->save()){
				//$this->redirect(array('status/admin'));
                $url = isset($_POST['go_to_list'])
                    ? $this->listUrl('admin')
                    : $this->itemUrl('update', $model->id);

                $this->redirect( $url );
		    }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
            $errorString = '';
            $errorList = array();

			// we only allow deletion via POST request
            $id = Yii::app()->request->getParam('id', array());
            $list = is_array($id) ? $id : array($id);

            foreach($list as $id){
                try {
                    $model = $this->loadModel($id);
                    $model->attachBehavior('modelDelete', array(
                        'class' => 'ModelDelete',
                    ));
                    $model->delete();
                } catch(CDbException $e) {
                    $errorList[] = $e->getMessage();
                }
            }

            if($errorList) {
                $errorString .= "Произошли следующие ошибки:\n" . join("\n", $errorList);
            }

            if(isset($_GET['ajax']) && $errorList) {
                header("HTTP/1.0 500 Internal Server Error");
                echo $errorString;
                Yii::app()->end();
            } else {
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if($errorList) {
                    if(!headers_sent()) {
                        header("HTTP/1.0 500 Internal Server Error");
                    }
                    echo $errorString;
                } else {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
            }
		}
		else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	    }
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FeedbackStatus('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FeedbackStatus']))
			$model->attributes=$_GET['FeedbackStatus'];

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
		$model=FeedbackStatus::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-status-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
