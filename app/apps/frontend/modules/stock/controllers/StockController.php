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

        //Титл и SEO
        $this->pageTitle =  'Статьи -' . $this->pageTitle;
        foreach ( explode("/", ( parse_url(Yii::app()->request->requestUri, PHP_URL_PATH ))) as $url  ){
            $this->setSEO($url);
        }

        $model = Stock::model()->findAll(array(
            "condition" => "status!=0",
            "order" => "id DESC",
        ));
		$this->render('index', array('model'=>$model));
	}

    public  function actionElement($param){

        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);

        $model = Stock::model()->findByPk($paramArr);

        if (empty($model)){throw new CHttpException(404,'The page can not be found.');}

        //Титл и SEO
        $this->setSEO(Yii::app()->request->requestUri, 'Статьи', $model);


        //Смотрим, нужно ли вставить фотогалерею
        $model->description = $this->addPhotogalery($model->description);

        Pages::returnUrl(4);

        $this->render('view', array('model'=>$model));
    }


}