<?php

class NewsController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        //Проверяю что модуль не отключен
        if (SiteModuleSettings::model()->find('site_module_id = 1 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
    }

	public function actionIndex()
	{

        Pages::returnUrl('kategoriya');



        //Титл и SEO
        $this->pageTitle =  'Новости -' . $this->pageTitle;
        foreach ( explode("/", ( parse_url(Yii::app()->request->requestUri, PHP_URL_PATH ))) as $url  ){
            $this->setSEO($url);
        }

        $model = array();
        //получаем новости в группах
        $model['group'] = NewsGroup::model()->findAll(
            array(
                "condition" => "status!=0",
                "order" => "id DESC",
        ));

        //получаем новости без групп
        $model['no_group'] = News::model()->findAll(array(
            "condition" => "status!=0 AND group_id=0",
            "order" => "id DESC",
        ));
		$this->render('index', array('model'=>$model));
	}

    public  function actionElement($param){
        //Если параметр текст - это каталог, если число - элемент
        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);

        if (is_numeric($paramArr)){
            //Число - это элемент
            $model = News::model()->findByPk((int)$paramArr);

            //Титл и SEO
            $this->setSEO(Yii::app()->request->requestUri, 'Новости', $model);

            //Смотрим, нужно ли вставить фотогалерею
            $model->description = $this->addPhotogalery($model->description);
            $render = 'view';
        }
        else {
            //Список новостей категории
            $modelGroup = NewsGroup::model()->find('url LIKE "'.$paramArr.'"');

            //Титл и SEO
            $this->setSEO(Yii::app()->request->requestUri, 'Новости', $modelGroup);

            $model = array();
            $model['group'] = NewsGroup::model()->findAll(
				array(
					"condition" => "status!=0",
					"order" => "id DESC",
			));
            $model['no_group'] = News::model()->findAll(array(
                "condition" => "status!=0 AND group_id = ".$modelGroup->id,
                "order" => "id DESC",
            ));

            $render = 'index';
        }


        if (empty($model)){throw new CHttpException(404,'The page can not be found.');}
        $this->render($render, array('model'=>$model));
    }


}