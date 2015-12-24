<?php

class PagesController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        //Проверку прав вставить если надо
    }

    public function actionIndex($id){
        $model = Pages::model()->findByPk($id);
        if (!$model){ throw new CHttpException(404,'The page can not be found.'); }

        $this->layout = '//layouts/'.$model->main_template;

        //Проверка прав доступа
        if ($model->access_lvl>0){
            if (Yii::app()->user->isGuest){ $this->redirect('/login'); }

        }

        $this->pageTitle = mb_convert_case($model->title, MB_CASE_UPPER, "UTF-8");

        //Проверяем есть ли фотогалерея, если есть - меняем содержимое страницы
        $model->content = $this->addPhotogalery($model->content);

        //Проверяем есть ли форма, если есть - меняем содержимое страницы
        $model->content = $this->addForm($model->content);

        //Получаем вкладки если есть;
        $modelTabs = PagesTabs::model()->getTabsContent($id);

        //Титл
        $this->pageTitle = $this->pageTitle.' - '.$model->title;
        foreach ( explode("/", ( parse_url(Yii::app()->request->requestUri, PHP_URL_PATH ))) as $url  ){
            $this->setSEO($url);
        }

        $this->render('index', array('model'=>$model, 'modelTabs'=>$modelTabs));
    }





}