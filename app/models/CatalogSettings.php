<?php

/**
 * This is the model class for table "{{catalog_settings}}".
 *
 * The followings are the available columns in table '{{catalog_settings}}':
 * @property integer $id
 * @property string $img_small
 * @property string $img_medium
 * @property string $img_large
 * @property integer $watermark_pos
 * @property string $created_at
 */
class CatalogSettings extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    public $image_watermark;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_settings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('created_at', 'required'),
			array('watermark_pos', 'numerical', 'integerOnly'=>true),
            array('img_small, img_medium, img_large', 'numerical', 'integerOnly'=>true),
            array('img_small, img_medium, img_large', 'numerical', 'min'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.

            array('image_watermark', 'file', 'types'=>'png', 'allowEmpty' => true),


			array('id, img_small, img_medium, img_large, watermark_pos, created_at, created_at_start, created_at_end,
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
			'img_small' => 'Размер превью картинки',
			'img_medium' => 'Размер картинки (префикс medium)',
			'img_large' => 'Размер картинки (префикс large)',
			'watermark_pos' => 'Watermark Pos',
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
		$criteria->compare('img_small',$this->img_small,true);
		$criteria->compare('img_medium',$this->img_medium,true);
		$criteria->compare('img_large',$this->img_large,true);
		$criteria->compare('watermark_pos',$this->watermark_pos);
		$this->compareDate($criteria, 'created_at');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CatalogSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getWatermarkPos(){
        $arr = array(
            1 => 'Изображение замостить',
            2 => 'Изображение в нижнем левом углу',
            3 => 'Изображение внизу по центру',
            4 => 'Изображение в центре',
            5 => 'Изображение в левом верхнем углу',
            6 => 'Изображение в нижнем правом углу',
        );
        $result = array();
        foreach ($arr as $key=>$val){
            $result[$key] = $val;
        }
        return $result;
    }
}
