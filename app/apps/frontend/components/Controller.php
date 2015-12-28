<?php
/**
 * Кастомный контроллер для frontend режима
 */
class Controller extends CController
{
	public $menu=array();
	public $breadcrumbs=array();
    public $layout='//layouts/main';

    //SEO
    public $siteName = SITE_TITLE;   //Имя сайта
    public $pageTitle = SITE_TITLE;
    public $pageMetaTitle;
    public $pageDescription;
    public $pageKeywords;


    public $user;
    public $balance;

    public $registrationForm;
    public $loginForm;

    public $menuLists = array();

	public function init(){
        //Получаем список меню
        //$root = Pages::getRoot(new Pages);
        //$this->menuLists = $root->descendants(null,1)->findAll($root->id);
        $this->menuLists = Pages::model()->getPagesArray();
	}


    public function setSEO($url_patch, $page_title =  null, $modelSEO = null){
        $url_patch = trim($url_patch);
        $this->pageTitle = ((!empty($page_title))?($page_title.' - '):('')).$this->siteName;
        $url_array =  explode("/", ( parse_url($url_patch, PHP_URL_PATH )));
        foreach ( $url_array as $url  ){
            $model = Pages::model()->find('url LIKE "'.$url.'"');
            if ($model){
                if (!empty($model->meta_title)){ $this->pageTitle = $model->meta_title; $this->pageMetaTitle = $model->meta_title; }
                if (!empty($model->meta_keywords)){ $this->pageKeywords = $model->meta_keywords;  }
                if (!empty($model->meta_description)){ $this->pageDescription = $model->meta_description;  }
            }
        }
        if (!empty($modelSEO)){
            if (isset($modelSEO->meta_title) && !empty($modelSEO->meta_title)){ $this->pageTitle = $modelSEO->meta_title; $this->pageMetaTitle = $modelSEO->meta_title; }
            if (isset($modelSEO->meta_keywords) && !empty($modelSEO->meta_keywords)){ $this->pageKeywords = $modelSEO->meta_keywords;  }
            if (isset($modelSEO->meta_description) && !empty($modelSEO->meta_description)){ $this->pageDescription = $modelSEO->meta_description;  }
        }

        return true;
    }



    public function filters()
    {
        $filters = array();

        // Для работы кеша параметр PAGE_CACHETIME должен быть больше 0
        if( !Yii::app()->user->id ){

            $filters[] = array(
                'COutputCache',
                'duration'=> PAGE_CACHETIME,
                'requestTypes'=>array('GET'),
                'varyByRoute' => true,
                //'varyByParam'=>array('r'),
            );
        }

        //$filters[] = array('accessControl');

        return $filters;
    }

	public function accessRules(){
        //return array (
        //    array(
        //        'allow',
        //        'users'=>array('*'),
        //    ),
        //);
    }

    /**
     * Загрузка файла на сервер (устаревший метод, сейчас используется EFineUploader)
     *
     * notice: метод get_class заменен на нативный instanceof, а также
     * теперь метод возвращает полное имя файла, если загрузка удалась, иначе false
     */
    public function uploadFile($model, $fieldName, $path = '/uploads/images') {

        $file = CUploadedFile::getInstance($model, $fieldName);

        if (is_object($file) && ($file instanceof CUploadedFile)) {
            $date = date('YmdHms');
            $filename = Yii::app()->basePath . '/../www' . $path . '/' . $date . '_' . $file;
            $file->saveAs($filename);
            $model->$fieldName = $date . '_' . $file;
            return $filename;
        }
        return false;
    }


    /**
     * Дополняем меню до нужного вида
     */
    public function stateUrl($name, $add = array(), $remove = array() ){

        foreach($remove as $item){
            unset($add[$item]);
        }

        return $this->createUrl($name, $add);
    }

    public function itemUrl($name, $id){
        return $this->stateUrl($name, array('id' => $id) + $_GET, array('ajax'));
    }

    public function listUrl($name){
        return $this->stateUrl($name, $_GET, array('id'));
    }


    /*
     * Проверяет текст на необходимость вставки фотогалереи
     */
    public function addPhotogalery($body){

        preg_match_all('/\{myphotogalery id=(\d+)\}/', $body, $matches);
        if (!empty($matches)){

            $url_to_img = '/uploads/filestorage/photo/elements/';
            foreach ($matches[1] as $id){
                //Получаем шаблон активной фотогалереи
                if( $template_photogalery = PhotoTemplate::model()->find('active=1') ){
                    $photoContent = '';
                    foreach ( PhotoElements::model()->findAll('parent_id='.(int)$id.' AND status=1') as $data ){
                        $url_to_full_image = $url_to_img.'medium2-'.$data->id.'.'.$data->image;
                        $url_to_small_image = $url_to_img.'small-'.$data->id.'.'.$data->image;
                        $photoContent .= $template_photogalery->val;
                        $photoContent = str_replace('%url_to_full_image%', $url_to_full_image, $photoContent);
                        $photoContent = str_replace("%url_to_small_image%", $url_to_small_image, $photoContent);
                    }
                    $body = str_replace("{myphotogalery id=".$id."}", $photoContent, $body);
                }
            }

        }


        return $body;
    }

    /*
     * Проверяет текст на необходимость вставки формы
     */
    public function addForm($body){
        preg_match_all('/\{myforms id=(\d+)\}/', $body, $matches);
        if (!empty($matches)){
            $id = (current($matches[1]));
            $body_feeld = CreatingFormRubrics::model()->showForm( $id );
            $body = str_replace("{myforms id=".$id."}", $body_feeld, $body);
        }
        return $body;
    }

    public function sendEmail($email = null, $title = null, $body = null){
        if (!empty($email) && !empty($title)){
            preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $email, $match);
            if (!empty($match)){
                Yii::app()->mailer->send(array('email'=>$email, 'subject'=>$title, 'body'=>$body));
                return true;
            }
            else { return false; }
        }
    }



}