<?php

/**
 * This is the model class for table "{{geo_region}}".
 *
 * The followings are the available columns in table '{{geo_region}}':
 * @property integer $id
 * @property integer $country_id
 * @property string $name_ru
 * @property string $name_en
 * @property integer $sort
 *
 * The followings are the available model relations:
 * @property GeoCity[] $geoCities
 * @property GeoCountry $country
 */
class GeoRegion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JGeoRegion the static model class
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
		return '{{geo_region}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id, name_ru, name_en', 'required'),
			array('country_id, sort', 'numerical', 'integerOnly'=>true),
			array('name_ru, name_en', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, country_id, name_ru, name_en, sort', 'safe', 'on'=>'search'),
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
			'settlements' => array(self::HAS_MANY, 'GeoCity', 'region_id'),
			'country' => array(self::BELONGS_TO, 'GeoCountry', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'country_id' => 'Страна',
			'name_ru' => 'Название',
			'name_en' => 'Название (En)',
			'sort' => 'Sort',
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
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('name_ru',$this->name_ru,true);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}