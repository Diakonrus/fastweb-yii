<?php

class BeforeafterelementsController extends Controller
{

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	public function actionView($id)
	{
		// set attributes from get
		if(isset($_GET['BeforeAfterElements'])){
			$model->attributes=$_GET['BeforeAfterElements'];
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
		$model=new BeforeAfterElements;

        $root = BeforeAfterRubrics::getRoot(new BeforeAfterRubrics);
        $catalog = $root->descendants()->findAll($root->id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['BeforeAfterElements'])){
			$model->attributes=$_GET['BeforeAfterElements'];
        }

		if(isset($_POST['BeforeAfterElements']))
		{
			$model->attributes=$_POST['BeforeAfterElements'];

            $model->before_photo_file = CUploadedFile::getInstance($model,'before_photo_file');
            if (isset($model->before_photo_file)){$ext=pathinfo($model->before_photo_file);$model->before_photo = $ext['extension'];}

            $model->after_photo_file = CUploadedFile::getInstance($model,'after_photo_file');
            if (isset($model->after_photo_file)){$ext=pathinfo($model->after_photo_file);$model->after_photo = $ext['extension'];}

			if($model->save()){

                if ($model->on_main == 1){
                    BeforeAfterElements::model()->updateAll(array('on_main'=>0),'parent_id='.$model->parent_id.' AND id not in ('.$model->id.')');
                }

                foreach (array('before'=>$model->before_photo, 'after'=>$model->after_photo) as $key=>$val){
                    $filename = $key.'_'.$model->id.'.'.$val;
                    $filepatch = '/../uploads/filestorage/beforeafter/elements/';
                    if ($key=='before'){
                        $model->before_photo_file->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                    } else {
                        $model->after_photo_file->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                    }

                    //Создаем копии
                    $this->chgImgBeforeAfter(YiiBase::getPathOfAlias('webroot').$filepatch, $filename, 'small-'.$key.'_'.$model->id.'.'.$val, 150, 100);
                    $this->chgImgBeforeAfter(YiiBase::getPathOfAlias('webroot').$filepatch, $filename, 'admin-'.$key.'_'.$model->id.'.'.$val, 210, 100);
                    $this->chgImgBeforeAfter(YiiBase::getPathOfAlias('webroot').$filepatch, $filename, 'medium-'.$key.'_'.$model->id.'.'.$val, 210, 100);
                    $this->chgImgBeforeAfter(YiiBase::getPathOfAlias('webroot').$filepatch, $filename, 'large-'.$key.'_'.$model->id.'.'.$val, 456, 100);
                }




				$url = isset($_POST['go_to_list'])
					? $this->listUrl('index')
					: $this->itemUrl('update', $model->id);
				$this->redirect( $url );
		    }
		}

		$this->render('create',array(
			'model'=>$model,
            'root'=>$root,
            'catalog' => $catalog,
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

        $root = BeforeAfterRubrics::getRoot(new BeforeAfterRubrics);
        $catalog = $root->descendants()->findAll($root->id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['BeforeAfterElements'])){
			$model->attributes=$_GET['BeforeAfterElements'];
        }

		if(isset($_POST['BeforeAfterElements']))
		{
			$model->attributes=$_POST['BeforeAfterElements'];

            $model->before_photo_file = CUploadedFile::getInstance($model,'before_photo_file');
            if (isset($model->before_photo_file)){$ext=pathinfo($model->before_photo_file);$model->before_photo = $ext['extension'];}

            $model->after_photo_file = CUploadedFile::getInstance($model,'after_photo_file');
            if (isset($model->after_photo_file)){$ext=pathinfo($model->after_photo_file);$model->after_photo = $ext['extension'];}


            if($model->save()){

                if ($model->on_main == 1){
                    BeforeAfterElements::model()->updateAll(array('on_main'=>0),'parent_id='.$model->parent_id.' AND id not in ('.$model->id.')');
                }

                if (isset($model->after_photo_file) && isset($model->before_photo_file)){
                    foreach (array('before'=>$model->before_photo, 'after'=>$model->after_photo) as $key=>$val){
                        $filename = $key.'_'.$model->id.'.'.$val;
                        $filepatch = '/../uploads/filestorage/beforeafter/elements/';
                        if ($key=='before'){
                            $model->before_photo_file->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                        } else {
                            $model->after_photo_file->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                        }

                        //Создаем копии
                        $this->chgImgBeforeAfter(YiiBase::getPathOfAlias('webroot').$filepatch, $filename, 'small-'.$key.'_'.$model->id.'.'.$val, 150, 100);
                        $this->chgImgBeforeAfter(YiiBase::getPathOfAlias('webroot').$filepatch, $filename, 'admin-'.$key.'_'.$model->id.'.'.$val, 210, 100);
                        $this->chgImgBeforeAfter(YiiBase::getPathOfAlias('webroot').$filepatch, $filename, 'medium-'.$key.'_'.$model->id.'.'.$val, 210, 100);
                        $this->chgImgBeforeAfter(YiiBase::getPathOfAlias('webroot').$filepatch, $filename, 'large-'.$key.'_'.$model->id.'.'.$val, 456, 100);
                    }
                }



					$url = isset($_POST['go_to_list'])
						? $this->listUrl('index')
						: $this->itemUrl('update', $model->id);
					$this->redirect( $url );
		    }
		}

		$this->render('update',array(
			'model'=>$model,
            'root'=>$root,
            'catalog' => $catalog,
		));
	}

    /**
     * File uploader controller
     */
	public function actionUpload(){

        $webFolder = '/uploads/beforeafterelements/';
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
		$dataProvider=new CActiveDataProvider('BeforeAfterElements');
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
		$model=new BeforeAfterElements('search');
        $model->attachBehavior('dateComparator', array(
            'class' => 'DateComparator',
        ));
		$model->unsetAttributes();  // clear any default values

		// set attributes from get
		if(isset($_GET['BeforeAfterElements'])){
			$model->attributes=$_GET['BeforeAfterElements'];
        }

        $root = BeforeAfterRubrics::getRoot(new BeforeAfterRubrics);
        $catalog = $root->descendants()->findAll($root->id);

		$this->render('list',array(
			'model'=>$model,
            'root'=>$root,
            'catalog' => $catalog,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=BeforeAfterElements::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='before-after-elements-form')
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
                    break;
            }

            echo CJavaScript::jsonEncode('ok');
        }

        Yii::app()->end();
    }

    /**Загрузка изображения**/
    /**
     *  $patch - путь к папке с файлами
     *  $imgOld - имя файла который будет использоваться
     *  $imgNew - новое имя файла (с уже внесенными  изменениями)
     *  $x, ширина в пикс картинки $imgNew
     *  $quality - качество $imgNew, по умолчанию 100
     **/
    private  function chgImgBeforeAfter($patch, $imgOld, $imgNew, $x, $quality=100){

        $size = getimagesize($patch.$imgOld);

        if(preg_match("/.gif/i",$imgOld)){
            $source = imagecreatefromgif($patch.$imgOld);
        }
        elseif(preg_match("/.jpeg/i",$imgOld) or preg_match("/.jpg/i",$imgOld)){
            $source = imagecreatefromjpeg($patch.$imgOld);
        }
        elseif(preg_match("/.png/i",$imgOld)) {
            $source = imagecreatefrompng($patch . $imgOld);
        }

        //Высчитываем высоту исходя из $x картинки
        $prop = $size[1] / $size[0];// пропорция
        $y = $x * $prop;

        $target = imagecreatetruecolor($x, $y);
        imagecopyresampled(
            $target,  // Идентификатор нового изображения
            $source,  // Идентификатор исходного изображения
            0,0,      // Координаты (x,y) верхнего левого угла
            // в новом изображении
            0,0,      // Координаты (x,y) верхнего левого угла копируемого
            // блока существующего изображения
            $x,     // Новая ширина копируемого блока
            $y,     // Новая высота копируемого блока
            $size[0], // Ширина исходного копируемого блока
            $size[1]  // Высота исходного копируемого блока
        );

        if(preg_match("/.gif/i",$imgOld)){
            imagegif($target, $patch.$imgNew, $quality);
        }
        elseif(preg_match("/.jpeg/i",$imgOld) or preg_match("/.jpg/i",$imgOld)){
            imagejpeg($target, $patch.$imgNew, $quality);
        }
        elseif(preg_match("/.png/i",$imgOld)) {
            imagepng($target, $patch.$imgNew, 9);
        }
        imagedestroy($target);
        imagedestroy($source);
        return true;
    }

    private function addWatermarkBeforeAfter($img, $img_wm, $watermark_pos = 1){
        $wm=imagecreatefrompng($img_wm);
        $wmW=imagesx($wm);
        $wmH=imagesy($wm);
        // imagecreatetruecolor - создаёт новое изображение true color
        $image=imagecreatetruecolor($wmW, $wmH);

        // выясняем расширение изображения на которое будем накладывать водяной знак
        if(preg_match("/.gif/i",$img)):
            $image=imagecreatefromgif($img);
        elseif(preg_match("/.jpeg/i",$img) or preg_match("/.jpg/i",$img)):
            $image=imagecreatefromjpeg($img);
        elseif(preg_match("/.png/i",$img)):
            $image=imagecreatefrompng($img);
        else:
            die("Ошибка! Неизвестное расширение изображения");
        endif;
        // узнаем размер изображения
        $size=getimagesize($img);

        //проверяем, что водная марка не больше изображения на которое накладываем
        if ( $size[1]>$wmH || $size[0]>$wmW ){

            // указываем координаты, где будет располагаться водяной знак
            /*
            * $size[0] - ширина изображения
            * $size[1] - высота изображения
            */
            $cx=null;
            $cy=null;

            //Позиции водной марки
            switch ($watermark_pos) {
                case 1: //Замостить
                    for ($y_i=0; $y_i<$size[1]; $y_i = $y_i+$wmH){
                        for ($x_i=0; $x_i<$size[0]; $x_i = $x_i+$wmW){
                            imagecopyresampled ($image, $wm, $x_i, $y_i, 0, 0, $wmW, $wmH, $wmW, $wmH);
                        }
                    }
                    break;
                case 2: //Изображение в нижнем левом углу
                    $cx=10;
                    $cy=$size[1]-$wmH;
                    break;
                case 3: //Изображение внизу по центру
                    $cx=($size[0]/2)-($wmW/2);
                    $cy=$size[1]-$wmH;
                    break;
                case 4: //Изображение в центре
                    $cx=($size[0]/2)-($wmW/2);
                    $cy=($size[1]/2)-($wmH/2);
                    break;
                case 5: //Изображение в левом верхнем углу
                    $cx=10;
                    $cy=10;
                    break;
                case 6:  //Изображение в нижнем правом углу
                    $cx=$size[0]-$wmW;
                    $cy=$size[1]-$wmH;
                    break;
            }

            /* imagecopyresampled - копирует и изменяет размеры части изображения
            * с пересэмплированием
            */
            if (!empty($cx) && !empty($cy)){
                imagecopyresampled ($image, $wm, $cx, $cy, 0, 0, $wmW, $wmH, $wmW, $wmH);
            };

            /* imagejpeg - создаёт JPEG-файл filename из изображения image
            * третий параметр - качество нового изображение
            * параметр является необязательным и имеет диапазон значений
            * от 0 (наихудшее качество, наименьший файл)
            * до 100 (наилучшее качество, наибольший файл)
            * По умолчанию используется значение по умолчанию IJG quality (около 75)
            */
            //imagejpeg($image,$img,90);
            if(preg_match("/.gif/i",$img)){
                imagegif($image,$img,90);
            }
            elseif(preg_match("/.jpeg/i",$img) or preg_match("/.jpg/i",$img)){
                imagejpeg($image,$img,90);
            }
            elseif(preg_match("/.png/i",$img)) {
                imagepng($image,$img,9);
            }

            // imagedestroy - освобождает память
            imagedestroy($image);

            imagedestroy($wm);

            // на всякий случай
            unset($image,$img);

        }

    }

}
