<?php

class RecoveryForm extends CFormModel {

    public $email;
    public $captcha;
    public $phone1;
    public $phone2;

    public function rules() {

        $rules = array(

            //array('captcha', 'captcha', 'captchaAction'=>'/crmuser/registration/captcha_recovery'),

            // валидация email
            //array('email', 'checkEmailPhone'),
            array('email', 'email', 'checkMX'=>true),
            array('email', 'length', 'max'=>254),

            array('email', 'safe'),

            //array('phone1, phone2', 'safe'),
            //array('email', 'checkExists', 'message' => 'Такой email в системе не найден', 'on' => 'checkEmail'),

            // валидация телефона
            //array('email', 'length', 'max' => 16, 'message' => '"{attribute}" заполнено неверно', 'tooLong' => 'значение не должно превышать {max} символов', 'tooShort' => 'значение не должно быть меньше {min} символов', 'on' => 'checkPhone'),
            //array('email', 'match', 'pattern' => '~^\+7\(\d\d\d\)\d\d\d\-\d\d\-\d\d$~', 'message' => 'Номер должен соответствовать формату "+7(XXX)ХХХ-ХХ-ХХ", например "+7(910)123-45-67"', 'on' => 'checkPhone'),
            //array('email', 'checkExistsPhone', 'message' => 'Такой номер в системе не найден', 'on' => 'checkPhone'),

            //array('recovery_time', 'checkTime', 'lockTime' => 6, 'message' => 'Вы только что восстановили пароль, он Вам уже отправлен.'),
        );

        return $rules;
    }

    /**
     * Проверяем сразу поля email и телефон
     */
    public function checkEmailPhone($name, $data){

        $phone = $this->phone1.$this->phone2;

        if( strlen($this->email) == 0 && strlen($phone) == 0 ){
            $this->addError('email', 'Для восстановления доступа укажите email или телефон');
            $this->addError('phone1', null);
        }

        if( empty($this->email) && !preg_match( '~[\d]{10}~', $phone) ){
            $this->addError('phone1', 'Не корректно заполенено поле телефон');
        }
    }

    public function attributeLabels() {
        return array(
            'email' => Yii::t('Models', 'USER.EMAIL'),
            'captcha' => Yii::t('Models', 'FULL_REGISTER_MODEL.CAPTCHA'),
        );
    }

    public function validate($attributes = NULL, $clearErrors = true){

        $valid = parent::validate();

        if (empty($this->email)){
            $this->addError('email', 'Email не может быть пустым.');
            return false;
        }

        if (!User::model()->find('email LIKE "'.$this->email.'"')){
            $this->addError('email', 'Пользователь с таким email не найден.');
            return false;
        }

        if( $this->hasErrors() ){
            return false;
        }

        return true;
    }
}