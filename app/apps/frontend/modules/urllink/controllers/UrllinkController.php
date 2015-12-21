<?php

class UrllinkController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        //Проверяю что модуль не отключен
        if (SiteModuleSettings::model()->find('site_module_id = 8 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
    }

	public function actionIndex($id)
	{
        $model = Pages::model()->findByPk($id);
        $model->url = mb_strtolower($model->url);
        $model->url = str_replace("http://", "", $model->url);
        header('Location: http://'.$model->url);
	}

    public  function actionElement($key){

    }


}