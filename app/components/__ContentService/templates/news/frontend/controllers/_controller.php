<?php

class NewsController extends Controller
{
	public $layout='//layouts/[%layout%]';


	public function actionIndex()
	{
        $model = News::model()->findAll( array('order'=>'t.created_at DESC'));
		$this->render('index', array('model'=>$model));
	}

    public  function actionNews($key){
        $model = News::model()->findByPk($key);
        $this->render('view', array('model'=>$model));
    }


}