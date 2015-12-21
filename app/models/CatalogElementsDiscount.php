<?php

/**
 * This is the model class for table "{{catalog_elements_discount}}".
 *
 * The followings are the available columns in table '{{catalog_elements_discount}}':
 * @property integer $id
 * @property integer $element_id
 * @property integer $count
 * @property string $values
 * @property integer $type
 * @property integer $user_role_id
 * @property string $created_at
 */
class CatalogElementsDiscount extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_elements_discount}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('element_id, type, values', 'required'),
			array('element_id, count, type, user_role_id, status', 'numerical', 'integerOnly'=>true),
            array('values', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, element_id, count, type, user_role_id, status, values, created_at, created_at_start, created_at_end,
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
			'element_id' => 'Товар',
			'count' => 'Количество',
            'values' => 'Значение',
			'type' => 'Тип',
			'user_role_id' => 'Группа',
            'status' => 'Статус',
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
		$criteria->compare('element_id',$this->element_id);
		$criteria->compare('count',$this->count);
		$criteria->compare('type',$this->type);
        $criteria->compare('values',$this->values,true);
		$criteria->compare('user_role_id',$this->user_role_id);
        $criteria->compare('status',$this->status);
		$this->compareDate($criteria, 'created_at');

		$criteria_param = array(
			'criteria'=>$criteria,
		);
		if ($settingsModel = SiteModuleSettings::model()->find('site_module_id = 4')){
			$criteria_param['Pagination'] = array('PageSize'=>(((int)$settingsModel->elements_page_admin>0)?$settingsModel->elements_page_admin:10));
		}


		return new CActiveDataProvider($this, $criteria_param);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CatalogElementsDiscount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    private $statusArr = array(
        0=>'Отключено',
        1=>'Включено'
    );

    public function getStatuslist($id=null){
        return ((!empty($id))?$this->statusArr[$id]:$this->statusArr);
    }

    public function getType($id = null){
        $name = array(
            1=>'Фиксированая',
            2=>'В процентах',
        );
        return ((!empty($id))?$name[$id]:$name);
    }

    public function getUserRole($id = null){
        $name = array(0=>'Все');
        foreach ( UserRole::model()->findAll() as $data ){
            $name[$data->id] = $data->description;
        }
        return ((!empty($id))?$name[$id]:$name);
    }

    /**
     * Возращает скидку на товар.
     * Входные параметры: $count - количество заказаного товара, $model - модель скидки (таблица tbl_catalog_elements_discount)
     * Выходные параметры - возращает размер скидки (ИЗ ЦЕНЫ СКИДКА НЕ ВЫЧИТАЕТСЯ)
     */
    public function returnDiscount($price, $count, $model){
        $discount = 0;

        //Проверяем права на получение скитки
        if ( ($model->user_role_id==0 || UserRole::model()->returnUserRule(Yii::app()->user->id)==$model->user_role_id) && $count>=$model->count   ){

            switch ($model->type) {
                case 1:
                    //Фиксированая
                    $discount = $model->values;
                    break;
                case 2:
                    //В процентах
                    $discount = $price * ($model->values/100);
                    break;
            }

        }

        return $discount;
    }


}
