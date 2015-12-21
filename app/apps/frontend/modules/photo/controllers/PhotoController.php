<?php

class PhotoController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        //Проверяю что модуль не отключен
        if (SiteModuleSettings::model()->find('site_module_id = 11 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
    }

    public function actionIndex()

    {

        //1 - Получаем верхнее меню ссылок
        //2 - получаем список категорий в активном (выбраном) разделе
        //3 - Если категорй нет - получаем картинки в этом разделе

        //1
        $root = PhotoRubrics::getRoot(new PhotoRubrics);
        $menu_top = array();

        foreach ( $root->descendants(1,1)->findAll($root->id) as $data ){
            $menu_top[$data->id]['name'] = $data->name;
            $menu_top[$data->id]['url'] = $data->url;
        }

        //2
        //т.к. это первая страница - активный раздел первый
        $param_model = $root->descendants(1,1)->findAll($root->id);
        $param = array_shift( $param_model );

        $model['catalogs'] = array();
        $model['elements'] = array();

        $category = PhotoRubrics::model()->findByPk($param->id);
        $tmp_model = $category->descendants(1,1)->findAll();
        if ( $tmp_model = $category->descendants(1,1)->findAll() ){
            //3 Категорий нет  - получаю картинки в раздела
            $model['catalogs'] = $tmp_model;
        } else {
            //3 Категорий нет  - получаю картинки в раздела
            $model['elements'] = PhotoElements::model()->findAll('parent_id='.$param->id.' AND `status`=1');
        }

        $page = '';

        //ФОТОГАЛЕРЕЯ
        $this->title_page = 'ФОТОГАЛЕРЕЯ'.'<span>'.$page.'</span>';


        $this->render('index', array('model'=>$model, 'param'=>$param, 'menu_top'=>$menu_top));

        /*
        //Общий список категорий вопросов
        $model['group'] = array();
        $model['sub_group'] = array();
        $model['element'] = array();
        $root = PhotoRubrics::getRoot(new PhotoRubrics);
        $model_tmp = $root->descendants(1,1)->findAll($root->id);
        foreach ($model_tmp as $data){
            $model['group'][$data->id] = $data;

            if ( $model_sub_tmp = PhotoRubrics::model()->findByPk($data->id)->descendants(1,1)->findAll($root->id) ){
                $model['sub_group'][$data->id] = $model_sub_tmp;
            }

        }
        //Получаю картинки в разделе
        $model['element']['sub_catalog'][$root->id] = PhotoElements::model()->findAll('parent_id='.$root->id.' AND `status` = 1');


        $page = '';
        $param = array_shift($model_tmp);
        $param = $param->id;

        //ФОТОГАЛЕРЕЯ
        $this->title_page = 'ФОТОГАЛЕРЕЯ'.'<span>'.$page.'</span>';

        $root = PhotoRubrics::getRoot(new PhotoRubrics);
        $menu_top = $root->descendants(1,1)->findAll($root->id);

        $this->render('index', array('model'=>$model, 'param'=>$param, 'menu_top'=>$menu_top));
    */






    }

    public  function actionElement($param){
        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);
        $paramArr = strtolower($paramArr);


        $root = PhotoRubrics::getRoot(new PhotoRubrics);
        $menu_top = array();

        foreach ( $root->descendants(1,1)->findAll($root->id) as $data ){
            $menu_top[$data->id]['name'] = $data->name;
            $menu_top[$data->id]['url'] = $data->url;
        }

        //2
        $root = PhotoRubrics::model()->find('url LIKE "'.$paramArr.'"');
        $param_model = $root->descendants(1,1)->findAll($root->id);

        $page = '';
        foreach ($root->ancestors()->findAll() as $data){
            if ($data->level==1){ continue; }
            $page .= ' / '.$data->name;
        }
        $page .= ' / '.$root->name;


        $param = $root;

        $model['catalogs'] = array();
        $model['elements'] = array();

        $category = PhotoRubrics::model()->findByPk($param->id);
        $tmp_model = $category->descendants(1,1)->findAll();
        if ( $tmp_model = $category->descendants(1,1)->findAll() ){
            //3 Категорий нет  - получаю картинки в раздела
            $model['catalogs'] = $tmp_model;
        } else {
            //3 Категорий нет  - получаю картинки в раздела
            $model['elements'] = PhotoElements::model()->findAll('parent_id='.$param->id.' AND `status`=1');
        }



        //ФОТОГАЛЕРЕЯ
        $this->title_page = 'ФОТОГАЛЕРЕЯ'.'<span>'.$page.'</span>';


        $this->render('index', array('model'=>$model, 'param'=>$param, 'menu_top'=>$menu_top));


    }




}