<?php

class TemplateController extends Controller
{


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'update' page.
	 */
	public function actionCreate()
	{
        $this->breadcrumbs = array(
            'Шаблоны'=>array('/pages/template'),
            'Новая запись'
        );

		$model=new MenuTemplate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['MenuTemplate'])){
			$model->attributes=$_GET['MenuTemplate'];
        }

		if(isset($_POST['MenuTemplate']))
		{
			$model->attributes=$_POST['MenuTemplate'];

            //Генерирую BODY
            $model->body = $this->getBody($model);

            //Может быть только 1 шаблон используемый на фронте
            if ($model->status==1){
                //Проставляем всем остальным 0
                MenuTemplate::model()->updateAll(array('status'=>0));
            }


			if($model->save()){

                //Создаем шаблон во фронте
                $this->createTemplateFile($model);


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
            'Шаблоны'=>array('/pages/template'),
            'Редактирование'
        );

		$model=$this->loadModel($id);

		// set attributes from get
		if(isset($_GET['MenuTemplate'])){
			$model->attributes=$_GET['MenuTemplate'];
        }

        if(isset($_POST['MenuTemplate']))
        {
            $model->attributes=$_POST['MenuTemplate'];

            //Генерирую BODY
            $model->body = $this->getBody($model);

            //Может быть только 1 шаблон используемый на фронте
            if ($model->status==1){
                //Проставляем всем остальным 0
                MenuTemplate::model()->updateAll(array('status'=>0));
            }


            if($model->save()){

                //Создаем шаблон во фронте
                $this->createTemplateFile($model);


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
            'Шаблоны меню'=>array('/pages/template'),
        );

        $model=new MenuTemplate('search');
        $model->attachBehavior('dateComparator', array(
            'class' => 'DateComparator',
        ));
        $model->unsetAttributes();  // clear any default values

        // set attributes from get
        if(isset($_GET['MenuTemplate'])){
            $model->attributes=$_GET['MenuTemplate'];
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
		$model=MenuTemplate::model()->findByPk($id);
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

        $webFolder = '/uploads/pages/';
        $tempFolder = Yii::app()->basePath . '/../'.SITE_PUBLIC_NAME . $webFolder;
        //$tempFolder = YiiBase::getPathOfAlias('webroot'). '/..'.$webFolder;

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

        $array = array( 'filelink' => Yii::app()->request->hostInfo.$webFolder.$filename, 'filename' => $filename );
        echo stripslashes(json_encode($array));
    }

    public function actionAjax(){
        if(Yii::app()->request->isPostRequest){

            switch ($_POST['action']) {

                /**Получить список меню**/
                case "get_menu":
                    $html = '
                    <table style="border-collapse: collapse; width:100%; border: 1px solid #000000;">
                        <thead>
                            <tr>
                                <th style="background: #ccc;">Тип</th><th style="background: #ccc;">Имя</th><th style="background: #ccc;">Изображение</th><th style="background: #ccc;">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    foreach (Menu::model()->findAll('active=1') as $data){
                        $img = '/images/nophoto_100_100.jpg';
                        $base_url_img = '/../uploads/filestorage/menu/rubrics/';
                        if (file_exists( YiiBase::getPathOfAlias('webroot').$base_url_img.$data->id.'.'.$data->image )) {
                            $img = $base_url_img.'menu-'.$data->id.'.'.$data->image;
                        }
                        $html .= '
                            <tr>
                                <td style="border: 1px solid #000000;" align="center">Меню</td>
                                <td style="border: 1px solid #000000;" align="center">'.$data->name.'</td>
                                <td style="border: 1px solid #000000;" align="center"><img style="max-width:60px"  src="'.$img.'" /></td>
                                <td style="border: 1px solid #000000;" align="center"><a href="#" class="addElemetnsOnForm btn btn-success btn-mini" data-type="menu" data-val="'.$data->id.'" data-name="'.$data->name.'" data-img="'.$img.'"  onclick="$(\'#menuModal\').modal(\'hide\');">Вставить</a></td>
                            </tr>
                        ';
                    }
                    $html .= '
                        </tbody>
                    </table>
                    <p>
                        <i>Вставляя меню на форму вы вставляете так же и все ссылки закрепленные за этим меню</i>
                    </p>
                    ';
                    break;

                /**Получить список ссылок**/
                case "get_links":
                    $html = '
                    <table style="border-collapse: collapse; width:100%; border: 1px solid #000000;">
                        <thead>
                            <tr>
                                <th style="background: #ccc;">Тип</th><th style="background: #ccc;">Имя</th><th style="background: #ccc;">URL</th><th style="background: #ccc;">Изображение</th><th style="background: #ccc;">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    foreach (Pages::model()->findAll('status=2') as $data){
                        $img = '/images/nophoto_100_100.jpg';
                        $base_url_img = '/../uploads/filestorage/menu/elements/';
                        if (file_exists( YiiBase::getPathOfAlias('webroot').$base_url_img.$data->id.'.'.$data->image )) {
                            $img = $base_url_img.'menu-'.$data->id.'.'.$data->image;
                        }
                        $html .= '
                            <tr>
                                <td style="border: 1px solid #000000;" align="center">Ссылка</td>
                                <td style="border: 1px solid #000000;" align="center">'.$data->title.'</td>
                                <td style="border: 1px solid #000000;" align="center">'.$data->url.'</td>
                                <td style="border: 1px solid #000000;" align="center"><img style="max-width:60px"  src="'.$img.'" /></td>
                                <td style="border: 1px solid #000000;" align="center"><a href="#" class="addElemetnsOnForm btn btn-success btn-mini" data-type="link" data-val="'.$data->id.'" data-name="'.$data->title.'" data-img="'.$img.'"  onclick="$(\'#menuModal\').modal(\'hide\');">Вставить</a></td>
                            </tr>
                        ';
                    }


                    break;

            }

            echo $html;

            Yii::app()->end();
        }
    }

    /** Создает BODY на основе входных параметров */
    private function getBody($model){
        /*
         * Базовый шаблон внешнего вида меню.
         * в $base_template_head - задается стиль для меню общий
         * в $base_template_body_link - задается стиль для элементов меню (для ССЫЛОК)
         * в $base_template_body_menu - задается стиль для элементов меню (для ГРУПП МЕНЮ)
         */
        $base_template_head = $model->base_template_head;
        $base_template_body_link = $model->base_template_body_link;
        $base_template_body_menu = $model->base_template_body_menu;
        $param = $model->param_menu;



        //Строим меню по параметрам
        $base_template_body = '';
        $param = explode("|", $param);
        foreach ($param as $value){
            $tmp_val = explode("=", $value);
            if (count($tmp_val)!=2){ continue; }
            $key = $tmp_val[0];
            $val = $tmp_val[1];

            $tmp = '';
            $init_model = '';
            $name_menu = '';
            $url_img = '';
            $links_menu = '';
            $url_link = '';
            $name_link = '';

            switch ($key) {
                case 'menu':
                    //Строим группу меню
                    //$modelMenu = Menu::model()->findByPk((int)$val);
                    //$name_menu = $modelMenu->name;
                    //$url_img = (!empty($modelMenu->image)) ? '/uploads/filestorage/menu/rubrics/menu-'.$modelMenu->id.'.'.$modelMenu->image : '';
                    /*
                    foreach (Pages::model()->findAll('menu_id = '.$modelMenu->id.' AND status = 2') as $data){
                        $links_menu .= '<li><a style="margin-top:-1px" href="/'.$data->url.'">'.$data->title.'</a></li>';
                    }
                    */
                    $init_model = "<?php \$modelMenu = Menu::model()->findByPk(".(int)$val."); ?>";

                    $name_menu = "<?=\$modelMenu->name;?>";
                    $url_img = "<?=(!empty(\$modelMenu->image)) ? '/uploads/filestorage/menu/rubrics/menu-'.\$modelMenu->id.'.'.\$modelMenu->image : '';?>";
                    $links_menu = "
                        <?php foreach (Pages::model()->findAll('menu_id = '.\$modelMenu->id.' AND status = 2') as \$data){ ?>
                            <?php if (Yii::app()->user->getAccess() >= (int)\$data->access_lvl){ ?>
                                <li><a style='margin-top:-1px' href='<?=\$data->url;?>'><?=\$data->title;?></a></li>
                            <?php } ?>
                        <?php } ?>
                    ";



                    //Собираем
                    $tmp = str_replace("%init_model%", $init_model, $base_template_body_menu);

                    $tmp = str_replace("%links_menu%", $links_menu, $tmp);
                    $tmp = str_replace("%name_menu%", $name_menu, $tmp);
                    $tmp = str_replace("%url_img%", $url_img, $tmp);
                    $base_template_body .= $tmp;
                    break;
                case 'link':
                    //Строим ссылки меню
                    $init_model = "<?php \$modelMenu = Pages::model()->findByPk(".(int)$val."); ?>";

                    $url_link = "<?=\$modelMenu->url;?>";
                    $name_link = "<?=\$modelMenu->title;?>";
                    $url_img = "<?=(!empty(\$modelMenu->image)) ? '/uploads/filestorage/menu/elements/menu-'.\$modelMenu->id.'.'.\$modelMenu->image : '';?>";



                    //Собираем
                    $tmp = str_replace("%init_model%", $init_model, $base_template_body_link);

                    $tmp = str_replace("%url_link%", $url_link, $tmp);
                    $tmp = str_replace("%url_img%", $url_img, $tmp);
                    $tmp = str_replace("%name_link%", $name_link, $tmp);
                    $base_template_body .= $tmp;
                    break;
            }
        }
        //Получаем полный темплейт
        $base_template_head = str_replace("%base_template_body%", $base_template_body, $base_template_head);
        return $base_template_head;
    }

    private function createTemplateFile($model){
        $content = "";
        if (!empty($model->script)){
            $content .= '
                <script>
                '.$model->script.'
                </script>
            ';
        }
        if (!empty($model->style)){
            $content .= '
                <style>
                '.$model->style.'
                </style>
            ';
        }

        $content .= $model->body;

        $name_file = 'gentmpl'.$model->id.'.php';
        $pagesURL = (dirname(Yii::app()->basePath)).'/app/apps/frontend/views/layouts/'.$name_file;

        $fp = fopen($pagesURL, "w");
        fwrite( $fp, $content);
        fclose($fp);
        return $name_file;
    }

}
