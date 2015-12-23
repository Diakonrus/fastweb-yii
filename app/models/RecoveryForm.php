<?php

class RecoveryForm extends CFormModel {

    public $email;
    public $password;
    public $password_repeat;
    public $key;

    public function rules() {

        $rules = array(
           // array('email', 'checkEmail'),
           // array('email', 'email', 'checkMX'=>true),
           // array('email', 'length', 'max'=>254),
            array('password_repeat, password', 'required', 'on' => 'register'),
            array('password_repeat', 'compare', 'compareAttribute'=>'password'),
            array('password', 'length', 'max' => 64),
        );

        return $rules;
    }

    /**
     * Проверяем сразу поля email
     */
    public function checkEmail($name, $data){

        if( strlen($this->email) == 0 ){
            $this->addError('email', 'Для восстановления доступа укажите email');
        }

    }

    public function attributeLabels() {
        return array(
            'email' => Yii::t('Models', 'USER.EMAIL'),
        );
    }

    public function validate($attributes = NULL, $clearErrors = true){

        $valid = parent::validate();

        if( $this->hasErrors() ){
            return false;
        }

        return true;
    }
}