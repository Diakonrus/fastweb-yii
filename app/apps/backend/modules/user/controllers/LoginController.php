<?php

class LoginController extends Controller {

    public $defaultAction = 'login';

	public function actionLogin() {

		$model = new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];

			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
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

    public function actionRecover($key=null)
    {
        $modelRecovery = new RecoveryForm();
        if (empty($key)){
            $email = Yii::app()->request->getPost('email');
            $model = User::model()->find('email LIKE ("'.$email.'")');
            if ($model){
                //Генерация ключа для восстановления пароля
                $key = $this->genpass();
                $subject = "Восстановление пароля на сайте ".SITE_NAME_FULL;
                $body = "На сайте ".SITE_NAME_FULL." был произведен запрос на восстановление пароля.</br>
                Для восстановления пароля <a href='".SITE_NAME_FULL."/admin/user/login/recover?key=".$key."'>перейдите по ссылке</a></br>
                Если это были не Вы, то проигнорируйте это сообщение.";
                $this->sendEmail($email, $subject, $body);
                //Yii::app()->mailer->send(array('email'=>$email, 'subject'=>$subject, 'body'=>$body));

                $sql = "UPDATE {{user}} SET  `recovery_password_at` = NOW(), `recovery_code` = '".$key."' WHERE  `id`=".$model->id.";";
                Yii::app()->db->createCommand($sql)->query();

                echo 'На указаный электронный адрес отправлено письмо с инструкцией по восстановлению пароля';
            }
            else { echo 'Пользователь с таким электронным адресом не найден!'; }

            Yii::app()->end();
        }
        else{
            //Перешли по ссылке  с ключем
            $model = User::model()->find('recovery_code ="'.$key.'"');
            if (!$model){ echo 'Не верный ключ!'; die(); }

            $this->render('restore',array('model'=>$modelRecovery));

        }

        if(isset($_POST['RecoveryForm'])){

            $modelRecovery->attributes=$_POST['RecoveryForm'];
            if( $modelRecovery->validate() ){
                $sql = "UPDATE {{user}} SET  `password` = '".(md5($modelRecovery->password))."', `recovery_password_at` = NULL, `recovery_code` = NULL WHERE  `id`=".$model->id.";";
                Yii::app()->db->createCommand($sql)->query();
                $this->redirect("/");
            }
            else { print_r($modelRecovery->hasErrors()); }

        }




    }
}