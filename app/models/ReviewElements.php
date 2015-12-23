<?php

/**
 * This is the model class for table "{{review_elements}}".
 *
 * The followings are the available columns in table '{{review_elements}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $author_id
 * @property string $review
 * @property integer $status
 * @property string $review_data
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property ReviewRubrics $parent
 * @property ReviewAuthor $author
 */
class ReviewElements extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{review_elements}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, review', 'required'),
			array('parent_id, author_id, status', 'numerical', 'integerOnly'=>true),
			array('review_data, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, author_id, review, status, review_data, created_at, created_at_start, created_at_end,
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
			'parent' => array(self::BELONGS_TO, 'ReviewRubrics', 'parent_id'),
			'author' => array(self::BELONGS_TO, 'ReviewAuthor', 'author_id'),
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
			'author_id' => 'Автор',
			'review' => 'Отзыв',
			'status' => 'Статус',
			'review_data' => 'Дата создания отзыва',
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('review',$this->review,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('review_data',$this->review_data,true);
		$criteria->compare('created_at',$this->created_at);
		//$this->compareDate($criteria, 'created_at');

		/*
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
        */

		return $criteria;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReviewElements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	protected function beforeSave() {
		if (empty($this->review_data)){$this->review_data = date('Y-m-d H:i:s');}
		return true;
	}
	public function getCountElements($parent_id){
		return (int)ReviewElements::model()->count("parent_id=:field AND `status`=1", array("field" => $parent_id));
	}
}
