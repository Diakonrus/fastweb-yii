<?php

/**
 * This is the model class for table "{{user_role}}".
 *
 * The followings are the available columns in table '{{user_role}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $access_level
 */
class UserRole extends CActiveRecord {
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_role}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, access_level', 'required'),
			array('name, description', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, access_level,
                   ', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Значение',
			'description' => 'Описание',
            'access_level' => 'Уровень доступа',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($param = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

        if (!empty($param)){
            $criteria->condition = $param;
        }

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
        $criteria->compare('access_level',$this->access_level,true);

        /*
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        */
        return $criteria;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserRole the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    private $lvl = array(
        0  => 'Страница доступна для всех',
        5  => 'Страница доступна для авторизованых пользователей',
        10 => 'Страница доступна для администраторов',
    );

    public function getLvlAccess(){
        $name = array();
        foreach($this->lvl as $key => $val){
            $name[$key] = $val;
        }
        return $name;
    }
    public function getDownlvlaccess($id){
        $lvlaccess = $this->getLvlAccess();
        return $lvlaccess[$id];
    }

    public function getChkManagerRole($user_id){
        $managerArr = array();
        foreach ( UserRole::model()->findAll('access_level=5') as $data_arr ){
            $managerArr[$data_arr->name] = 1;
        }

        $model = User::model()->findByPk((int)$user_id);
        if (isset($managerArr[$model->role_id])){
            return true;
        } else { return false; }
    }

    /**
     * Возращает роль пользователя по его, пользователя, ID
     * type - тип возращаемого значения. 1-вернет ID записи таблицы tbl_user_role, 2-вернет name записи таблицы tbl_user_role
     */
    public function returnUserRule($id, $type=1){
        if ( $model = User::model()->findByPk($id) ){
            if ( $modelRole = UserRole::model()->find('name LIKE "'.$model->role_id.'"') ){
                return (($type==1)?$modelRole->id:$modelRole->name);
            }
        }
        return false;
    }
}
