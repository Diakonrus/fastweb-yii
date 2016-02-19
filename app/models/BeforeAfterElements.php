<?php

/**
 * This is the model class for table "{{before_after_elements}}".
 *
 * The followings are the available columns in table '{{before_after_elements}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $before_photo
 * @property string $after_photo
 * @property string $briftext
 * @property string $before_text
 * @property string $after_text
 * @property string $created_at
 */
class BeforeAfterElements extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    public $before_photo_file;
    public $after_photo_file;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{before_after_elements}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('before_photo, after_photo, parent_id', 'required'),
			array('parent_id,on_main, status', 'numerical', 'integerOnly'=>true),
			array('before_photo, after_photo', 'length', 'max'=>50),
			array('before_text, after_text, briftext', 'safe'),
            array('before_photo_file, after_photo_file,', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, on_main, before_photo, after_photo, briftext, before_text, after_text, status, created_at, created_at_start, created_at_end,
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
            'parent' => array(self::BELONGS_TO, 'BeforeAfterRubrics', 'parent_id'),
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
            'on_main' => 'Отображать как пару раздела в списке групп',
			'before_photo' => 'Картинка `ДО`',
			'after_photo' => 'Картинка `ПОСЛЕ`',
			'briftext' => 'Анонс',
            'status' => 'Статус',
			'before_text' => 'Текст 1 (над изображениями)',
			'after_text' => 'Текст 2 (под изображениями)',
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
        $criteria->compare('on_main',$this->on_main);
        $criteria->compare('status',$this->status);
		$criteria->compare('before_photo',$this->before_photo,true);
		$criteria->compare('after_photo',$this->after_photo,true);
		$criteria->compare('briftext',$this->briftext,true);
		$criteria->compare('before_text',$this->before_text,true);
		$criteria->compare('after_text',$this->after_text,true);
		$this->compareDate($criteria, 'created_at');

		$criteria_param = array(
			'criteria'=>$criteria,
		);
		if ($settingsModel = SiteModuleSettings::model()->find('site_module_id = 12')){
			$criteria_param['Pagination'] = array('PageSize'=>(((int)$settingsModel->elements_page_admin>0)?$settingsModel->elements_page_admin:10));
		}


		return new CActiveDataProvider($this, $criteria_param);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BeforeAfterElements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
