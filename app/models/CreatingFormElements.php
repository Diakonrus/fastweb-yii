<?php

/**
 * This is the model class for table "{{creating_form_elements}}".
 *
 * The followings are the available columns in table '{{creating_form_elements}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $order_id
 * @property integer $feeld_type
 * @property string $feeld_value
 * @property integer $feeld_require
 * @property string $feeld_template
 * @property integer $status
 * @property string $creating_at
 */
class CreatingFormElements extends CActiveRecord
{
    public $creating_at_start;
	public $creating_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{creating_form_elements}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, parent_id, feeld_type, feeld_require', 'required'),
			array('parent_id, order_id, feeld_type, feeld_require, status', 'numerical', 'integerOnly'=>true),
			array('feeld_value', 'length', 'max'=>350),
			array('name', 'length', 'max'=>250),
			array('feeld_template', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, name, order_id, feeld_type, feeld_value, feeld_require, feeld_template, status, creating_at, creating_at_start, creating_at_end,
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
			'parent' => array(self::BELONGS_TO, 'CreatingFormRubrics', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Форма',
			'name' => 'Название',
			'order_id' => 'Порядок',
			'feeld_type' => 'Тип поля',
			'feeld_value' => 'Значение',
			'feeld_require' => 'Заполнение поля на форме обязательно',
			'feeld_template' => 'Шаблон поля',
			'status' => 'Статус',
			'creating_at' => 'Creating At',
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('feeld_type',$this->feeld_type);
		$criteria->compare('feeld_value',$this->feeld_value,true);
		$criteria->compare('feeld_require',$this->feeld_require);
		$criteria->compare('feeld_template',$this->feeld_template,true);
		$criteria->compare('status',$this->status);
		$this->compareDate($criteria, 'creating_at');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CreatingFormElements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
