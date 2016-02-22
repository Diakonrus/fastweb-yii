<?php

class ReviewController extends Controller
{
	public $layout='//layouts/main';


    public function actionIndex($param = null)
    {

        if (isset($_POST['ReviewAuthor'])){ $this->addNewReview($_POST); }

        //Общий список отзывов
        $root = ReviewRubrics::getRoot(new ReviewRubrics);
        $model['groups'] = $root->descendants(1)->findAll($root->id);
        $this->setSEO(Yii::app()->request->requestUri, 'Отзывы');

        if (empty($param)){
            $model['elements'] = ReviewElements::model()->findAll('`status` = 1 ORDER BY review_data DESC');
         } else {
            //Число - это элемент
            if (is_numeric($param)){
                $model['elements'] = ReviewElements::model()->findAll('`status` = 1 AND id = '.(int)$param);
                if (empty($model['elements'])){throw new CHttpException(404,'The page can not be found.');}
            } else {
                //Ссылка - это раздел
                $model['elements'] = ReviewElements::model()->findAll('`status` = 1 AND parent_id in (SELECT id FROM {{review_rubrics}} WHERE url LIKE "'.(trim($param)).'")');
            }
        }


        $this->render('index', array('model'=>$model, 'param' => $param));
    }

    public  function actionElement($param){

        //Если параметр текст - это каталог, если число - элемент
        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);

        $this->actionIndex($paramArr);
        exit;
    }


    private function addNewReview($requests){
        //Если прищли данные с формы
        if (isset($requests)){
            if ( !empty($requests['ReviewAuthor']['name']) && !empty($requests['ReviewAuthor']['email']) && !empty($requests['ReviewElements']['parent_id']) && !empty($requests['ReviewElements']['review']) ){
                preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $requests['ReviewAuthor']['email'], $match);
                if (!empty($match)){
                    $model = ReviewAuthor::model()->find('email LIKE "'.$requests['ReviewAuthor']['email'].'"');
                    if (!$model){
                        $model = new ReviewAuthor();
                    }
                    $model->name = $requests['ReviewAuthor']['name'];
                    $model->email = $requests['ReviewAuthor']['email'];
                    if ($model->save()){
                        $modelElement = new ReviewElements();
                        $modelElement->parent_id = (int)$requests['ReviewElements']['parent_id'];
                        $modelElement->author_id = $model->id;
                        $modelElement->review = '<p>'.$requests['ReviewElements']['review'].'</p>';
                        $modelElement->status = 0;
                        $modelElement->save();
                    }
                }
            }
        }
        return true;
    }



}