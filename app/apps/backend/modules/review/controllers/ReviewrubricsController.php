<?php

class ReviewrubricsController extends Controller
{

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	public function actionView($id)
	{
		// set attributes from get
		if(isset($_GET['ReviewRubrics'])){
			$model->attributes=$_GET['ReviewRubrics'];
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
	public function actionCreate($id = null)
	{
        $this->breadcrumbs = array(
            'Отзывы'=>array('/review/reviewrubrics/index'),
            'Новая запись'
        );

        $model = new ReviewRubrics;
        $root = ReviewRubrics::getRoot($model);
        $descendants = $root->descendants()->findAll($root->id);

        if(isset($_POST['ReviewRubrics']))
        {
            $model = new ReviewRubrics;
            $parent_id = (int)$_POST['ReviewRubrics']['parent_id'];
            $root = ReviewRubrics::model()->findByPk($parent_id);
            $model->attributes = $_POST['ReviewRubrics'];

            $model->imagefile = CUploadedFile::getInstance($model,'imagefile');
            if (isset($model->imagefile)){$ext=pathinfo($model->imagefile);$model->image = $ext['extension'];}

            if (!$root){
                //Создаю родительскую категорию
                $result = ReviewRubrics::getRoot(new ReviewRubrics);
                $model->id = (int)$result->id;
            }
            else {
                $model->appendTo($root);
            }
            if(!empty($model->id)){

                if (isset($model->imagefile) && $modelSettings = SiteModuleSettings::model()->find('site_module_id = 16')){
                    $filename = $model->id.'.'.$model->image;
                    $filepatch = '/../uploads/filestorage/review/rubrics/';
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );

                    //Обработка изображения
                    SiteModuleSettings::model()->chgImgModel($modelSettings, 'GD', 1,$model->id);
                }


                $this->redirect(array('update','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
            'root' => $root,
            'categories' => $descendants,
            'id' => null,
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
            'Отзывы'=>array('/review/reviewrubrics/index'),
            'Редактировать запись'
        );

        $root = ReviewRubrics::getRoot(new ReviewRubrics);

        $model = $this->loadModel($id);
        $descendants = $root->descendants()->findAll($root->id);


        if(isset($_POST['ReviewRubrics']))
        {
            $model->attributes = $_POST['ReviewRubrics'];
            $parent_id = (int)$model->parent_id;
            $root = ReviewRubrics::model()->findByPk($parent_id);

            $model->imagefile = CUploadedFile::getInstance($model,'imagefile');
            if (isset($model->imagefile)){$ext=pathinfo($model->imagefile);$model->image = $ext['extension'];}

            $model->saveNode();

            if(!empty($model->id)){

                if (isset($model->imagefile) && $modelSettings = SiteModuleSettings::model()->find('site_module_id = 16')){
                    $filename = $model->id.'.'.$model->image;
                    $filepatch = '/../uploads/filestorage/review/rubrics/';
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );

                    //Обработка изображения
                    SiteModuleSettings::model()->chgImgModel($modelSettings, 'GD', 1,$model->id);
                }

                $this->redirect(array('update','id'=>$model->id));
            }
        }

        $this->render('update',array(
            'model'=> $model,
            'root' => $root,
            'categories' => $descendants,
            'id' => $id,
        ));

	}

    /**
     * File uploader controller
     */
	public function actionUpload(){

        $webFolder = '/uploads/reviewrubrics/';
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
                //Удаляем вопросы категории
                ReviewElements::model()->deleteAll('parent_id = '.$id);
                //Удаляем категорию
                $this->loadModel($id)->deleteNode();
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
		$dataProvider=new CActiveDataProvider('ReviewRubrics');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	*/

	/**
	 * Manages all models.
	 */
	public function actionIndex($id = null)
	{

        $this->breadcrumbs = array(
            'Вопрос-ответ'=>array('/review/reviewrubrics/index'),
        );


        set_time_limit(0);
        //получаем URL
        $base_patch = SITE_NAME_FULL.'/review';
        if ( !empty($id) ){
            $model = ReviewRubrics::model()->findByPk((int)$id);
            if ($model){
                $i = (int)$id;
                $array = array();
                do {
                    $model = ReviewRubrics::model()->findByPk((int)$i);
                    if(isset($model->id))$array[] = $model->id;
                    $i = (int)$model->parent_id;
                } while ($i != 0);
                $array = array_reverse($array);
                unset($array[0]);
                foreach ($array as $value){
                    $base_patch .= '/'.(ReviewRubrics::model()->findByPk((int)$value)->url);
                }
            }
        }



        if (!empty($id)){
            $model = ReviewRubrics::model()->findByPk((int)$id);
            $root = ReviewRubrics::getRoot($model);
            $category = ReviewRubrics::model()->findByPk((int)$id); //Получаем нужный узел
            $descendants = $category->descendants(1)->findAll();

            $param[] = 'left_key > '.$model->left_key.' AND right_key < '.$model->right_key;
        }
        else {
            $model = new ReviewRubrics;
            $category = ReviewRubrics::getRoot($model);
            $category = ReviewRubrics::model()->findByPk($category->id);
            $descendants = $category->descendants(1)->findAll();
            $root = "";

            $param[] = 'level=2';
        }

        $model = new ReviewRubrics;

        $param = implode(" AND ", $param);
        $data = array(
            'criteria'=>array(
                'condition'=>$param,
            ),
        );
        if ($settingsModel = SiteModuleSettings::model()->find('site_module_id = 7')){
            $data['Pagination'] = array(
                'PageSize'=>(((int)$settingsModel->elements_page_admin>0)?$settingsModel->elements_page_admin:100),
            );
        }


        $data['sort'] = array(
            'defaultOrder'=>'left_key ASC',
        );

        $provider=new CActiveDataProvider('ReviewRubrics', $data);
        $provider->criteria = $model->search($param);

        $this->render('list',array(
            'model' => $model,
            'provider' => $provider,
            'root' => $root,
            'categories' => $descendants,
            'base_patch' => $base_patch,
        ));

	}

    public function actionMove($id, $move){

        $model = $this->loadModel((int)$id);

        if ((int)$move == 1){
            //переместить вверх  - надо получить узел идущий выше $moveModel = $model->prev()->find();
            $moveModel = $model->prev()->find();
            $model->moveBefore($moveModel);
        } elseif ((int)$move == 2){
            //переместить ниже - получаем нижний узел  $nextSibling = $model->next()->find();
            $moveModel = $model->next()->find();
            $model->moveAfter($moveModel);
        }
        $this->redirect($_SERVER['HTTP_REFERER']);

    }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ReviewRubrics::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='review-rubrics-form')
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
                    //Меняем статус для вопросов
                    foreach (ReviewElements::model()->findAll('parent_id = '.$model->id) as $data){
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