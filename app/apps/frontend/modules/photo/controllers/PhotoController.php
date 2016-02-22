<?php

class PhotoController extends Controller
{
	public $layout='//layouts/main';


    public function actionIndex()

    {
        $root = PhotoRubrics::getRoot(new PhotoRubrics);
        $model = $root->descendants(1,1)->findAll($root->id);

        $this->setSEO(Yii::app()->request->requestUri, 'Фотогалерея');

        $this->render('index', array('model'=>$model, 'modelElements'=>array(),  'pageArray' => array()));
    }

    public  function actionElement($param){
        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);
        $paramArr = strtolower($paramArr);

        if (is_numeric($paramArr)){
            $modelElements = PhotoElements::model()->findByPk($paramArr);
            $model = PhotoRubrics::model()->findByPk($modelElements->parent_id);
            if (!$model){ throw new CHttpException(404,'The page can not be found.'); }
            $this->setSEO(Yii::app()->request->requestUri, 'Фото', $model);

            $pageArray = array();
            $i = 0;
            foreach ($model->ancestors()->findAll() as $data){
                if ($data->level == 1){continue;}
                $pageArray[$i]['url'] = $data->url;
                $pageArray[$i]['name'] = $data->name;
                ++$i;
            }
            $pageArray[$i]['url'] = $model->url;
            $pageArray[$i]['name'] = $model->name;
            if (count($pageArray)>1) { rsort($pageArray); }
            $model = $model->descendants(1)->findAll($model->id);
            $render = 'view';
        } else {

            if ( $modelPage = Pages::model()->find('url LIKE "'.$param.'"') ){
                if ( $modelTabs = PagesTabs::model()->find('pages_id='.$modelPage->id) ){
                    $module_id = array_diff((explode("|", $modelTabs->site_module_value)), array(''));
                    if ($tmpParam = PhotoRubrics::model()->find('id in ('.(current($module_id)).') AND `status` = 1')){
                        $paramArr = $tmpParam->url;
                    }
                }
            }


            $model =  PhotoRubrics::model()->find('url LIKE "'.$paramArr.'"');
            if (!$model){ throw new CHttpException(404,'The page can not be found.'); }
            $this->setSEO(Yii::app()->request->requestUri, 'Статьи', $model);


            $pageArray = array();
            $pageArray[0]['name'] = ' / '.$model->name;
            $pageArray[0]['url'] = null;
            $i = 1;
            foreach ($model->ancestors()->findAll('level>1') as $data){
                $pageArray[$i]['name'] = ' / '.$data->name;
                $pageArray[$i]['url'] = 'Photo/'.$data->url;
                ++$i;
            }
            rsort($pageArray);




            if (count($pageArray)>1) { rsort($pageArray); }

            $modelElements = PhotoElements::model()->findAll('parent_id = '.$model->id.' AND `status`=1');

            $model = $model->descendants(1)->findAll($model->id);

            $render = 'index';
        }




        $this->render($render, array('model'=>$model, 'modelElements'=>$modelElements,  'pageArray' => $pageArray));

    }




}