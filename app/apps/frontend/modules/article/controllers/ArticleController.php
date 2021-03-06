<?php

class ArticleController extends Controller
{
	public $layout='//layouts/main';


    public function actionIndex()

    {
        $root = ArticleRubrics::getRoot(new ArticleRubrics);
        $model = $root->descendants(1)->findAll($root->id);

        $pageArray = array();


        $this->setSEO(Yii::app()->request->requestUri, 'Статьи');

        $this->render('index', array('model'=>$model, 'modelElements'=>array(),  'pageArray' => $pageArray));


    }

    public  function actionElement($param){
        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);
        $paramArr = strtolower($paramArr);

        if (is_numeric($paramArr)){
            $modelElements = ArticleElements::model()->findByPk($paramArr);
            $model = ArticleRubrics::model()->findByPk($modelElements->parent_id);
            if (!$model){ throw new CHttpException(404,'The page can not be found.'); }
            $this->setSEO(Yii::app()->request->requestUri, 'Статьи', $model);

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
                    if ($tmpParam = ArticleRubrics::model()->find('id in ('.(current($module_id)).') AND `status` = 1')){
                        $paramArr = $tmpParam->url;
                    }
                }
            }


            $model =  ArticleRubrics::model()->find('url LIKE "'.$paramArr.'"');
            if (!$model){ throw new CHttpException(404,'The page can not be found.'); }
            $this->setSEO(Yii::app()->request->requestUri, 'Статьи', $model);


            $pageArray = array();
            $pageArray[0]['name'] = ' / '.$model->name;
            $pageArray[0]['url'] = null;
            $i = 1;
            foreach ($model->ancestors()->findAll('level>1') as $data){
                $pageArray[$i]['name'] = ' / '.$data->name;
                $pageArray[$i]['url'] = 'article/'.$data->url;
                ++$i;
            }
            rsort($pageArray);




            if (count($pageArray)>1) { rsort($pageArray); }

            $modelElements = ArticleElements::model()->findAll('parent_id = '.$model->id.' AND `status`=1 ORDER BY `primary` DESC');

            $model = $model->descendants(1)->findAll($model->id);

            $render = 'index';
        }




        $this->render($render, array('model'=>$model, 'modelElements'=>$modelElements,  'pageArray' => $pageArray));

    }




}