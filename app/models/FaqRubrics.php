<?php

/**
 * This is the model class for table "{{faq_rubrics}}".
 *
 * The followings are the available columns in table '{{faq_rubrics}}':
 * @property integer $id
 * @property integer $left_key
 * @property integer $level
 * @property integer $right_key
 * @property string $name
 * @property string $url
 * @property string $description
 * @property integer $status
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property FaqElements[] $faqElements
 */
class FaqRubrics extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{faq_rubrics}}';
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
			array('left_key, level, right_key, status, parent_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>350),
			array('url', 'length', 'max'=>250),
            array('url','unique', 'message'=>'Такой URL-адрес уже занят'),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, left_key, level, right_key, name, url, description, status, parent_id, created_at, created_at_start, created_at_end,
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
			'faqElements' => array(self::HAS_MANY, 'FaqElements', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'left_key' => 'Left Key',
			'level' => 'Level',
			'right_key' => 'Right Key',
			'name' => 'Название',
			'url' => 'Url вдрес',
            'parent_id' => 'Категория',
			'description' => 'Описание',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('left_key',$this->left_key);
		$criteria->compare('level',$this->level);
        $criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('right_key',$this->right_key);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);
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
	 * @return FaqRubrics the static model class
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

    public static function getRoot(FaqRubrics $model){
        $root = $model->roots()->find();
        if (! $root){
            $model->name = 'Каталог FAQ Дерево';
            $model->url = 'RootTreeStock';
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
            ->from(FaqRubrics::model()->tableName())
            ->where('left_key>='.(int)$left_key.' AND right_key<='.(int)$right_key.'')
            ->queryRow();
        $result = ((current($model))-1);   //вычитае из резуьтата сам узел
        return $result;
    }
}
