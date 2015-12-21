<?php

/**
 * This is the model class for table "{{sms_auto_delivery}}".
 *
 * The followings are the available columns in table '{{sms_auto_delivery}}':
 * @property integer $id
 * @property integer $contragent_id
 * @property integer $sms_template_id
 * @property integer $user_id
 * @property integer $type
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Contragent $contragent
 * @property SmsTemplate $smsTemplate
 * @property User $user
 */
class SmsAutoDelivery extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    /** necessary for user multiple filter */
	//public $user_ids;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sms_auto_delivery}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contragent_id, sms_template_id, user_id', 'required'),
			array('contragent_id, sms_template_id, user_id, type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, contragent_id, sms_template_id, user_id, type, created_at, created_at_start, created_at_end,
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
			'contragent' => array(self::BELONGS_TO, 'Contragent', 'contragent_id'),
			'smsTemplate' => array(self::BELONGS_TO, 'SmsTemplate', 'sms_template_id'),
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
			'contragent_id' => 'Contragent',
			'sms_template_id' => 'Sms Template',
			'user_id' => 'User',
			'type' => 'Тип СМС рассылки 2-новое письмо, 3-новый коментарий',
			'created_at' => 'Created At',
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
		$criteria->compare('contragent_id',$this->contragent_id);
		$criteria->compare('sms_template_id',$this->sms_template_id);
		// для выборки по единственному пользователю
		$criteria->compare('t.user_id',$this->user_id,true);
		// для фильтрации по множеству пользователей
		//if (!empty($this->user_ids))  $criteria->addInCondition('t.user_id', explode(',', $this->user_ids));
		$criteria->compare('type',$this->type);
		$this->compareDate($criteria, 'created_at');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SmsAutoDelivery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeValidate() {
        parent::beforeValidate();
        $this->user_id = Yii::app()->user->id;
        return true;
    }

}
