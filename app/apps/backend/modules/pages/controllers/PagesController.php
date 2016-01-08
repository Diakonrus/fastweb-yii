<?php

class PagesController extends Controller
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
        $this->breadcrumbs = array(
            'Дерево'=>array('/pages/pages'),
            'Новая запись'
        );

        $model = new Pages;
        $root = Pages::getRoot($model);
        $descendants = $root->descendants()->findAll($root->id);

        if(isset($_POST['Pages']))
        {
            $model = new Pages;
            $parent_id = (int)$_POST['Pages']['parent_id'];
            $root = Pages::model()->findByPk($parent_id);
            $model->attributes = $_POST['Pages'];
            $model->url = mb_strtolower($model->url);

            //Может быть только 1 главная страница
            if ($model->main_page == 1){
                //Проставляем всем остальным 0
                Pages::model()->updateAll(array('main_page'=>0));
            }

            $model->imagefile = CUploadedFile::getInstance($model,'imagefile');
            if (isset($model->imagefile)){$ext=pathinfo($model->imagefile);$model->image = $ext['extension'];}


            if (!$root){
                //Создаю родительскую категорию
                $result = Pages::getRoot(new Pages);
                $model->id = (int)$result->id;
            }
            else {
                $model->appendTo($root);
            }

            if(!empty($model->id)){

                PagesTabs::model()->addTabs($model, ((isset($_POST['PagesTabs']))?($_POST['PagesTabs']):(array())));

                //Изображение
                if (isset($model->imagefile)){
                    $filename = $model->id.'.'.$model->image;
                    $filepatch = '/../uploads/filestorage/menu/elements/';
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                    //получаем размер
                    $image_x = (int)$_POST['image_x'];
                    if ($image_x == 0){
                        //Размер не указан либо указан неверно - беру размеры исходной картинки
                        $size = getimagesize(YiiBase::getPathOfAlias('webroot').$filepatch.$filename);
                        $image_x = $size[0];
                    }
                    //Создаем копии
                    $this->chgImg(YiiBase::getPathOfAlias('webroot').$filepatch, $filename, 'menu-'.$model->id.'.'.$model->image, $image_x, 100);
                }


                Yii::app()->contentcrt->save();


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
            'Дерево'=>array('/pages/pages'),
            'Редактирование'
        );



        $root = Pages::getRoot(new Pages);

        $model = $this->loadModel($id);
        $descendants = $root->descendants()->findAll($root->id);

        $modelTabs = PagesTabs::model()->findAll('pages_id = '.$model->id.' ORDER BY order_id ASC');

        if(isset($_POST['Pages']))
        {
            $model->attributes = $_POST['Pages'];
            $parent_id = (int)$model->parent_id;
            $root = Pages::model()->findByPk($parent_id);
            $model->url = mb_strtolower($model->url);

            //Может быть только 1 главная страница
            if ($model->main_page == 1){
                //Проставляем всем остальным 0
                Pages::model()->updateAll(array('main_page'=>0));
            }

            $model->imagefile = CUploadedFile::getInstance($model,'imagefile');
            if (isset($model->imagefile)){$ext=pathinfo($model->imagefile);$model->image = $ext['extension'];}

            $model->saveNode();

            if(!empty($model->id)){

                PagesTabs::model()->addTabs($model, ((isset($_POST['PagesTabs']))?($_POST['PagesTabs']):(array())));

                //Изображение
                if (isset($model->imagefile)){
                    $filename = $model->id.'.'.$model->image;
                    $filepatch = '/../uploads/filestorage/menu/elements/';
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                    //получаем размер
                    $image_x = (int)$_POST['image_x'];
                    if ($image_x == 0){
                        //Размер не указан либо указан неверно - беру размеры исходной картинки
                        $size = getimagesize(YiiBase::getPathOfAlias('webroot').$filepatch.$filename);
                        $image_x = $size[0];
                    }
                    //Создаем копии
                    $this->chgImg(YiiBase::getPathOfAlias('webroot').$filepatch, $filename, 'menu-'.$model->id.'.'.$model->image, $image_x, 100);
                }


                Yii::app()->contentcrt->save();


                $this->redirect(array('update','id'=>$model->id));
            }
        }

        $this->render('update',array(
            'model'=>$model,
            'root' => $root,
            'categories' => $descendants,
            'id' => null,
            'modelTabs'=>$modelTabs,
        ));

	}

    /**
     * File uploader controller
     */
	public function actionUpload(){

        $webFolder = '/uploads/pages/';
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
        $this->breadcrumbs = array(
            'Дерево'=>array('/pages'),
        );

        $model = new Pages;
        $category = Pages::getRoot($model);
        $category = Pages::model()->findByPk($category->id);
        $descendants = $category->descendants(1)->findAll();
        $root = "";


        $param = array();
        $param[] = 'level > 1';

        if (isset($_GET['Pages'])){
            foreach ($_GET['Pages'] as $key=>$val){
                if (empty($val)){ continue; }
                $param[] = $key.' LIKE "'.$val.'"';
            }
        }


        $param = implode(" AND ", $param);
        $data = array(
            'criteria'=>array(
                'condition'=>$param,
            ),
        );
        $data['sort'] = array(
            'defaultOrder'=>'main_page DESC, left_key ASC',
        );

        $data['Pagination'] = array(
            'PageSize'=>1000
        );
        $provider=new CActiveDataProvider('Pages', $data);
        $provider->criteria = $model->search($param);

		$this->render('list',array(
            'model' => $model,
            'provider' => $provider,
            'root' => $root,
            'categories' => $descendants,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Pages::model()->findByPk($id);
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

        $webFolder = '/uploads/filestorage/photoalbum/upload/';
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


    public function actionGetImageLibray() {
        $webFolder = '/uploads/filestorage/photoalbum/upload/';
        $tempFolder = Yii::app()->basePath . '/../'.SITE_PUBLIC_NAME . $webFolder;

        //Отдаем массив с картинками загружеными ранеее
        $dir = scandir($tempFolder);
        $array = array();
        $i = 0;
        foreach ($dir as $key=>$val ){
            if ($val == '.' || $val == '..' || $val == 'chunks'){
                continue;
            }
            $array[$i]["thumb"] = $webFolder . $val;
            $array[$i]["image"] = $webFolder . $val;
            $array[$i]["title"] = $val;
            ++$i;
        }


        echo CJSON::encode($array);
        exit ;
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

    public function actionAjaxform() {
        $result = array();
        if (isset($_POST['module_select'])){
            $result = PagesTabs::model()->getModuleValue((int)$_POST['module_select']);
        }
        echo CJSON::encode($result);
        exit ;
    }

    public function actionAjax()
    {
        if (isset($_POST)) {
            switch ((int)$_POST['type']) {
                case 1:
                    //Смена статуса
                    $model = $this->loadModel((int)$_POST['id']);
                    $model->status = (($model->status==1)?0:1);
                    $model->saveNode();
                    break;
            }

            echo CJavaScript::jsonEncode('ok');
        }

        Yii::app()->end();
    }

/*
    public function accessRules() {
        return array(
            array('allow',
                'actions'=>array('index'),
                'users'=>array('*'), ),
            array('allow',
                'actions'=>array('imageUpload', 'imageGetJson', 'fileUpload'),
                'users'=>array('admin'), ),
            array('deny',
                'users'=>array('*'), ), );
    }
*/

}
