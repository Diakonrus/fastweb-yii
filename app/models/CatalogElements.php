<?php

/**
 * This is the model class for table "{{warehouse_elements}}".
 *
 * The followings are the available columns in table '{{warehouse_elements}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $order_id
 * @property string $name
 * @property string $brieftext
 * @property integer $status
 * @property integer $ansvtype
 * @property integer $execute
 * @property integer $hit
 * @property string $image
 * @property string $page_name
 * @property string $description
 * @property string $fkey
 * @property string $code
 * @property double $price
 * @property double $price_entering
 */
class CatalogElements extends CActiveRecord
{

    public $serch_name_code;
    public $imagefile;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_elements}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, name', 'required'),
			array('parent_id, order_id, status, ansvtype, execute, hit, qty', 'numerical', 'integerOnly'=>true),
			array('price, price_entering', 'numerical'),
			array('name, page_name, fkey', 'length', 'max'=>250),
			array('image', 'length', 'max'=>5),
			array('code', 'length', 'max'=>100),

            array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, order_id, name, brieftext, status, ansvtype, qty, execute, hit, image, page_name, description, fkey, code, serch_name_code, price, price_entering,
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
			'parent_id' => 'Parent',
			'order_id' => 'Order',
			'name' => 'Name',
			'brieftext' => 'Brieftext',
			'status' => 'Status',
			'ansvtype' => 'Ansvtype',
			'execute' => 'Execute',
			'hit' => 'Hit',
			'image' => 'Image',
			'page_name' => 'Page Name',
			'description' => 'Description',
			'fkey' => 'Fkey',
			'code' => 'Code',
			'price' => 'Price',
			'price_entering' => 'Price Entering',
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('brieftext',$this->brieftext,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('ansvtype',$this->ansvtype);
		$criteria->compare('execute',$this->execute);
		$criteria->compare('hit',$this->hit);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('page_name',$this->page_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('fkey',$this->fkey,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('price',$this->price);
        $criteria->compare('qty',$this->qty);
		$criteria->compare('price_entering',$this->price_entering);

        return $criteria;

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WarehouseElements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getProduct($id){
        $modelElements = CatalogElements::model()->findByPk($id);
        $result = array();
        if ($modelElements){
            //Получаем ссылку на товар
            $modelRubrics = CatalogRubrics::model()->findByPk($modelElements->parent_id);
            if ($modelRubrics){
                $i = $modelRubrics->id;
                $array = array();
                do {

                    $model = CatalogRubrics::model()->findByPk((int)$i);
                    if(isset($model->id))$array[] = $model->id;
                    $i = (int)$model->parent_id;

                } while ($i != 0);

                $array = array_reverse($array);
                unset($array[0]);
                $base_patch = "";
                foreach ($array as $value){
                    $base_patch .= '/'.(CatalogRubrics::model()->findByPk((int)$value)->url);
                }
                $result['url'] = $base_patch;
            }
            //Данные о товаре
            $result['product'] = $modelElements;
        }
        return $result;
    }
}
