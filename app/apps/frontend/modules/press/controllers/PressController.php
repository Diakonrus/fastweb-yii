<?php

class PressController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        //Проверяю что модуль не отключен
        if (SiteModuleSettings::model()->find('site_module_id = 14 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
    }

	public function actionIndex()
	{
        $model = array();
        //получаем новости в группах
        $model['group'] = PressGroup::model()->findAll(
            array(
                "condition" => "status!=0",
                "order" => "id ASC",
        ));

        $model_tmp = PressGroup::model()->find(array(
            "condition" => "status!=0",
            "order" => "id ASC",
        ));
        //получаем новости без групп
        $model['first_group'] = Press::model()->findAll(array(
            "condition" => "status!=0 AND group_id=".$model_tmp->id,
            "order" => "id ASC",
        ));
        $param = $model_tmp->id;

        $this->setSEO(Yii::app()->request->requestUri, 'Пресса о нас');

		$this->render('index', array('model'=>$model, 'param' => $param));
	}

    public  function actionElement($param){
        //Если параметр текст - это каталог, если число - элемент
        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);

        if (is_numeric($paramArr)){
            //Число - это элемент
            $model = Press::model()->findByPk((int)$paramArr);

            $this->setSEO(Yii::app()->request->requestUri, 'Пресса о нас', $model);


            //Смотрим, нужно ли вставить фотогалерею
            $model->description = $this->addPhotogalery($model->description);
            $param = null;

            $render = 'view';
        }
        else {
            //Список новостей категории
            $paramArr = str_replace("press-", "", $paramArr);
            $model = array();
            //получаем новости в группах
            $model['group'] = PressGroup::model()->findAll(
                array(
                    "condition" => "status!=0",
                    "order" => "id ASC",
                ));

            $model_tmp = PressGroup::model()->find(array(
                "condition" => "status!=0 AND url LIKE '".$paramArr."'",
                "order" => "id ASC",
            ));

            $this->setSEO(Yii::app()->request->requestUri, 'Пресса о нас', $model_tmp);

            //получаем новости без групп
            $model['first_group'] = Press::model()->findAll(array(
                "condition" => "status!=0 AND group_id=".$model_tmp->id,
                "order" => "id ASC",
            ));
            $param = $model_tmp->id;
            $render = 'index';
        }


        if (empty($model)){throw new CHttpException(404,'The page can not be found.');}
        $this->render($render, array('model'=>$model, 'param'=>$param));
    }


}