<?php

class ContentService extends CApplicationComponent {

    /*
     *  Генерирует страницы во фронт
     *  createController, createView, save  - методы создания текстовых страниц
     *  news - создание модуля новостей
     */
    public $param = array();
    public $nameController = null;
    public $nameView = null;
    public $nameModel = "''";
    public $layout = null;
    public $typeContent = 0;
    public $viewbody = null;

    public function  setData($param=array()){
        $this->nameController  = (!empty($param['nameController']))?$param['nameController']:$this->nameController;
        $this->layout          = (!empty($param['layout']))?$param['layout']:$this->layout;
        $this->nameModel       = (!empty($param['nameModel']))?$param['nameModel']:$this->nameModel;
        $this->nameView        = (!empty($param['nameView']))?$param['nameView']:$this->nameView;
        $this->viewbody        = (!empty($param['viewbody']))?$param['viewbody']:$this->viewbody;
        $this->typeContent     = (!empty($param['typeContent']))?$param['typeContent']:$this->typeContent;

        if (!empty($this->nameController)){
            $this->nameController = strtolower($this->nameController);
            $this->nameController = ucfirst($this->nameController);
        }
    }
  /*
    public function setNameController($nameController){
        $this->nameController = $nameController;
    }

    public function setLayout($layout){
        $this->layout = $layout;
    }

    public function setNameModel($nameModel){
        $this->nameModel = $nameModel;
    }

    public function setNameView($nameView){
        $this->nameView = $nameView;
    }
*/

    public function createController() {

        if($this->typeContent != 0) exit;

        $urlTemplate = __DIR__ ."/ContentService/templates/default/controller.php";
        $controller = file_get_contents($urlTemplate);
        $controller = str_replace("[%nameController%]", $this->nameController, $controller);
        $controller = str_replace("[%layout%]", $this->layout, $controller);
        $controller = str_replace("[%nameModel%]", $this->nameModel, $controller);
        $controller = str_replace("[%nameView%]", $this->nameView, $controller);

        return $controller;
    }

    public function createView() {

        if($this->typeContent != 0) exit;

        $urlTemplate = __DIR__ ."/ContentService/templates/default/view.php";
        $view = file_get_contents($urlTemplate);
        $view = str_replace("[%viewBody%]", $this->viewbody, $view);

        return $view;
    }

    /*
     * Тип контента
     * $type = 1 - контроллер,
     * $type = 2 - вьюшка
     */
    public function save($patch, $content, $type=1){

        if($this->typeContent != 0) exit;

        if ($type == 2 && !file_exists($patch)) mkdir($patch);

        $name = ($type==1)?$this->nameController.'Controller.php':$this->nameView.'.php';
        $fp = fopen($patch.'/'.$name, "w");
        fwrite($fp, $content);
        fclose($fp);

        $arrayData = array();
        $modelURL = Pages::model()->findAll('status!=1');


        $content = "<?php return array( ";
        foreach ($modelURL as $data){
            $content .= "'".(mb_strtolower($data->url))."' => 'content/".(mb_strtolower($data->controller_name))."/index', ";
        }
        $content = substr($content, 0, -2);
        $content .=");";

        $pagesURL = (dirname(Yii::app()->basePath)).'/app/config/pages.php';

        $fp = fopen($pagesURL, "w");
        fwrite( $fp, $content);
        fclose($fp);

        if (file_exists($patch)) { return true; }
        else { return true; }

    }

    /*
     *  Создание модулей
     */

    public function module(){

        if($this->typeContent == 0 || empty($this->typeContent)) exit;

        $modelModule = SiteModule::model()->findByPk($this->typeContent);
        if (!$modelModule){ exit; }

        $template = mb_strtolower($modelModule->templates);

        $urlFront =  (dirname(Yii::app()->basePath))."/app/apps/frontend/modules/".$template;
        $urlTemplateFront = __DIR__ ."/ContentService/templates/".$template.'/frontend';

        $urlBackend =  (dirname(Yii::app()->basePath))."/app/apps/backend/modules/".$template;
        $urlTemplateBackend = __DIR__ ."/ContentService/templates/".$template.'/backend';

        /* Фронт */
        //Создание модуля
        if (!file_exists($urlFront)) { mkdir($urlFront); }
        $module = file_get_contents($urlTemplateFront.'/'.(ucfirst($template)).'Module.php');
        $fp = fopen($urlFront.'/'.(ucfirst($template)).'Module.php', "w");
        fwrite($fp, $module);
        fclose($fp);

        //Создание контроллера
        if (!file_exists($urlFront.'/controllers')) mkdir($urlFront.'/controllers');
        $controller = file_get_contents($urlTemplateFront.'/controllers/controller.php');
        $controller = str_replace("[%layout%]", $this->layout, $controller);
        $fp = fopen($urlFront.'/controllers/'.(ucfirst($template)).'Controller.php', "w");
        fwrite($fp, $controller);
        fclose($fp);

        //Создание вьюшек
        $urlFront .=  '/views';
        if (!file_exists($urlFront)) mkdir($urlFront);
        $urlFront .=  '/'.$template;
        if (!file_exists($urlFront)) mkdir($urlFront);

        $dir = opendir($urlTemplateFront.'/views');
        while($contentViews = readdir($dir)) {
            if ( $contentViews != '.' && $contentViews != '..' ) {
                $view = file_get_contents($urlTemplateFront.'/views'.'/'.$contentViews);
                $fp = fopen($urlFront.'/'.$contentViews, "w");
                fwrite($fp, $view);
                fclose($fp);
            }
        }


        /* Бэкенд */
        //Создание модуля
        if (!file_exists($urlBackend)) mkdir($urlBackend);
        $module = file_get_contents($urlTemplateBackend.'/'.(ucfirst($template)).'Module.php');
        $fp = fopen($urlBackend.'/'.(ucfirst($template)).'Module.php', "w");
        fwrite($fp, $module);
        fclose($fp);

        //Создание контроллера
        if (!file_exists($urlBackend.'/controllers')) mkdir($urlBackend.'/controllers');
        $controller = file_get_contents($urlTemplateBackend.'/controllers/controller.php');
        $controller = str_replace("[%layout%]", $this->layout, $controller);
        $fp = fopen($urlBackend.'/controllers/'.(ucfirst($template)).'Controller.php', "w");
        fwrite($fp, $controller);
        fclose($fp);

        //Создание вьюшек
        $urlBackend .=  '/views';
        if (!file_exists($urlBackend)) mkdir($urlBackend);
        $urlBackend .=  '/'.$template;
        if (!file_exists($urlBackend)) mkdir($urlBackend);

        $dir = opendir($urlTemplateBackend.'/views');
        while($contentViews = readdir($dir)) {
            if ( $contentViews != '.' && $contentViews != '..' ) {
                $view = file_get_contents($urlTemplateBackend.'/views'.'/'.$contentViews);
                $fp = fopen($urlBackend.'/'.$contentViews, "w");
                fwrite($fp, $view);
                fclose($fp);
            }
        }


    }

    /*
    //Новости
    public function  news(){

        if($this->typeContent != 2) exit;

        $urlFront =  (dirname(Yii::app()->basePath))."/app/apps/frontend/modules/news";
        $urlTemplate = __DIR__ ."/ContentService/templates/news";

        //Создание модуля
        if (!file_exists($urlFront)) mkdir($urlFront);
        $module = file_get_contents($urlTemplate.'/NewsModule.php');
        $fp = fopen($urlFront.'/NewsModule.php', "w");
        fwrite($fp, $module);
        fclose($fp);

        //Создание контроллера
        if (!file_exists($urlFront.'/controllers')) mkdir($urlFront.'/controllers');
        $controller = file_get_contents($urlTemplate.'/controller.php');
        $fp = fopen($urlFront.'/controllers/NewsController.php', "w");
        fwrite($fp, $controller);
        fclose($fp);

        //Создание вьюшек
        $urlFront .=  '/views';
        if (!file_exists($urlFront)) mkdir($urlFront);
        $urlFront .=  '/news';
        if (!file_exists($urlFront)) mkdir($urlFront);
        foreach ( array('index.php','view.php') as $key=>$val ){

            $view = file_get_contents($urlTemplate.'/'.$val);
            $fp = fopen($urlFront.'/'.$val, "w");
            fwrite($fp, $view);
            fclose($fp);

        }

    }
    */



}

