<?php

class SaleController extends Controller
{
	public $layout='//layouts/main';

	public function actionIndex()
	{
        $model = array();
        //получаем новости в группах
        $model['group'] = SaleGroup::model()->findAll(
            array(
                "condition" => "status!=0",
                "order" => "id DESC",
        ));

        //получаем новости без групп
        $model['no_group'] = Sale::model()->findAll(array(
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
            $model = Sale::model()->findByPk((int)$paramArr);
            //Смотрим, нужно ли вставить фотогалерею
            $model->description = $this->addPhotogalery($model->description);
            $render = 'view';
        }
        else {
            //Список новостей категории
            $modelGroup = SaleGroup::model()->find('url LIKE "'.$paramArr.'"');
            $model = array();
            $model['group'] = array();
            $model['no_group'] = Sale::model()->findAll(array(
                "condition" => "status!=0 AND group_id = ".$modelGroup->id,
                "order" => "id DESC",
            ));

            $render = 'index';
        }


        if (empty($model)){throw new CHttpException(404,'The page can not be found.');}
        $this->render($render, array('model'=>$model));
    }


}