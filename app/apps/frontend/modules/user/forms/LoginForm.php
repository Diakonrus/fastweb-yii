<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
    public $email;

	private $_identity;

	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('rememberMe', 'boolean'),
			array('password', 'authenticate'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'username'=> Yii::t('Models', 'Логин'),
			'password'=> Yii::t('Models', 'Пароль'),
			'rememberMe'=>Yii::t('Models', 'Запомнить'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if( !$this->hasErrors() )
		{
			$this->_identity = new UserUserIdentity($this->username,$this->password);

			$errorCode = $this->_identity->authenticate();

            if( $errorCode > 0 ){
                if( $errorCode == UserUserIdentity::ERROR_USER_BLOCKED ) {
                    $this->addError('password', 'Ваш аккаунт заблокирован' );
                }
                else if( $errorCode == UserUserIdentity::ERROR_USER_IS_NEW ){
                    $this->addError('password',
                        'Ваш аккаунт не активирован, для ' .
                        'активации перейдите по <a href="/registration/resend/email/' . $this->_identity->model->id . '">ссылке</a>' );
                } else {
                    $this->addError('password', Yii::t('Models', 'LOGIN_FORM.MESSAGE.INCORRECT_USERNAME_OR_PASSWORD') );
                }
            }
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null) {
			$this->_identity = new UserUserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}

		if($this->_identity->errorCode === UserUserIdentity::ERROR_NONE){
			$duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity, $duration);
			return true;
		}

		return false;
	}
}