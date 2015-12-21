<?php

/**
 * This is the model class for table "{{doctor_elements}}".
 *
 * The followings are the available columns in table '{{doctor_elements}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $order_id
 * @property string $name
 * @property string $anonse
 * @property string $brieftext
 * @property string $description
 * @property string $image
 * @property integer $status
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property DoctorRubrics $parent
 */
class DoctorElements extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    public $imagefile;
    public $doctor_rubrics_id;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{doctor_elements}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, doctor_rubrics_id', 'required'),
			array('order_id, chief_doctor, status', 'numerical', 'integerOnly'=>true),
			array('name, meta_title', 'length', 'max'=>350),
			array('image', 'length', 'max'=>5),
            array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			array('description, doctor_rubrics_id,  anonse, anonse_dop, meta_keywords, meta_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, name, anonse, anonse_dop, description, doctor_rubrics_id, image, status, chief_doctor, meta_title, meta_keywords, meta_description, created_at, created_at_start, created_at_end,
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
			'order_id' => 'Порядок',
			'name' => 'ФИО',
			'anonse' => 'Анонс',
            'anonse_dop' => 'Дополнительный текст анонса (например, что доктор является членом ESCAD)',
			'description' => 'Описание',
			'image' => 'Фото',
            'chief_doctor' => 'Главный врач',
			'status' => 'Статус',
			'meta_title' => 'Meta Title',
			'meta_keywords' => 'Meta Keywords',
			'meta_description' => 'Meta Description',
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
		$criteria->compare('order_id',$this->order_id);
        $criteria->compare('doctor_rubrics_id',$this->doctor_rubrics_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('anonse',$this->anonse,true);
        $criteria->compare('anonse_dop',$this->anonse_dop,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
        $criteria->compare('chief_doctor',$this->chief_doctor);
		$criteria->compare('status',$this->status);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_description',$this->meta_description,true);
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
	 * @return DoctorElements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @param $model
     * Получить специализации. Если $model != null - проверяем выбрана ли была эта специализация ранее
     */
    public function getSpecialization($model = null){
        $return['data'] = array();
        $return['selected'] = array();
        foreach (DoctorRubrics::model()->findAll('status = 1') as $data){
            $return['data'][$data->id] = $data->name;
            if (!empty($model) && $dataSpec = DoctorSpecialization::model()->find('doctor_rubrics_id = '.$data->id.' AND doctor_elements_id = '.$model->id)){
                $return['selected'][$data->id] = array('selected' => 'selected');
            }
        }
        return  $return;
    }
}
