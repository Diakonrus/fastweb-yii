<?php

/**
 * This is the model class for table "{{warehouse_rubrics}}".
 *
 * The followings are the available columns in table '{{warehouse_rubrics}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $left_key
 * @property integer $level
 * @property integer $right_key
 * @property string $name
 * @property string $url
 * @property integer $status
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $execute
 */
class CatalogFIltersInCategory extends CActiveRecord
{

    public $imagefile;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_filters_in_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_filter,id_catalog_rubrics', 'required'),
			array('id_filter,id_catalog_rubrics,position', 'numerical', 'integerOnly'=>true),

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
			'id_filter' => 'Фильтр',
			'id_catalog_rubrics' => 'Категория',
			'position' => 'Позиция',
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
		$criteria->compare('name',$this->name,true);

		$criteria_param = array(
			'criteria'=>$criteria,
		);

		return new CActiveDataProvider($this, $criteria_param);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WarehouseRubrics the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     *  Работа с деревом
     *
     */

    public function behaviors()
    {
    	return array();
    		/*
        return array(
            'nestedSetBehavior'=>array(
                'class'=>'ext.nestedtrees.NestedSetBehavior',
                'leftAttribute'=>'left_key',
                'rightAttribute'=>'right_key',
                'levelAttribute'=>'level',
            ),
        );
        */
    }



}
