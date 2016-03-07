<?php

class ContentService extends CApplicationComponent {

    public function save(){

        $arrayData = array();
        $modelURL = Pages::model()->findAll('status!=0');


        $content = "<?php return array( ";
        foreach ($modelURL as $data){

            if ($data->type_module == 8){
                //Если ссылка (модуль URL-ссылка) - пропускаем
                continue;
            }

            if ($data->main_page == 1){
                //Если главная страница
                $data->url = '/';
            }

            if ($data->type_module==0){
                //обычная текстовая страница
                $content .= "'".(mb_strtolower($data->url))."' => 'content/pages/index/id/".$data->id."', ";
            } else {
                //Модуль - проставляем УРЛ на модуль
                $modelModule = SiteModule::model()->findByPk((int)$data->type_module);
                if ($modelModule){

                    if ($data->type_module==0){
                        //Ссылка с ID записи в Page
                        $content .= "'".(mb_strtolower($data->url))."' => '".$modelModule->url_to_controller."/index/id/".$data->id."', ";
                    } else {
                        $content .= "'".(mb_strtolower($data->url))."' => '".$modelModule->url_to_controller."', ";
                    }

                    //Добавляем ссылки на элемент
                    $content .= "'".(mb_strtolower($data->url))."/<param:.+>' => '".$modelModule->url_to_controller."/element', ";
                }
            }
        }

        $content = substr($content, 0, -2);
        $content .=");";

        $pagesURL = (dirname(Yii::app()->basePath)).'/app/config/pages.php';

        $fp = fopen($pagesURL, "w");
        fwrite( $fp, $content);
        fclose($fp);

        return true;

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


}

