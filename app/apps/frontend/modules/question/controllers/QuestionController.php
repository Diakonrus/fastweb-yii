<?php

class QuestionController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        //Проверяю что модуль не отключен
        if (SiteModuleSettings::model()->find('site_module_id = 7 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
    }

    public function actionIndex()
    {
        //Общий список категорий вопросов
        $root = FaqRubrics::getRoot(new FaqRubrics);
        $model = $root->descendants(1)->findAll($root->id);

        $this->render('index', array('model'=>$model));
    }

    public  function actionElement($param){

        //Если прищли данные с формы
        if (isset($_POST['AddQuestion'])){
            if ( !empty($_POST['AddQuestion']['name']) && !empty($_POST['AddQuestion']['email']) && !empty($_POST['AddQuestion']['rubrics']) && !empty($_POST['AddQuestion']['question']) ){
                preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $_POST['AddQuestion']['email'], $match);
                if (!empty($match)){
                    $model = FaqAuthor::model()->find('email LIKE "'.$_POST['AddQuestion']['email'].'"');
                    if (!$model){
                        $model = new FaqAuthor();
                    }
                    $model->name = $_POST['AddQuestion']['name'];
                    $model->email = $_POST['AddQuestion']['email'];
                    if ($model->save()){
                        $modelElement = new FaqElements();
                        $modelElement->parent_id = (int)$_POST['AddQuestion']['rubrics'];
                        $modelElement->author_id = $model->id;
                        $modelElement->question = '<p>'.$_POST['AddQuestion']['question'].'</p>';
                        $modelElement->save();
                    }
                }
            }
        }

        //Если параметр текст - это каталог, если число - элемент
        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);

        if (is_numeric($paramArr)){
            //Число - это элемент
            $model = FaqElements::model()->findByPk((int)$paramArr);
            //Смотрим, нужно ли вставить фотогалерею
            $render = '_form';
        }
        else {
            //Список новостей категории
            $modelGroup =  FaqRubrics::model()->find('url LIKE "'.$paramArr.'"');
            $model = array();
            $model['group'] = $modelGroup;
            $model['element'] = FaqElements::model()->findAll(array(
                "condition" => "status!=0 AND parent_id = ".$modelGroup->id,
                "order" => "id DESC",
            ));

            //Список категорий - вывод справа
            $model['category'] = array();
            $model['sub_category'] = array();
            $root = FaqRubrics::getRoot(new FaqRubrics);
            $model['select'] = $root->descendants()->findAll($root->id);
            $model['category'] = $root->descendants(1)->findAll($root->id);
            foreach ($model['category'] as $data){
                $category = FaqRubrics::model()->findByPk($data->id);
                $model['sub_category'][$data->id] = $category->descendants()->findAll($root->id);
            }

            $render = 'view';
        }


        if (empty($model)){throw new CHttpException(404,'The page can not be found.');}
        $this->render($render, array('model'=>$model));
    }




}