<?php

/**
 * This is the model class for table "{{doctor_specialization}}".
 *
 * The followings are the available columns in table '{{doctor_specialization}}':
 * @property integer $id
 * @property integer $doctor_rubrics_id
 * @property integer $doctor_elements_id
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property DoctorRubrics $doctorRubrics
 * @property DoctorElements $doctorElements
 */
class DoctorSpecialization extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{doctor_specialization}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('doctor_rubrics_id, doctor_elements_id', 'required'),
			array('doctor_rubrics_id, doctor_elements_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, doctor_rubrics_id, doctor_elements_id, created_at, created_at_start, created_at_end,
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
			'doctorRubrics' => array(self::BELONGS_TO, 'DoctorRubrics', 'doctor_rubrics_id'),
			'doctorElements' => array(self::BELONGS_TO, 'DoctorElements', 'doctor_elements_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'doctor_rubrics_id' => 'Специализация',
			'doctor_elements_id' => 'Doctor Elements',
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
		$criteria->compare('doctor_rubrics_id',$this->doctor_rubrics_id);
		$criteria->compare('doctor_elements_id',$this->doctor_elements_id);
		$this->compareDate($criteria, 'created_at');

		$criteria_param = array(
			'criteria'=>$criteria,
		);
		if ($settingsModel = SiteModuleSettings::model()->find('site_module_id = 10')){
			$criteria_param['Pagination'] = array('PageSize'=>(((int)$settingsModel->elements_page_admin>0)?$settingsModel->elements_page_admin:10));
		}


		return new CActiveDataProvider($this, $criteria_param);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DoctorSpecialization the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
