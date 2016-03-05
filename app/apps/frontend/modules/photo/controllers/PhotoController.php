<?php

class PhotoController extends Controller
{
	public $layout='//layouts/main';

    public function actionIndex()
    {
        if (SiteModuleSettings::model()->find('site_module_id = 11 AND `status`=0')) {
            throw new CHttpException(404, 'The page can not be found.');
        }

        //1 - Получаем верхнее меню ссылок
        //2 - получаем список категорий в активном (выбраном) разделе

        //1
        $root = PhotoRubrics::getRoot(new PhotoRubrics);
        $menu_top = array();

        //Титл и SEO
        $this->setSEO(Yii::app()->request->requestUri, 'Фотогалерея', (($root->level>1)?($root):(null)));

        foreach ( $root->descendants(1,1)->findAll($root->id) as $data ){
            
			$menu_top[$data->id]['name'] = $data->name;
            $menu_top[$data->id]['url'] = $data->url;
            $menu_top[$data->id]['image'] = $data->id.".".$data->image;
        }
		
		$model["title"] = "ФОТОГАЛЕРЕЯ";
		$model['catalogs'] = array();
        $model['elements'] = array();
		
		//2
        //т.к. это первая страница - активный раздел первый
        $param_model = $root->descendants(1,1)->findAll($root->id);
        $param = array_shift( $param_model );
		
		$model['elements'] = PhotoElements::model()->findAll('parent_id='.$param->id.' AND `status`=1');




        $this->render('index', array('model'=>$model, 'param'=>$param, 'menu_top'=>$menu_top));

    }

    public  function actionElement($param){
        if (SiteModuleSettings::model()->find('site_module_id = 11 AND `status`=0')) {
            throw new CHttpException(404, 'The page can not be found.');
        }

        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);
        $paramArr = strtolower($paramArr);


        $root = PhotoRubrics::getRoot(new PhotoRubrics);
        $menu_top = array();

        //2
        $root = PhotoRubrics::model()->find('url LIKE "'.$paramArr.'"');
        $param_model = $root->descendants(1,1)->findAll($root->id);

        //Титл и SEO
        $this->setSEO(Yii::app()->request->requestUri, 'Фотогалерея', (($root->level>1)?($root):(null)));

		foreach ( $param_model as $data ){
            
			$menu_top[$data->id]['name'] = $data->name;
            $menu_top[$data->id]['url'] = $data->url;
            $menu_top[$data->id]['image'] = $data->id.".".$data->image;
        }
		
        $page = array();
        foreach ($root->ancestors()->findAll() as $data){
            if ($data->level==1){ continue; }
            $page[] = $data->name;
        }
        $page[] = $root->name;

		$model["title"] = $root->name; //implode(' / ', $page);
		
        $param = $root;

        $model['catalogs'] = array();
        $model['elements'] = array();

        $category = PhotoRubrics::model()->findByPk($param->id);
        $tmp_model = $category->descendants(1,1)->findAll();
        if ( $tmp_model = $category->descendants(1,1)->findAll() ){
            //3 Категорий нет  - получаю картинки в раздела
            //$model['catalogs'] = $tmp_model;
        } else {
            //3 Категорий нет  - получаю картинки в раздела
            $model['elements'] = PhotoElements::model()->findAll('parent_id='.$param->id.' AND `status`=1');
        }



        //ФОТОГАЛЕРЕЯ
        //$this->title_page = 'ФОТОГАЛЕРЕЯ'.'<span>'.$page.'</span>';


        $this->render('index', array('model'=>$model, 'param'=>$param, 'menu_top'=>$menu_top));


    }




}