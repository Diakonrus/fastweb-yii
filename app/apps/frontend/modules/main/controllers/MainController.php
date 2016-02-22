<?php

class MainController extends Controller
{
	public $layout='//layouts/main';


	public function actionIndex()
	{
		//echo 123;
		$this->render('index', array('sitemap'=>''));
	/*
        $sitemap = array();
        //Список текстовых страниц
        $i = 0;
        foreach ( Pages::model()->findAll('status=2') as $data ){
            $k = $data->id;
            $sitemap[$i]['name'] = $data->title;
            $sitemap[$i]['url'] = '/'.$data->url;
            ++$i;
        }

		$this->render('index', array('sitemap'=>$sitemap));
		*/
	}




}
