<?php

class RegistrationForm extends CFormModel {

    // Profile data
    public $email;
    public $first_name;
    public $last_name;
    public $middle_name;

    public $birthday;
    public $birthday_day;
    public $birthday_month;
    public $birthday_year;

    public $sex;
    public $phone;

    // Password
    public $password;
    public $password_repeat;

    // Address
    public $city_id;
    public $mail_index;
    public $mail_street;
    public $mail_street_house;
    public $mail_street_corps;
    public $mail_street_apartment;

    // Misc data
    public $accept_process;
    public $captcha;

    public $organization;
    public $ur_addres;
    public $fiz_addres;
    public $inn;
    public $kpp;
    public $okpo;


	public function rules() {

		return array(

			array('email', 'required', 'message'=>'Не заполнено поле "{attribute}"'),
			array('email', 'email', 'checkMX'=>true, 'message'=>'"{attribute}" не является верным адресом электронной почты.'),

            array('first_name', 'match', 'pattern' => '/[А-Яа-я\-\s]+/', 'message'=>'Поле "{attribute}" должно содержать только русские буквы, пробел, знак тире.'),

            array('organization, ur_addres, fiz_addres', 'length', 'max' => 500),
            array('inn, kpp, okpo', 'length', 'max' => 100),

            array('password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>'Пожалуйста, повторите указанный пароль в "{attribute}" верно.'),
			//array('accept_process', 'compare', 'compareValue'=>true, 'message'=>'Вы не подтвердили согласие на обработку и хранение своих персональных данных и получения новостей от сайта'),

            //array('last_name, first_name, middle_name', 'length', 'max'=>128, 'message'=>'"{attribute}" заполнено неверно', 'tooLong'=>'значение не должно превышать {max} символов', 'tooShort'=>'значение не должно быть меньше {min} символов'),
            //array('last_name, first_name, middle_name', 'match', 'pattern'=>'/^[a-zа-я]{2,}$/ui', 'message'=>'Поле "{attribute}" заполнено неправильно'),

            //array('password', 'length', 'min'=> 6, 'max'=>64, 'message'=>'"{attribute}" заполнено неверно', 'tooLong'=>'Пароль должен быть не более {max} символов', 'tooShort'=>'Пароль должен быть не менее {min} символов'),
            //array('mail_street', 'length', 'max'=>64, 'message'=>'"{attribute}" заполнено неверно', 'tooLong'=>'Значение поля "{attribute}" не должно превышать {max} символов', 'tooShort'=>'Значение поля "{attribute}" не должно быть меньше {min} символов'),

            //array('mail_index', 'numerical', 'integerOnly'=>true, 'min'=>100, 'max'=>999999, 'allowEmpty'=>true, 'message'=>'"{attribute}" содержит значение, которое не является верным почтовым индексом', 'tooBig'=>'"{attribute}" не может быть больше "{max}"','tooSmall'=>'"{attribute}" не может быть меньше "{min}"'),
            //array('email', 'length', 'max'=>254, 'message'=>'"{attribute}" заполнено неверно', 'tooLong'=>'значение не должно превышать {max} символов', 'tooShort'=>'значение не должно быть меньше {min} символов'),
            //array('mail_street_house, mail_street_corps, mail_street_apartment', 'length', 'max'=>15),

			//array('password', 'length', 'max'=>64, 'message'=>'"{attribute}" заполнено неверно', 'tooLong'=>'значение не должно превышать {max} символов', 'tooShort'=>'значение не должно быть меньше {min} символов'),

            array('email', 'checkUnique', 'message' => 'Такой email уже существует в системе, воспользуйтесь <a class="open_recovery_popup" href="#">восстановлением пароля</a> или обратитесь в <a target="_blank" href="/feedback">службу поддержки</a>'),

            //array('phone', 'length', 'max'=>16),
            //array('phone', 'match', 'pattern' => '~^\+7[0-9]{10}$~', 'message' => 'Номер должен соответствовать формату "+7XXXXXXXXXX", например "+71234567890"'),
            //array('phone', 'checkExistsPhone', 'message' => 'Такой телефон уже существует в системе, воспользуйтесь <a class="open_recovery_popup" href="/profile/forgot">восcтановлением пароля</a> или обратитесь в <a href="/feedback">службу поддержки</a>'),

			//array('captcha', 'captcha', 'captchaAction'=>'captcha_registration'),
		);
	}

    /**
     * Проверяем возраст потребителя
     */
    public function checkAdult($field, $data) {

        if (!$this->getError($field)) {

            $birth = join('.', array( $this->birthday_day, $this->birthday_month, $this->birthday_year ));
            $interval = date_diff(date_create(), date_create($birth) );

            if ( $interval->format("%y") < 18 ) {
                $this->addError($field, $data['message']);
            }
        }
    }

    /**
     * Проверяем уникальность email пользователя
     */
    public function checkUnique($field, $data) {
        if (!$this->getError($field)) {

            $model = User::model()->find( $field . '=?', array($this->$field));

            if ( $model ) {
                $this->addError($field, $data['message']);
            }
        }
    }

    public function checkExistsPhone($name, $data) {
        if (!$this->hasErrors($name)) {

            $value = str_replace( array('(', ')', '-'), '', $this->$name );
            $model = User::model()->find( 'phone=:value', array(':value'=>$value));

            if (!empty($model)) {
                $this->addError($name, $data['message'] );
            }
        }
    }

    /**
     * Обработка полей birthday
     */
    public function setAttributes($values, $safeOnly = true){
        parent::setAttributes($values, $safeOnly);
        if( !$this->birthday_day && !$this->birthday_month && !$this->birthday_year ){
            $birthday = strtotime( $this->birthday );
            $this->birthday_day = date('j', $birthday);
            $this->birthday_month = date('n', $birthday);
            $this->birthday_year = date('Y', $birthday);
        }
    }

    /*
    public function beforeValidate(){
        return parent::beforeValidate();
    }
    */



    //

	public function attributeLabels()
	{
		return array(

			'email' => Yii::t('Models', 'USER.EMAIL'),
			'birthday' => Yii::t('Models', 'USER.BIRTHDAY'),
			'password' => Yii::t('Models', 'USER.PASSWORD'),
			'password_repeat' => Yii::t('Models', 'FULL_REGISTER_MODEL.PASSWORD_REPEAT'),

			'first_name' => Yii::t('Models', 'USER.FIRST_NAME'),
			'last_name' => Yii::t('Models', 'USER.LAST_NAME'),
			'middle_name' => Yii::t('Models', 'USER.MIDDLE_NAME'),

            'sex'=>Yii::t('Models', 'USER.SEX'),

            'city_id'=>Yii::t('Models', 'USER.CITY'),
            'country'=>Yii::t('Models', 'USER.COUNTRY'),

            'mail_index'=>Yii::t('Models', 'USER.MAIL_INDEX'),
            'mail_street'=>Yii::t('Models', 'USER.MAIL_STREET'),
            'mail_street_house'=>Yii::t('Models', 'USER.MAIL_STREET_HOUSE'),
            'mail_street_corps'=>Yii::t('Models', 'USER.MAIL_STREET_CORPS'),
            'mail_street_apartment'=>Yii::t('Models', 'USER.MAIL_STREET_APARTMENT'),

			'phone' => Yii::t('Models', 'USER.PHONE'),

            'accept_process' => 'Я подтверждаю регистрацию на сайте',
			'captcha' => Yii::t('Models', 'FULL_REGISTER_MODEL.CAPTCHA'),
		);
	}
}
