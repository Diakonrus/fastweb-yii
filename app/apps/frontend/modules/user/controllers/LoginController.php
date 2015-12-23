<?php

class LoginController extends Controller {


    public function actionIndex() {

        $user = Yii::app()->user;
        $model = $user->getModel();

        if( !$model ){
            $this->redirect('/login');
        }

        //$this->_profileForm($user);
    }


    /**
     * Форма авторизации
     */
    public function actionLogin() {

        $form = new LoginForm();

        // Ajax валидация
        if( Yii::app()->request->isAjaxRequest ){
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }

        // Post валидация и авторизация
        if(isset($_POST['LoginForm'])){

            $form->attributes=$_POST['LoginForm'];

            // validate user input and redirect to the previous page if valid
            if($form->validate() && $form->login()){

                //Если пользователь пришел из корзины (оформил товары и нажал авторизацию) - перенаправляю на оформление корзины
                $cookies = Yii::app()->request->cookies;
                if ( isset($cookies['basket_addres']) ){
                    $this->redirect('/basket');
                }
                $this->redirect('/');
            }
        }

        // display the login form
        $this->render('loginForm', array('model'=>$form));
    }


    /**
     * Выход из лк
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }


}
