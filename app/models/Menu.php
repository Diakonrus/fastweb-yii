<?php

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property integer $id
 * @property string $name
 * @property integer $active
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Pages[] $pages
 */
class Menu extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    public $imagefile;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('active, name', 'required'),
			array('active, access_lvl, parent_id, type_form', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>250),
            array('image', 'length', 'max'=>350),
			array('created_at', 'safe'),
            array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, active, image, created_at, access_lvl, parent_id, type_form, created_at_start, created_at_end,
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
			'pages' => array(self::HAS_MANY, 'Pages', 'menu_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'active' => 'Статус',
            'image' => 'Изображение меню',
            'parent_id' => 'Родительское меню',
            'type_form' => 'Тип формы меню',
            'access_lvl' => 'Минимальный уровень прав для доступа к странице',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('active',$this->active);
        $criteria->compare('image',$this->image);
        $criteria->compare('access_lvl',$this->access_lvl);
        $criteria->compare('parent_id',$this->parent_id);
        $criteria->compare('type_form',$this->type_form);


		$this->compareDate($criteria, 'created_at');

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'Pagination'=> array(
                'PageSize'=>100,
            )
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getTypeFormMenu($id = null){
        $name = array(
            0 => 'Обычное оформление меню',
            1 => 'Оформление меню в виде круглых блоков'
        );
        return ((!empty($id)?$name[$id]:$name));
    }

}
