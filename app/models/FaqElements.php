<?php

/**
 * This is the model class for table "{{faq_elements}}".
 *
 * The followings are the available columns in table '{{faq_elements}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $author_id
 * @property string $question
 * @property string $answer
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property FaqRubrics $parent
 * @property FaqAuthor $author
 */
class FaqElements extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{faq_elements}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, author_id, question', 'required'),
			array('status, parent_id, author_id', 'numerical', 'integerOnly'=>true),
			array('answer', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, author_id, question, answer, status, created_at, created_at_start, created_at_end,
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
			'parent' => array(self::BELONGS_TO, 'FaqRubrics', 'parent_id'),
			'author' => array(self::BELONGS_TO, 'FaqAuthor', 'author_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Тема вопроса',
			'author_id' => 'Автор вопроса',
			'question' => 'Вопрос',
			'answer' => 'Ответ',
            'status' => 'Статус',
			'created_at' => 'Дата создания вопроса',
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
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('answer',$this->answer,true);
        $criteria->compare('status',$this->status);
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
	 * @return FaqElements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getCountElements($parent_id){
        return (int)FaqElements::model()->count("parent_id=:field AND `status`=1", array("field" => $parent_id));
    }
}
