<?php

/**
 * This is the model class for table "{{basket_items}}".
 *
 * The followings are the available columns in table '{{basket_items}}':
 * @property integer $id
 * @property integer $basket_order_id
 * @property string $module
 * @property string $url
 * @property integer $item
 * @property string $comments
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property BasketOrder $basketOrder
 */
class BasketItems extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{basket_items}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('basket_order_id', 'required'),
			array('basket_order_id, item, quantity', 'numerical', 'integerOnly'=>true),
			array('module, url', 'length', 'max'=>350),
            array('price, trueprice', 'length', 'max'=>10),
			array('comments', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, basket_order_id, module, url, item, quantity, price, trueprice, comments, created_at, created_at_start, created_at_end,
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
			'basketOrder' => array(self::BELONGS_TO, 'BasketOrder', 'basket_order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'basket_order_id' => 'Basket Order',
			'module' => 'Module',
			'url' => 'Url',
			'item' => 'Товар',
            'price' => 'Цена на товар для покупателя(со скидками, если она есть)',
            'trueprice' => 'Цена на товар',
            'quantity' => 'количество',
			'comments' => 'Comments',
			'created_at' => 'Created At',
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
		$criteria->compare('basket_order_id',$this->basket_order_id);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('item',$this->item);
        $criteria->compare('price',$this->price,true);
        $criteria->compare('trueprice',$this->trueprice,true);
        $criteria->compare('quantity',$this->quantity);
		$criteria->compare('comments',$this->comments,true);
		$this->compareDate($criteria, 'created_at');

		$criteria_param = array(
			'criteria'=>$criteria,
		);
		if ($settingsModel = SiteModuleSettings::model()->find('site_module_id = 5')){
			$criteria_param['Pagination'] = array('PageSize'=>(((int)$settingsModel->elements_page_admin>0)?$settingsModel->elements_page_admin:10));
		}


		return new CActiveDataProvider($this, $criteria_param);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BasketItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Расчитывает цену товара УЖЕ со скидками, если они предоставлены
     * $element_id - ID товара
     * $count - количество товаров заказное пользователем (нужно для получения данных о скидках)
     */
    public function returnPrice($element_id, $count){
        $return_price = CatalogElements::model()->findByPk((int)$element_id)->price;
        $price = $return_price;
        //Расчитываем цену 1единицы товара  (с учетом скидок)
        foreach ( CatalogElementsDiscount::model()->findAll('element_id = '.(int)$element_id.' AND status = 1') as $data_discount ){
            $price = $price - ( CatalogElementsDiscount::model()->returnDiscount($return_price, $count, $data_discount)  );
        }
        $return_price = $price;

        return $return_price;
    }

}
