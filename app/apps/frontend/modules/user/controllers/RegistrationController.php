<?php

class RegistrationController extends Controller {

    /**
     * Страница регистрации
     */
    public function actionIndex() {

        $this->pageTitle = 'Личный кабинет Регистрация - «НЗСНАБ»';

        $form = new RegistrationForm();

        // Ajax валидация
        if( Yii::app()->request->isAjaxRequest ){
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }

        // Post валидация и авторизация
        if(isset($_POST['RegistrationForm'])){

            $attrs = $_POST['RegistrationForm'];

            // set attrs
            $form->attributes = $attrs;

            // validate user input and redirect to the previous page if valid

            $form->password = $this->genpass(10);  //генерируем пароль
            $form->password_repeat = $form->password;


            if($form->validate()){


                $model = new User('make');

                $model->attributes = $form->attributes;
                $model->role_id = 'user';
                $model->updateSecurity();

                if ($model->save()) {

                    //Отправляем письмо
                    $body = '
                    Здравствуйте, '.$model->email.'!<BR>
                    Благодарим Вас за регистрацию на нашем сайте.<BR>
                    Ваш новый пароль: <b>'.$form->password.'</b><BR>
                    <b>Всегда в наличии:</b><BR>
                    Запчасти к китайской спецтехнике - XCMG, TOTA, LINGONG, SDLG, XGMA, LIUGONG, LONKING, LONGGONG, CHENGGONG, YUTONG, Changlin, Mitsuber, Foton, Zoomlion, PowerCat, Sany<BR>
                    Запчасти к бульдозерам – SHANTUI, Shehwа.<BR>

                    Агрегаты и запчасти к ним:<BR>
                    Weichai (WD10G220E23, WD615G220, TD226B-6IG14, WD10G240E11,WD61567G3-29)<BR>
                    Cummins (6BT5.9-C130, 6BT5.9-C170, 6BT5.9-C175, 6BT5.9-C215, 6CTA8.3C215, 6CTA8.3C240)<BR>
                    Shanghai (SC11CB184G2B1, C6121 (CAT), C6121ZG50)<BR>
                    Yuchai (YC6B125-T11, YC6108G, YC6180)<BR>

                    Запчасти и ремонт коробок передач, мостов – ADVANCE, Kessler, Dana, ZF.<BR>
                    Расходные материалы (фильтра WIX , смазки TOTAL) для техники- Caterpillar, Komatsu, Terex, Volvo, Liebherr, Hitachi, John Deere, Sandvik, Hyundai<BR>
                    Автоаксессуары - аккумуляторы, шины 17.5-25; 23.5-25 диски.<BR>

                    <b>С уважением,</b><BR>
                    <b>ООО "НЗСнаб"</b><BR>

                    Тел.: +7(499) 213 -01-89<BR>
                    Моб.: +7(926) 160-76-35<BR>
                    Email: info@nzsnab.ru<BR>
                    Сайт: www.nzsnab.ru<BR>
                    ';
                    Yii::app()->mailer->send(array('email'=>$model->email, 'subject'=>'Регистрация на сайте nzsnab.ru', 'body'=>$body));

                    $this->redirect('/register/success');
                }
            }

            //print_r($model->getErrors());
        }

        $this->render( 'registrationForm', array('model'=>$form) );
    }

    /**
     * Успешная регистрация
     */
    public function actionSuccess(){
        $this->pageTitle = 'Личный кабинет Регистрация - «НЗСНАБ»';
        $this->render( 'registrationSuccess' );
    }

    /**
     * Форма восстановления пароля
     */
    public function actionRecovery(){

        $form = new RecoveryForm();

        if (isset($_POST['RecoveryForm'])) {

            $form->attributes = $_POST['RecoveryForm'];

            if ($form->validate()) {

                $model = User::model()->find('email=?', array($form->email));

                $model->recovery_code = $this->genpass(32);
                $model->update(array('recovery_code'));

                $this->sendResetLink($model);
                $this->render('recoverySend');
                return;
            }
        }

        $this->render('recoveryForm', array(
            'model' => $form
        ));
    }



    /**
     * Страница сброса пароля
     */
    public function actionResetPassword($key) {

        $model = User::model()->findByAttributes(
            array( 'recovery_code' => $key )
        );

        // активация устарела
        if( !$model ){
            $this->render('activationIncorrect');
            return;
        }

        $password = $this->genpass(6);


        $model->password = $password;
        $model->recovery_code = '';

        $model->update(array('password', 'recovery_code'));

        $this->sendNewPassword($model, $password);

        $this->render('recoverySuccess');
    }


    protected function sendRegistrationLink($model) {

        $mailBody = $this->renderPartial( 'registrationMailLink', array('model'=>$model), true );

        Yii::app()->mailer->send(
            array(
                'email'=>$model->email,
                'subject'=>'Регистрация на сайте ' . $_SERVER['HTTP_HOST'],
                'body' => $this->renderPartial( '//mail/body', array( 'body'=>$mailBody ), true )
            )
        );
    }

    /**
     * Письмо со ссылкой для сброса пароля
     */
    protected function sendResetLink($model) {

        $mailBody = $this->renderPartial('recoveryMailLink', array('model'=>$model), true);

        Yii::app()->mailer->send(array(
            'email'=>$model->email,
            'subject'=>'Восстановление пароля',
            'body'=>$this->renderPartial('//mail/body', array( 'body'=> $mailBody ), true),
        ));
    }

    /**
     * Письмо с новым паролем
     */
    protected function sendNewPassword($model, $password) {

        $mailBody = $this->renderPartial('recoveryMailPassword', array('model'=>$model, 'password'=>$password), true);

        Yii::app()->mailer->send(array(
            'email'=>$model->email,
            'subject'=>'Новый пароль',
            'body'=>$this->renderPartial('//mail/body', array( 'body'=> $mailBody ), true)
        ));
    }


    private function genpass ($number = 32){
        $arr = array('a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0');
        // Генерируем пароль
        $pass = "";
        for($i = 0; $i < $number; $i++)
        {
            // Вычисляем случайный индекс массива
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }

}
