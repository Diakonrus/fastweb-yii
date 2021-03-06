<?php

class PagesController extends Controller
{
	public $layout='//layouts/main';


    public function actionIndex($id){
        $model = Pages::model()->findByPk($id);
        if (!$model || $model->status == 0){ throw new CHttpException(404,'The page can not be found.'); }

        //Титл и SEO
        $this->setSEO($model->url, (mb_convert_case($model->title, MB_CASE_UPPER, "UTF-8")));

        $this->layout = '//layouts/'.$model->main_template;

        $modelCatalog = null;
        $modelNews = null;
        //Если главная - добавляю товары помеченые как на главную и новости
        if($model->main_page == 1){
            $modelCatalog = CatalogElements::model()->findAll('`status` = 1 AND `primary` = 1');
            $modelNews = NewsElements::gatPrimaryNews();
        }


        //Проверка прав доступа
        if ($model->access_lvl>0){
            if (Yii::app()->user->isGuest){ $this->redirect('/login'); }

        }


        //Проверяем есть ли фотогалерея, если есть - меняем содержимое страницы
        $model->content = $this->addPhotogalery($model->content);

        //Проверяем есть ли форма, если есть - меняем содержимое страницы
        $model->content = $this->addForm($model->content);

        //Получаем вкладки если есть;
        $modelTabs = PagesTabs::model()->getTabsContent($id);
        $this->render('index', array('model'=>$model, 'modelTabs'=>$modelTabs, 'modelCatalog'=>$modelCatalog, 'modelNews'=>$modelNews));
    }





}
