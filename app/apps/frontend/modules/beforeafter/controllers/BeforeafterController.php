<?php

class BeforeafterController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        //Проверяю что модуль не отключен
        if (SiteModuleSettings::model()->find('site_module_id = 12 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
    }

    public function actionIndex()
    {
        //Общий список категорий вопросов
        $root = BeforeAfterRubrics::getRoot(new BeforeAfterRubrics);
        $model = array();
        $model['group'] = null;
        $model['sub_group'] = $root->descendants(1)->findAll($root->id);

        $this->render('index', array('model'=>$model));
    }

    public  function actionElement($param){

        //Если параметр текст - это каталог, если число - элемент
        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);

        if (is_numeric($paramArr)){
            //Число - это элемент
            $model = BeforeAfterElements::model()->findAll('parent_id = '.(int)$paramArr);
            //Смотрим, нужно ли вставить фотогалерею
            $render = '_form';
        }
        else {
            //Список новостей категории
            $modelGroup =  BeforeAfterRubrics::model()->find('url LIKE "'.$paramArr.'"');
            $model = array();
            $model['group'] = $modelGroup;
            $model['sub_group'] = $modelGroup->descendants(1)->findAll();
            $render = 'index';
        }


        if (empty($model)){throw new CHttpException(404,'The page can not be found.');}
        $this->render($render, array('model'=>$model));
    }




}