<?php

/**
 * This is the model class for table "{{email_messages}}".
 *
 * The followings are the available columns in table '{{email_messages}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $to_email
 * @property string $title
 * @property string $body
 * @property integer $status
 * @property string $send_date
 * @property string $created_at
 * @property integer $type_messages
 *
 * The followings are the available model relations:
 * @property User $user
 */
class EmailMessages extends CActiveRecord
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
		return '{{email_messages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, body, to_email', 'required'),
			array('user_id, status, template_id', 'numerical', 'integerOnly'=>true),
            array('to_email', 'email', 'checkMX'=>true),
			array('title', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, title, body, status, send_date, created_at, created_at_start, created_at_end, to_email, template_id', 'safe', 'on'=>'search'),
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
            'to_email' => 'E-mail получателя',
			'title' => 'Тема письма',
			'body' => 'Тело письма',
			'status' => 'Статус',
            'template_id' => 'Шаблон',
			'send_date' => 'Дата отправки',
			'created_at' => 'Дата создания',
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
		$criteria->compare('t.user_id',$this->user_id,true);
		$criteria->compare('title',$this->title,true);
        $criteria->compare('to_email',$this->to_email,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('send_date',$this->send_date,true);
		$this->compareDate($criteria, 'created_at');
        $criteria->compare('type_messages', $this->type_messages);
        $criteria->compare('template_id',$this->template_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmailMessages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    //user_id

    protected function beforeSave()
    {
        $this->user_id = Yii::app()->user->id;

        //Смотрим, определен ли шаблон, если определен - используем
        if (!empty($this->template_id) && $model_template = EmailTemplate::model()->findByPk($this->template_id)){
            $this->body = str_replace('%email_body%', $this->body, $model_template->body);
        }

        Yii::app()->mailer->send(array('email'=>$this->to_email, 'subject'=>$this->title, 'body'=>$this->body));

        $this->status = 1;
        $this->send_date = date('Y-m-d h:m:s');


        return true;
    }

    private $status_arr = array(
        0 => "Не отправлено",
        1 => "Отправленно"
    );
    public function getStatus($id=null){
        $name = array();
        foreach($this->status_arr as $key => $val){
            $name[$key] = $val;
        }
        return $name;
    }
    public function getDownliststatus($id){
        $statuslist = $this->getStatus();
        return $statuslist[$id];
    }


}
