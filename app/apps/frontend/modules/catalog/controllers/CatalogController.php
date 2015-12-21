<?php

class CatalogController extends Controller
{

    public $layout='//layouts/main';

    public function init(){
        //Проверяю что модуль не отключен
        if (SiteModuleSettings::model()->find('site_module_id = 4 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
    }

    //ToDo Не забыть про 404 страницу
    public function actionIndex(){


        //получаем список категорий
        $root = CatalogRubrics::model()->roots()->find();
        $model = CatalogRubrics::model()->findByPk($root->id);
        $descendants = $model->descendants(1,1)->findAll();

        $this->render('index', array('model'=>$model, 'descendants'=>$descendants));
    }

    public function actionList($param){
        //разбираем URL
        $paramArr = explode("/", $param);
        $url = array_pop($paramArr);
        //есди URL - число, то мы на странице товара, если нет - список
        if ((int)$url==0){
            $modelRubric =  CatalogRubrics::model()->find('url LIKE ("'.$url.'")');
            if (!$modelRubric){ throw new CHttpException(404,'The page can not be found.'); }
            //получаем товары
            $model = CatalogElements::model()->findAll('parent_id='.(int)$modelRubric->id.' ORDER BY order_id');
            $modelChars = CatalogChars::model()->findAll('parent_id='.$modelRubric->id.' AND status = 1');
            $render = 'list';

        } else {
            $modelRubric = null;
            $model = CatalogElements::model()->findByPk((int)$url);
            if (!$model){ throw new CHttpException(404,'The page can not be found.'); }
            $modelChars = CatalogChars::model()->findAll('parent_id='.$model->parent_id.' AND status = 1');
            $render = 'show';
        }


        //SEO
        if (isset($paramArr[0]) && !empty($paramArr[0])) {
            if ( $modelRubricSEO =  CatalogRubrics::model()->find('url LIKE ("'.$paramArr[0].'")') ){
                if (isset($modelRubricSEO->meta_title) && !empty($modelRubricSEO->meta_title)){ $this->pageMetaTitle = $modelRubricSEO->meta_title; }
                if (isset($modelRubricSEO->meta_keywords) && !empty($modelRubricSEO->meta_keywords)){ $this->pageKeywords = $modelRubricSEO->meta_keywords; }
                if (isset($modelRubricSEO->meta_description) && !empty($modelRubricSEO->meta_description)){ $this->pageDescription = $modelRubricSEO->meta_description; }
            }
        }


        $this->render($render, array('model'=>$model, 'modelRubric'=>$modelRubric, 'modelChars'=>$modelChars, 'param'=>$param));
    }



}
