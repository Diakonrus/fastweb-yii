<?php

class SubjectController extends Controller
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new FeedbackSubject();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FeedbackSubject']))
		{
			$model->attributes=$_POST['FeedbackSubject'];

			if($model->save()) {
				//$this->redirect(array('subject/admin'));
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

		if(isset($_POST['FeedbackSubject']))
		{
			$model->attributes=$_POST['FeedbackSubject'];

			if($model->save()){
				//$this->redirect(array('subject/admin'));
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
			// we only allow deletion via POST request
			#$this->loadModel($id)->delete();
            $id = Yii::app()->request->getParam('id', array());
            $list = is_array($id) ? $id : array($id);

            $fkErrorList = array(); // Список ошибок, связанных с тем что установленный внешний ключ не позволяет удалить запись.
            $errorList = array();   // Все ошибки что не $fkErrorList

            $errorString = '';

            $driver = '';
            if(($pos=strpos(Yii::app()->db->connectionString,':')) !== false) {
                $driver = strtolower(substr(Yii::app()->db->connectionString,0,$pos));
            }

            foreach($list as $id){
                try {
                    $model = $this->loadModel($id);
                    $model->attachBehavior('modelDelete', array(
                        'class' => 'ModelDelete',
                    ));
                    $model->delete();
                } catch(CDbException $e) {
                    if($driver == 'mysql' && $e->errorInfo[1] == 1451) {
                        // ошибка: установленный внешний ключ не даёт удалить запись
                        $fkErrorList[] = $this->loadModel($id)->getAttribute('title');
                    } else {
                        // здесь уверенности нет по типу ошибки
                        $errorList[] = $e->getMessage();
                    }
                }
            }

            if($fkErrorList) {
                if(count($fkErrorList) == 1) {
                    $errorString .= "Следующая тема не была удалена, потому что имела записи связанные с ней:\n\n";
                } else {
                    $errorString .= "Следующие темы не были удалены, потому что имели записи связанные с ними:\n\n";
                }
                $errorString .= join("\n", $fkErrorList);
                if(count($fkErrorList) == 1) {
                    $errorString .= "\n\nУдалите сначала записи с этой темой.";
                } else {
                    $errorString .= "\n\nУдалите сначала записи с этими темами.";
                }
            }

            if($errorList) {
                if($fkErrorList) {
                    $errorString .= "\n\nТакже произошли следующие ошибки:\n";
                } else {
                    $errorString .= "Произошли следующие ошибки:\n";
                }
                $errorString .= join("\n", $errorList);
            }

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])) {
                if($fkErrorList || $errorList) {
                    if(!headers_sent()) {
                        header("HTTP/1.0 500 Internal Server Error");
                    }
                    echo $errorString;
                } else {
				    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
            } else {
                if($fkErrorList || $errorList) {
                    header("HTTP/1.0 500 Internal Server Error");
                    echo $errorString;
                    Yii::app()->end();
                }
            }
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FeedbackSubject('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FeedbackSubject']))
			$model->attributes=$_GET['FeedbackSubject'];

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
		$model=FeedbackSubject::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-subject-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
