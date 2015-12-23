<?php

class ProfileController extends Controller {


    public $layout='//layouts/main';
    public $modelUser;

    public function init(){
        if (Yii::app()->user->isGuest){
            $this->redirect('/login');
        }
        $user = Yii::app()->user;
        $this->modelUser = $user->getModel();
    }


    public function actionIndex() {

        $model = BasketOrder::model()->findAll('user_id = '.$this->modelUser->id.' ORDER BY created_at DESC');

        $renderPartial = "order";

        $this->render('index', array(
            'modelUser' => $this->modelUser,
            'model' => $model,
            'renderPartial' => $renderPartial,
        ));
    }

    public function actionSettings() {

        if(isset($_POST['User']))
        {
            $model = $this->modelUser;
            $model->attributes=$_POST['User'];

            if($model->save()){

                $this->redirect( '/cabinet' );

            }
        }

        $renderPartial = "settings";

        $this->render('index', array(
            'modelUser' => $this->modelUser,
            'model' => $this->modelUser,
            'renderPartial' => $renderPartial,
        ));
    }

    public function actionProfile() {

        $model = $this->modelUser;

        if(isset($_POST['User']))
        {
            $model->password = '';
            $model->password_repeat = '';
            $model->attributes=$_POST['User'];
            if($model->save()){
                $this->redirect( '/cabinet' );
            }
        }

        $renderPartial = "profile";

        $this->render('index', array(
            'modelUser' => $this->modelUser,
            'model' => $model,
            'renderPartial' => $renderPartial,
        ));
    }

}
