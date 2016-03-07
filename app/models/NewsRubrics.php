<?php

/**
 * This is the model class for table "{{news_rubrics}}".
 *
 * The followings are the available columns in table '{{news_rubrics}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $left_key
 * @property integer $right_key
 * @property integer $level
 * @property string $url
 * @property string $image
 * @property string $name
 * @property string $title
 * @property string $brieftext
 * @property string $description
 * @property string $description_short
 * @property integer $status
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $created_at
 */
class NewsRubrics extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
	public $imagefile;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{news_rubrics}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, parent_id, url', 'required'),
			array('parent_id, left_key, right_key, level, status', 'numerical', 'integerOnly'=>true),
			array('url, title, meta_title', 'length', 'max'=>250),
			array('image', 'length', 'max'=>50),
			array('name', 'length', 'max'=>450),
			array('description, description_short, brieftext, meta_keywords, meta_description', 'safe'),
			array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, left_key, right_key, level, brieftext, url, image, name, title, description, description_short, status, meta_title, meta_keywords, meta_description, created_at, created_at_start, created_at_end,
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
			'newsElements' => array(self::HAS_MANY, 'NewsElements', 'parent_id'),
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
			'left_key' => 'Left Key',
			'right_key' => 'Right Key',
			'level' => 'Level',
			'url' => 'Url вдрес',
			'image' => 'Изображение',
			'name' => 'Название',
			'title' => 'Заголовок',
			'brieftext' => 'Анонс',
			'description' => 'Полное описание',
			'description_short' => 'Краткое описание',
			'status' => 'Статус',
			'meta_title' => 'Meta Title',
			'meta_keywords' => 'Meta Keywords',
			'meta_description' => 'Meta Description',
			'created_at' => 'Дата создания',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('left_key',$this->left_key);
		$criteria->compare('right_key',$this->right_key);
		$criteria->compare('level',$this->level);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('brieftext',$this->brieftext,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('description_short',$this->description_short,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('created_at',$this->created_at);

		if (!empty($param)){
			$criteria->condition = $param;
		}


		return $criteria;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NewsRubrics the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave() {
		$this->url = mb_strtolower($this->url);
		return true;
	}

	public function behaviors()
	{
		return array(
			'nestedSetBehavior'=>array(
				'class'=>'ext.nestedtrees.NestedSetBehavior',
				'leftAttribute'=>'left_key',
				'rightAttribute'=>'right_key',
				'levelAttribute'=>'level',
			),
		);
	}

	public static function getRoot(NewsRubrics $model){
		$root = $model->roots()->find();
		if (! $root){
			$model->name = 'Каталог News Дерево';
			$model->url = 'RootTreeNews';
			$model->parent_id = 0;
			$model->level = 1;
			$model->status = 1;
			$model->saveNode();
			$root = $model->roots()->find();
		}
		return $root;
	}

	/**
	 * Получить количество элементов в узле
	 */
	public static function getCountTree($left_key, $right_key){
		$model = Yii::app()->db->createCommand()
			->select('count(id) as count')
			->from(NewsRubrics::model()->tableName())
			->where('left_key>='.(int)$left_key.' AND right_key<='.(int)$right_key.'')
			->queryRow();
		$result = ((current($model))-1);   //вычитае из резуьтата сам узел
		return $result;
	}

	public static function getCountElement($parent_id){
		return NewsElements::model()->count("parent_id=:field", array("field" => $parent_id));
	}
}
