<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserUserIdentity extends CUserIdentity {

    const ERROR_USER_BLOCKED = 3;
    const ERROR_USER_IS_NEW = 4;

    public $errorCode = null;
    public $model = null;

	private $_id;

	public function authenticate($checkPass = true)
	{
        $this->model = User::model()->find('LOWER(username)=? OR LOWER(email)=?', array(strtolower($this->username), strtolower($this->username)));
        $hash = md5($this->password);

        $this->errorCode = self::ERROR_NONE;

        if ( isset($this->model) && $this->model['state'] == User::STATE_NEW ) {
            $this->errorCode = self::ERROR_USER_IS_NEW;
        }

        if ( isset($this->model) && $this->model['state'] == User::STATE_BLOCKED ) {
            $this->errorCode = self::ERROR_USER_BLOCKED;
        }

		if ( !isset($this->model) ){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        else if( $checkPass && $hash != $this->model->password ){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }

        // Auth ok
        if( $this->errorCode == self::ERROR_NONE ){
            $this->_id = $this->model->id;
            $this->username = $this->model->first_name;
        }

        return $this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}

}