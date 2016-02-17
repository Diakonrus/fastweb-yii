<?php

/**
 * This is the model class for table "{{warehouse_rubrics}}".
 *
 * The followings are the available columns in table '{{warehouse_rubrics}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $left_key
 * @property integer $level
 * @property integer $right_key
 * @property string $name
 * @property string $url
 * @property integer $status
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $execute
 */
class CatalogFIlters extends CActiveRecord
{

    public $imagefile;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_filters}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,type,status,charsname', 'required'),
			array('type,status,position', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>199),
			
			//array('url', 'length', 'max'=>220),
			/*
            array('url','unique',
                'caseSensitive'=>true,
                'allowEmpty'=>false,
            ),

            array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, left_key, level, right_key, name, url, status, meta_title, meta_keywords, meta_description, fkey, execute,
                   ', 'safe', 'on'=>'search'),
     */
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
			'name' => 'Название фильтра',
			'type' => 'Тип фильтра',
			'status' => 'Статус фильтра',
			'charsname' => 'Характеристика',
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

		$criteria_param = array(
			'criteria'=>$criteria,
		);
		/*
		if ($settingsModel = SiteModuleSettings::model()->find('site_module_id = 4')){
			$criteria_param['Pagination'] = array('PageSize'=>(((int)$settingsModel->elements_page_admin>0)?$settingsModel->elements_page_admin:10));
		}
		*/

		return new CActiveDataProvider($this, $criteria_param);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WarehouseRubrics the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     *  Работа с деревом
     *
     */

    public function behaviors()
    {
    	return array();
    		/*
        return array(
            'nestedSetBehavior'=>array(
                'class'=>'ext.nestedtrees.NestedSetBehavior',
                'leftAttribute'=>'left_key',
                'rightAttribute'=>'right_key',
                'levelAttribute'=>'level',
            ),
        );
        */
    }
/*
    public static function getRoot(CatalogRubrics $model){
        $root = $model->roots()->find();
        if (! $root){
            $model->name = 'Каталог Корнеаое Дерево';
            $model->url = 'RootTreeStock';
            $model->level = 1;
            //$model->image = 'jpeg';
            $model->parent_id = 0;
            //$model->description = 'Категории';
            //$model->lastupdate = date('Y-m-d H:i:s');
            $model->status = 1;
            $model->meta_title = 'Склад Корнеаое Дерево';
            $model->meta_title = 'Склад Корнеаое Дерево';
            $model->meta_keywords = 'Склад Корнеаое Дерево';
            $model->meta_description = 'Склад Корнеаое Дерево';
            $model->saveNode();
            $root = $model->roots()->find();
        }
        return $root;
    }
*/



    /**
     * Получить количество элементов в узле
     */
    public static function getCountTree($left_key, $right_key){
        $model = Yii::app()->db->createCommand()
            ->select('count(id) as count')
            ->from('{{catalog_rubrics}}')
            ->where('left_key>='.(int)$left_key.' AND right_key<='.(int)$right_key.'')
            ->queryRow();
        $result = ((current($model))-1);   //вычитае из резуьтата сам узел
        return $result;
    }


}
