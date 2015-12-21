<?php

/**
 * This is the model class for table "{{user_data}}".
 *
 * The followings are the available columns in table '{{user_data}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $country_id
 * @property string $series
 * @property string $number
 * @property integer $type_passport
 * @property string $issued_date
 * @property string $issued_where
 * @property string $registered
 * @property string $mailing_address
 * @property string $place_of_birth
 * @property integer $inn
 * @property string $phone_sms
 * @property string $url_passport
 *
 * The followings are the available model relations:
 * @property Country $country
 * @property User $user
 */
class UserData extends CActiveRecord
{
        /** necessary for user multiple filter */
	//public $user_ids;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_data}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, country_id', 'required'),
			array('user_id, country_id, type_passport, inn', 'numerical', 'integerOnly'=>true),
			array('series', 'length', 'max'=>4),
			array('number', 'length', 'max'=>6),
			array('issued_where, registered, mailing_address, place_of_birth', 'length', 'max'=>150),
			array('phone_sms', 'length', 'max'=>15),
			array('url_passport', 'length', 'max'=>250),
			array('issued_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, country_id, series, number, type_passport, issued_date, issued_where, registered, mailing_address, place_of_birth, inn, phone_sms, url_passport,
                   /*user_ids*/', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'Пользователь',
			'country_id' => 'Гражданство',
			'series' => 'Серия',
			'number' => 'Номер',
			'type_passport' => 'тип резидент',
			'issued_date' => 'Выдан',
			'issued_where' => 'Выдан где',
			'registered' => 'Прописан/а',
			'mailing_address' => 'Почтовый адрес',
			'place_of_birth' => 'Место рождения',
			'inn' => 'ИНН',
			'phone_sms' => 'телефон для SMS',
			'url_passport' => 'путь к фото паспорта',
			'user_ids' => 'Пользователи',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		// для выборки по единственному пользователю
		$criteria->compare('t.user_id',$this->user_id,true);
		// для фильтрации по множеству пользователей
		//if (!empty($this->user_ids))  $criteria->addInCondition('t.user_id', explode(',', $this->user_ids));
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('series',$this->series,true);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('type_passport',$this->type_passport);
		$criteria->compare('issued_date',$this->issued_date,true);
		$criteria->compare('issued_where',$this->issued_where,true);
		$criteria->compare('registered',$this->registered,true);
		$criteria->compare('mailing_address',$this->mailing_address,true);
		$criteria->compare('place_of_birth',$this->place_of_birth,true);
		$criteria->compare('inn',$this->inn);
		$criteria->compare('phone_sms',$this->phone_sms,true);
		$criteria->compare('url_passport',$this->url_passport,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    private $rez_type_data = array(
        1 => "Резидент",
        2 => "Не резидент"
    );
    public function getReztype($id=null){
        $name = array();
        foreach($this->rez_type_data as $key => $val){
            $name[$key] = $val;
        }
        return $name;
    }

}
