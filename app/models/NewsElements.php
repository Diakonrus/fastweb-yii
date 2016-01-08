<?php

/**
 * This is the model class for table "{{news_elements}}".
 *
 * The followings are the available columns in table '{{news_elements}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $primary
 * @property string $name
 * @property string $brieftext
 * @property string $description
 * @property string $image
 * @property integer $status
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $maindate
 * @property integer $keyword
 */
class NewsElements extends CActiveRecord
{

	public $imagefile;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{news_elements}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('primary, name', 'required'),
			array('parent_id, status, keyword', 'numerical', 'integerOnly'=>true),
			array('primary', 'length', 'max'=>1),
			array('name, meta_title', 'length', 'max'=>250),
			array('image', 'length', 'max'=>50),
			array('brieftext, description, created_at, maindate, meta_keywords, meta_description', 'safe'),
			array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, primary, name, brieftext, description, image, status, maindate, keyword, created_at,
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
			'parent' => array(self::BELONGS_TO, 'NewsRubrics', 'parent_id'),
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
			'primary' => 'Главная статья',
			'name' => 'Название',
			'brieftext' => 'Анонс',
			'description' => 'Описание',
			'image' => 'Изображение',
			'status' => 'Статус',
			'maindate' => 'Дата статьи',
			'keyword' => 'Keyword',
			'created_at' => 'Created At',
			'meta_title' => 'Meta Title',
			'meta_keywords' => 'Meta Keywords',
			'meta_description' => 'Meta Description',
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('primary',$this->primary,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('brieftext',$this->brieftext,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('maindate',$this->maindate,true);
		$criteria->compare('keyword',$this->keyword);
		$criteria->compare('status',$this->status);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('created_at',$this->created_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NewsElements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	protected function beforeSave() {
		if (empty($this->maindate)){$this->maindate = date('Y-m-d');}
		return true;
	}
	public function getCountElements($parent_id){
		return (int)NewsElements::model()->count("parent_id=:field AND `status`=1", array("field" => $parent_id));
	}
}
