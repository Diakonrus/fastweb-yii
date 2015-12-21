<?php

/**
 * This is the model class for table "{{feedback}}".
 *
 * The followings are the available columns in table '{{feedback}}':
 * @property integer $id
 * @property string $fio
 * @property string $phone
 * @property string $email
 * @property string $question
 * @property string $answer
 * @property integer $status
 * @property string $answer_at
 * @property string $created_at
 */
class Feedback extends CActiveRecord
{
    public $answer_at_start;
	public $answer_at_end;
public $created_at_start;
	public $created_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{feedback}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fio, phone, email, question', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('fio, email', 'length', 'max'=>550),
			array('phone', 'length', 'max'=>20),
			array('answer, answer_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fio, phone, email, question, answer, status, answer_at, created_at, answer_at_start, answer_at_end, created_at_start, created_at_end,
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
			'fio' => 'ФИО',
			'phone' => 'Телефон',
			'email' => 'E-mail',
			'question' => 'Вопрос',
			'answer' => 'Ответ',
			'status' => 'Статус',
			'answer_at' => 'Answer At',
			'created_at' => 'Дата подачи запроса',
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
		$criteria->compare('fio',$this->fio,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('status',$this->status);
		$this->compareDate($criteria, 'answer_at');
		$this->compareDate($criteria, 'created_at');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Feedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getStatus($id = null){
        $name = array(1=>'Новая', 2=>'Отвечено');
        return ((!empty($id))?$name[$id]:$name);

    }
}
