<?php

class StockController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        //Проверяю что модуль не отключен
        if (SiteModuleSettings::model()->find('site_module_id = 6 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
    }

	public function actionIndex()
	{

        $model = Stock::model()->findAll(array(
            "condition" => "status!=0",
            "order" => "id DESC",
        ));
		$this->render('index', array('model'=>$model));
	}

    public  function actionElement($key){
        $model = Stock::model()->findByPk($key);

        //Смотрим, нужно ли вставить фотогалерею
        $model->description = $this->addPhotogalery($model->description);

        if (empty($model)){throw new CHttpException(404,'The page can not be found.');}
        $this->render('view', array('model'=>$model));
    }


}