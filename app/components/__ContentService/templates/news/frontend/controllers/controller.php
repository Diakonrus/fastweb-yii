<?php

class NewsController extends Controller
{
	public $layout='//layouts/main';


	public function actionIndex()
	{
        $model = News::model()->findAll( array('order'=>'maindate DESC'));
		$this->render('index', array('model'=>$model));
	}

    public  function actionNews($key){
        $model = News::model()->findByPk($key);
        $this->render('view', array('model'=>$model));
    }


}