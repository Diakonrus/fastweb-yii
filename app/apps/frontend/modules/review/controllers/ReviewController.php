<?php

class ReviewController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        //Проверяю что модуль не отключен
        if (SiteModuleSettings::model()->find('site_module_id = 16 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
    }

    public function actionIndex()
    {
        //Общий список отзывов
        $root = ReviewRubrics::getRoot(new ReviewRubrics);
        $model = $root->descendants(1)->findAll($root->id);

        $this->setSEO(Yii::app()->request->requestUri, 'Отзывы');

        $this->render('index', array('model'=>$model));
    }

    public  function actionElement($param){

        //Если прищли данные с формы
        if (isset($_POST['AddReview'])){
            if ( !empty($_POST['AddReview']['name']) && !empty($_POST['AddReview']['email']) && !empty($_POST['AddReview']['rubrics']) && !empty($_POST['AddReview']['review']) ){
                preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $_POST['AddReview']['email'], $match);
                if (!empty($match)){
                    $model = ReviewAuthor::model()->find('email LIKE "'.$_POST['AddReview']['email'].'"');
                    if (!$model){
                        $model = new ReviewAuthor();
                    }
                    $model->name = $_POST['AddReview']['name'];
                    $model->email = $_POST['AddReview']['email'];
                    if ($model->save()){
                        $modelElement = new ReviewElements();
                        $modelElement->parent_id = (int)$_POST['AddReview']['rubrics'];
                        $modelElement->author_id = $model->id;
                        $modelElement->review = '<p>'.$_POST['AddReview']['review'].'</p>';
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
            $model = ReviewElements::model()->findByPk((int)$paramArr);

            $this->setSEO(Yii::app()->request->requestUri, 'Отзывы', $model);

            //Смотрим, нужно ли вставить фотогалерею
            $render = '_form';
        }
        else {
            //Список отзывов категории
            $modelGroup =  ReviewRubrics::model()->find('url LIKE "'.$paramArr.'"');

            $this->setSEO(Yii::app()->request->requestUri, 'Отзывы', $modelGroup);

            $model = array();
            $model['group'] = $modelGroup;
            $model['element'] = ReviewElements::model()->findAll(array(
                "condition" => "status!=0 AND parent_id = ".$modelGroup->id,
                "order" => "id DESC",
            ));

            //Список категорий - вывод справа
            $model['category'] = array();
            $model['sub_category'] = array();
            $root = ReviewRubrics::getRoot(new ReviewRubrics);
            $model['select'] = $root->descendants()->findAll($root->id);
            $model['category'] = $root->descendants(1)->findAll($root->id);
            foreach ($model['category'] as $data){
                $category = ReviewRubrics::model()->findByPk($data->id);
                $model['sub_category'][$data->id] = $category->descendants()->findAll($root->id);
            }

            $render = 'view';
        }


        if (empty($model)){throw new CHttpException(404,'The page can not be found.');}
        $this->render($render, array('model'=>$model));
    }




}