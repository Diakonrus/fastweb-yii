<?php

/**
 * This is the model class for table "{{geo_type}}".
 *
 * The followings are the available columns in table '{{geo_type}}':
 * @property string $id
 * @property string $name
 * @property integer $level_index
 * @property integer $code
 * @property string $shortname
 */
class GeoType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GeoType the static model class
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
		return '{{geo_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, level_index, shortname, code', 'required'),
			array('level_index', 'numerical', 'integerOnly'=>true),
			array('name, shortname', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, level_index, shortname', 'safe', 'on'=>'search'),
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
			'level_index' => 'Level Index',
			'shortname' => 'Shortname',
			'code' => 'Code',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('level_index',$this->level_index);
		$criteria->compare('code',$this->code);
		$criteria->compare('shortname',$this->shortname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}