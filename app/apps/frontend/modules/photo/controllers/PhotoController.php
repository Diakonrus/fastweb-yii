<?php

class PhotoController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        //Проверяю что модуль не отключен
        if (SiteModuleSettings::model()->find('site_module_id = 11 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}

        //Титл
        $this->pageTitle = $this->pageTitle.' - Фотогалерея';
        foreach ( explode("/", ( parse_url(Yii::app()->request->requestUri, PHP_URL_PATH ))) as $url  ){
            $this->setSEO($url);
        }
    }

    public function actionIndex()

    {

        //Получаем список под разделов 1ого раздела (Звезды)
        $root = PhotoRubrics::getRoot(new PhotoRubrics);
        $modelRoot = PhotoRubrics::model()->find('`level` = 2 AND left_key>'.$root->left_key.' AND right_key<'.$root->right_key.' AND `status` = 1');

        $model = $modelRoot->descendants(1,1)->findAll($modelRoot->id);


        //ФОТОГАЛЕРЕЯ
        $this->show_video_title_page = false;
        $this->title_page = 'ФОТОГАЛЕРЕЯ';
        $this->title_page .= '<span style="color: #b1b1b1;"> / '.$modelRoot->name.'</span>';


        $is_root = true;

        $this->setSEO(Yii::app()->request->requestUri, 'Фотогалерея', $modelRoot);

        $this->render('index', array('model'=>$model, 'root'=>$root, 'modelRoot'=>$modelRoot, 'is_root'=>$is_root));


    }

    public  function actionElement($param){
        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);
        $paramArr = strtolower($paramArr);


        //Получаем список под разделов 1ого раздела (Звезды)
        $root = PhotoRubrics::getRoot(new PhotoRubrics);
        $modelRoot = PhotoRubrics::model()->find('url LIKE "'.$paramArr.'"');

        if (empty($modelRoot)){throw new CHttpException(404,'The page can not be found.');}

        $this->setSEO(Yii::app()->request->requestUri, 'Фотогалерея', $modelRoot);

        $is_root = (($modelRoot->level==2)?true:false);
        if ($is_root){
            $model = $modelRoot->descendants(1,1)->findAll($modelRoot->id);
        } else {
            $model = PhotoElements::model()->findAll('parent_id = '.$modelRoot->id.' AND `status`=1');
            $page = PhotoRubrics::model()->findByPk($modelRoot->parent_id)->name;
        }

        //ФОТОГАЛЕРЕЯ
        $this->show_video_title_page = false;
        $this->title_page = 'ФОТОГАЛЕРЕЯ';
        foreach ( $modelRoot->ancestors()->findAll() as $data ){
            if ($data->level == 1){continue;}
            $this->title_page .= '<a href="'.$data->url.'"><span style="color: #b1b1b1;"> / '.$data->name.'</span></a>';
        }
        $this->title_page .= '<span style="color: #b1b1b1;"> / '.$modelRoot->name.'</span>';


        $this->render('index', array('model'=>$model, 'root'=>$root, 'modelRoot'=>$modelRoot, 'is_root'=>$is_root));

    }




}