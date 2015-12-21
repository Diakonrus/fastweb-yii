<?php

/**
 * This is the model class for table "{{basket_order}}".
 *
 * The followings are the available columns in table '{{basket_order}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 * @property string $phone
 * @property string $comments
 * @property integer $status
 * @property string $status_at
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property BasketItems[] $basketItems
 * @property User $user
 */
class BasketOrder extends CActiveRecord
{
    public $status_at_start;
	public $status_at_end;
public $created_at_start;
	public $created_at_end;
    /** necessary for user multiple filter */
	//public $user_ids;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{basket_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('created_at', 'required'),
			array('user_id, status', 'numerical', 'integerOnly'=>true),
			array('address', 'length', 'max'=>550),
			array('phone', 'length', 'max'=>100),
			array('comments, status_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, address, phone, comments, status, status_at, created_at, status_at_start, status_at_end, created_at_start, created_at_end,
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
			'basketItems' => array(self::HAS_MANY, 'BasketItems', 'basket_order_id'),
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
			'user_id' => 'Покупатель',
			'address' => 'Адрес доставки',
			'phone' => 'Телефон',
			'comments' => 'Коментарий',
			'status' => 'Статус',
			'status_at' => 'Дата изменения статуса',
			'created_at' => 'Дата заказа',
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
	public function search($param = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

        if (!empty($param)){
            $criteria->condition=$param;
        }

		$criteria->compare('id',$this->id);
		// для выборки по единственному пользователю
		$criteria->compare('t.user_id',$this->user_id,true);
		// для фильтрации по множеству пользователей
		//if (!empty($this->user_ids))  $criteria->addInCondition('t.user_id', explode(',', $this->user_ids));
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('status',$this->status);
        $criteria->compare('status_at',$this->status_at, true);
        $criteria->compare('created_at',$this->created_at, true);
        /*
		$this->compareDate($criteria, 'status_at');
		$this->compareDate($criteria, 'created_at');

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
	 * @return BasketOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getProductInOrder($id){

        $result = array();
        $i = 0;
        foreach (BasketItems::model()->findAll('basket_order_id='.(int)$id) as $data){
            $result[$i]['module'] = $data->module;
            $result[$i]['url'] = $data->url;
            $result[$i]['item'] = $data->item;
            $result[$i]['quantity'] = $data->quantity;
            $result[$i]['comments'] = $data->comments;
            ++$i;
        }
        return $result;
    }

    private $statusArr = array(
        0 => 'Поступление',
        1 => 'Регистрация',
        2 => 'Соединение с заказчиком',
        3 => 'Резервирование',
        4 => 'Доставка, оплата',
    );

    public function getStatus($id=null){
        $name = array();
        foreach($this->statusArr as $key => $val){
            $name[$key] = $val;
        }
        return $name;
    }

    public function getDownliststatus($id){
        $statuslist = $this->getStatus();
        return $statuslist[$id];
    }


}
