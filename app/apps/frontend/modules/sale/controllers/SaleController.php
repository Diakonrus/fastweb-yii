<?php

class SaleController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        //Проверяю что модуль не отключен
        if (SiteModuleSettings::model()->find('site_module_id = 9 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
    }

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
        $this->setSEO(Yii::app()->request->requestUri, 'Акции');
		$this->render('index', array('model'=>$model));
	}

    public  function actionElement($param){
        //Если параметр текст - это каталог, если число - элемент
        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);

        if (is_numeric($paramArr)){
            //Число - это элемент
            $model = array();
            $model['group'] = array();
            $modelSale = Sale::model()->findByPk((int)$paramArr);
            if (empty($modelSale)){throw new CHttpException(404,'The page can not be found.');}

            $parent = SaleGroup::model()->findByPk((int)$modelSale->group_id);
            $this->setSEO(Yii::app()->request->requestUri, 'Акции', $parent);

            $model['page'] = array();
            if (!empty($parent)){
                $model['page'][0]['url'] = $parent->url;
                $model['page'][0]['name'] = $parent->name;
            }


            //Смотрим, нужно ли вставить фотогалерею
            $modelSale->description = $this->addPhotogalery($modelSale->description);
            $model['elements'][] = $modelSale;
            $render = 'view';
        }
        else {
            //Список новостей категории
            $modelGroup = SaleGroup::model()->find('url LIKE "'.$paramArr.'"');
            if (empty($modelGroup)){throw new CHttpException(404,'The page can not be found.');}

            $this->setSEO(Yii::app()->request->requestUri, 'Акции', $modelGroup);

            $model = array();
            $model['group'] = $modelGroup;
            $model['elements'] = Sale::model()->findAll(array(
                "condition" => "status!=0 AND group_id = ".$modelGroup->id,
                "order" => "id DESC",
            ));

            $model['page'] = array();
            $model['page'][0]['url'] = $modelGroup->url;
            $model['page'][0]['name'] = $modelGroup->name;

            $render = 'view';
        }


        if (empty($model)){throw new CHttpException(404,'The page can not be found.');}
        $this->render($render, array('model'=>$model, 'param_url' => $paramArr));
    }


}