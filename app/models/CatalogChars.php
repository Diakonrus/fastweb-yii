<?php

/**
 * This is the model class for table "{{catalog_chars}}".
 *
 * The followings are the available columns in table '{{catalog_chars}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $order_id
 * @property string $name
 * @property string $scale
 * @property integer $type_scale
 * @property integer $type_parent
 * @property integer $status
 * @property string $created_at
 */
class CatalogChars extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_chars}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('parent_id, order_id, type_scale, type_parent, status, inherits, is_deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>250),
			array('scale', 'length', 'max'=>550),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, order_id, name, scale, type_scale, type_parent, status, inherits, created_at, is_deleted, created_at_start, created_at_end,
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
			'parent_id' => 'Каталог',
			'order_id' => 'Порядок',
			'name' => 'Название параметра',
			'scale' => 'Размерность',
			'type_scale' => 'Тип размерности',
			'type_parent' => '1-категория 2-товар',
			'status' => 'Статус',
            'inherits' => 'Наследование',
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
		$criteria->compare('scale',$this->scale,true);
		$criteria->compare('type_scale',$this->type_scale);
		$criteria->compare('type_parent',$this->type_parent);
		$criteria->compare('status',$this->status);
    $criteria->compare('inherits',$this->inherits);
    $criteria->compare('created_at',$this->created_at);
		$criteria->compare('is_deleted',$this->is_deleted);

        return $criteria;

        /*
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        */
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CatalogChars the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getTypeScale($id = null){
        $scaleArray = array(
            1 => 'Текстовое значение (например, вес)',
            2 => 'Групповой выбор (например, размеры)',
            3 => 'Цвета',
        );
        return (!empty($id))?($scaleArray[$id]):($scaleArray);
    }

    /**
     * @param $parent_id - id объекта (товар/категория) с которым работаем
     * @param $type_parent - тип объекта (1-каталог, 2-товар)
     * @param $model - модель содержащая данные для применения  (модель характеристик)
     * @param $status - статус присваеваемый создаваемым характеристикам
     */
    public function applyCategoryChars($parent_id, $type_parent, $model, $status = 0){
        if (!CatalogChars::model()->find('parent_id='.$parent_id.' AND name LIKE "'.$model->name.'" AND type_scale='.$model->type_scale.' AND type_parent='.$type_parent)){
            $tmp = new CatalogChars;
            $tmp->parent_id = $parent_id;
            $tmp->name = $model->name;
            $tmp->type_scale = $model->type_scale;
            $tmp->type_parent = $type_parent;
            $tmp->status = $status;
            $tmp->save();
        }
        return true;
    }

    /**
     * @param $model
     * @param $param
     * Добавляет наследование для категории
     */
    public function addInherits($model, $param){
        if ( $model->type_parent == 1 || $model->type_parent == 3 ){
            //Для категорий
            $modelcatalog = CatalogRubrics::model()->findByPk($model->parent_id);
            foreach ($modelcatalog->descendants()->findAll() as $data) {
                $model_chars = new CatalogChars;
                $model_chars->attributes = $param;
                $model_chars->parent_id = $data->id;
                $model_chars->type_parent = 1;
                $model_chars->save();
            }
        }
        return true;
    }

}
