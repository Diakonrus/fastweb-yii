<?php

/**
 * This is the model class for table "{{geo_item}}".
 *
 * The followings are the available columns in table '{{geo_item}}':
 * @property integer $id
 * @property string $name
 * @property integer $type_id
 * @property integer $level_1
 * @property integer $level_2
 * @property integer $level_3
 * @property integer $level_4
 * @property integer $level_5
 * @property integer $level_index
 */
class GeoItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GeoItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{geo_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type_id, level_index', 'required'),
			array('type_id, level_index', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, type_id, level_1, level_2, level_3, level_4, level_5, level_index', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'type_id' => 'Type',
			'level_1' => 'Level 1',
			'level_2' => 'Level 2',
			'level_3' => 'Level 3',
			'level_4' => 'Level 4',
			'level_5' => 'Level 5',
			'level_index' => 'Level Index',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('level_1',$this->level_1);
		$criteria->compare('level_2',$this->level_2);
		$criteria->compare('level_3',$this->level_3);
		$criteria->compare('level_4',$this->level_4);
		$criteria->compare('level_5',$this->level_5);
		$criteria->compare('level_index',$this->level_index);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}