<?php

/**
 * This is the model class for table "{{sale}}".
 *
 * The followings are the available columns in table '{{sale}}':
 * @property integer $id
 * @property string $name
 * @property string $brieftext
 * @property string $description
 * @property integer $status
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $maindate
 * @property integer $keyword
 */
class Sale extends CActiveRecord
{

    public $imagefile;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description', 'required'),
			array('status, keyword, group_id', 'numerical', 'integerOnly'=>true),
			array('name, primary', 'length', 'max'=>250),
            array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			array('brieftext, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, primary, name, brieftext, description, status, group_id, maindate, keyword, image,
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
			'name' => 'Название',
            'group_id' => 'Группа',
			'brieftext' => 'Анонс (короткий текст)',
			'description' => 'Описание (полный текст)',
			'status' => 'Статус',
			'maindate' => 'Дата акции',
            'keyword' => 'Keyword',
			'primary' => 'Главные новости',
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
        $criteria->compare('group_id',$this->group_id,true);
		$criteria->compare('brieftext',$this->brieftext,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);
        $criteria->compare('image',$this->image,true);
		$criteria->compare('maindate',$this->maindate,true);
        $criteria->compare('keyword',$this->keyword);
		$criteria->compare('primary',$this->primary);


        $criteria_param = array(
            'criteria'=>$criteria,
        );
        if ($settingsModel = SiteModuleSettings::model()->find('site_module_id = 9')){
            $criteria_param['Pagination'] = array('PageSize'=>(((int)$settingsModel->elements_page_admin>0)?$settingsModel->elements_page_admin:10));
        }


        return new CActiveDataProvider($this, $criteria_param);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    private $statusArr = array(
        0=>'Отключено',
        1=>'Включено'
    );

    public function getStatuslist($id=null){
            $name = array();
            foreach($this->statusArr as $key => $val){
                $name[$key] = $val;
            }
            return $name;
    }

    public function getDownliststatus($id){
        $statuslist = $this->getStatuslist();
        return $statuslist[$id];
    }

    protected function beforeSave()
    {
        if (empty($this->maindate)){  $this->maindate = date('Y-m-d H:i:s'); }

        return true;
    }

    /**
     * @param bool $primary - выводить только те новости, у которых стоит признак "Главные новости"
     * @param int $count   -   количество новостей
     * @param int $sort   -  сортировка 1-по убыванию, 2-по возрастанию
     */
    public function getLastSales($primary = true, $count = 3, $sort = 1){
        $retrnData = null;

        $paramArray = array();
        if ( $primary == true ){ $paramArray[] = '`primary`="1"'; }

        $param = implode(" AND ", $paramArray);
        $param .= ' ORDER BY maindate '.(($sort == 1)?'DESC':'ASC');

        $i = 0;
        foreach ( Sale::model()->findAll($param) as $data ){
            $retrnData[] = $data;
            if ($i<(int)$count){break;}
            ++$i;
        }


        return $retrnData;
    }

    public function getDate($date){
        $month = array(
            '01'=>'Январь',
            '02'=>'Февраль',
            '03'=>'Март',
            '04'=>'Апрель',
            '05'=>'Май',
            '06'=>'Июнь',
            '07'=>'Июль',
            '08'=>'Август',
            '09'=>'Сентябрь',
            '10'=>'Октябрь',
            '11'=>'Ноябрь',
            '12'=>'Декабрь',
        );
        $date_day = date('d',strtotime($date));
        $date_month = date('m',strtotime($date)); $date_month = $month[$date_month];
        $date_year = date('Y',strtotime($date));
        $return_date = $date_day.' '.$date_month.' '.$date_year;
        return $return_date;
    }
}
