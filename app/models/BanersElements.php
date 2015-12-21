<?php

/**
 * This is the model class for table "{{baners_elements}}".
 *
 * The followings are the available columns in table '{{baners_elements}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $image
 * @property string $url
 * @property integer $status
 * @property string $created_at
 */
class BanersElements extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
	public $imagefile;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{baners_elements}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, image', 'required'),
			array('parent_id, status', 'numerical', 'integerOnly'=>true),
			array('name, url', 'length', 'max'=>450),
			array('image', 'length', 'max'=>50),

			array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, name, image, url, status, created_at, created_at_start, created_at_end,
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
			'parent' => array(self::BELONGS_TO, 'BanersRubrics', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Категория',
			'name' => 'Название',
			'imagefile' => 'Картинка',
			'image' => 'Изображение',
			'url' => 'Url адрес',
			'status' => 'Статус',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_at',$this->created_at);

		return $criteria;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BanersElements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
