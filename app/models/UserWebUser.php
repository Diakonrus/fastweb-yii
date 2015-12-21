<?php

class UserWebUser extends CWebUser {

    public $allowAutoLogin = false;

	private $states = array();
	private $_model = null;

	public function init(){
		parent::init();
	}

	public function getRole() {
		if($user = $this->getModel()){
            return $user->role_id;
        }
	}

	public function getModel() {
        if (!$this->isGuest && empty($this->_model)){
            $this->_model = User::model()->findByPk($this->id);
        }
        return $this->_model;
	}

    /**
     * Получить уровень доступа авторизованого пользователя
     */
    public function getAccess(){
        $lvl = 0;
        if (!$this->isGuest){
            $user = $this->getModel();
            $lvl = Yii::app()->db->createCommand()
                ->select('access_level')
                ->from('{{user_role}}')
                ->where('name="'.$user->role_id.'"')
                ->queryRow();
            $lvl = (int)$lvl['access_level'];
        }
        return $lvl;
    }
}