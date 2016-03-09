<?php

/**
 * This is the model class for table "{{catalog_elements_images}}".
 *
 * The followings are the available columns in table '{{catalog_elements_images}}':
 * @property integer $id
 * @property integer $elements_id
 * @property string $image_name
 * @property string $image
 * @property string $created_at
 */
class CatalogElementsImages extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_elements_images}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('elements_id, image_name, image', 'required'),
			array('elements_id', 'numerical', 'integerOnly'=>true),
			array('image_name', 'length', 'max'=>250),
			array('image', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, elements_id, image_name, image, created_at, created_at_start, created_at_end,
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
			'elements_id' => 'Elements',
			'image_name' => 'Image Name',
			'image' => 'Image Extension',
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
		$criteria->compare('elements_id',$this->elements_id);
		$criteria->compare('image_name',$this->image_name,true);
		$criteria->compare('image',$this->image,true);
		$this->compareDate($criteria, 'created_at');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CatalogElementsImages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * Получаем ссылку на изображение
	 *
	 * @param string $size
	 * @param bool|false $backend
	 * @param null $defaultPhoto
	 *
	 * @return null|string
	 */
	public function getImageLink($size = 'medium', $backend = false, $defaultPhoto = null) {
		$url_img = '/uploads/filestorage/catalog/elements/' . (!empty($size) ? $size . '-' : '') . $this->image_name . '.' . $this->image;
		if ($backend) {
			$url_img = '/..' . $url_img;
		}
		if (!file_exists( YiiBase::getPathOfAlias('webroot').$url_img)) {
			$url_img = !empty($defaultPhoto) ? $defaultPhoto : '/images/nophoto_100_100.jpg';
		}
		return $url_img;
	}
}
