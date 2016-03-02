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
 * @property string $title
 * @property string $description
 * @property string $description_short
 * @property string $url
 * @property integer $status
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $execute
 *
 * @method deleteNode
 * @method saveNode
 */
class CatalogRubrics extends CActiveRecord
{

    public $imagefile;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_rubrics}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, name, url', 'required'),
			array('parent_id, left_key, level, right_key, status, execute', 'numerical', 'integerOnly'=>true),
			array('name, title, meta_title, fkey', 'length', 'max'=>250),
			array('url', 'length', 'max'=>220),

            array('url','unique',
                'caseSensitive'=>true,
                'allowEmpty'=>false,
            ),
			array('description, description_short', 'safe'),
            array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, left_key, level, right_key, name, description, description_short, title, url, status, meta_title, meta_keywords, meta_description, fkey, execute,
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
				'parent' => array(self::BELONGS_TO, 'CatalogRubrics', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent',
			'left_key' => 'Left Key',
			'level' => 'Level',
			'right_key' => 'Right Key',
			'name' => 'Наименование',
			'title' => 'Заголовок',
			'description' => 'Описание',
			'description_short' => 'Короткое описание',
			'url' => 'Url',
			'status' => 'Статус',
			'meta_title' => 'Meta Title',
			'meta_keywords' => 'Meta Keywords',
			'meta_description' => 'Meta Description',
			'execute' => 'Execute',
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
		$criteria->compare('left_key',$this->left_key);
		$criteria->compare('level',$this->level);
		$criteria->compare('right_key',$this->right_key);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('description_short',$this->description_short,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_description',$this->meta_description,true);
        $criteria->compare('fkey',$this->fkey,true);
		$criteria->compare('execute',$this->execute);

		$criteria_param = array(
			'criteria'=>$criteria,
		);
		if ($settingsModel = SiteModuleSettings::model()->find('site_module_id = 4')){
			$criteria_param['Pagination'] = array('PageSize'=>(((int)$settingsModel->elements_page_admin>0)?$settingsModel->elements_page_admin:10));
		}


		return new CActiveDataProvider($this, $criteria_param);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CatalogRubrics the static model class
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
        return array(
            'nestedSetBehavior'=>array(
                'class'=>'ext.nestedtrees.NestedSetBehavior',
                'leftAttribute'=>'left_key',
                'rightAttribute'=>'right_key',
                'levelAttribute'=>'level',
            ),
        );
    }

    public static function getRoot(CatalogRubrics $model){
        $root = $model->roots()->find();
        if (! $root){
            $model->name = 'Каталог Корневое Дерево';
            $model->url = 'RootTreeCatalogs';
            $model->level = 1;
            //$model->image = 'jpeg';
            $model->parent_id = 0;
            //$model->description = 'Категории';
            //$model->lastupdate = date('Y-m-d H:i:s');
            $model->status = 1;
            $model->meta_title = 'Каталог Корневое Дерево';
            $model->meta_title = 'Каталог Корневое Дерево';
            $model->meta_keywords = 'Каталог Корневое Дерево';
            $model->meta_description = 'Каталог Корневое Дерево';
            $model->saveNode();
            $root = $model->roots()->find();
        }
        return $root;
    }

    /**
     * Получить корень дерева (верхний уровень) по level иди parent_id
     * по lvl= 2
     */
    public static function getRootTree($type = 1){
        $param = (($type==1)?('level = 2'):('parent_id = 0'));
        return $model = CatalogRubrics::model()->findAll($param.' ORDER BY left_key');
    }

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

	/**
	 * @param null $model
	 * @param null $level
	 * Возвращает список категорий
	 * Уровень вложенности
	 */
	public static function getCatalogList($model = null, $level = null){
		$return_data = array();
		if (empty($model)){ $model = CatalogRubrics::getRoot(new CatalogRubrics); }
		return $model->descendants($level,1)->findAll($model->id);
	}

	/**
	 * @param $model
	 * Возвращает полный путь к каталогу
	 */
	public static function urlCatalog($model){
		$url = Pages::getBaseUrl(4).'/';
		foreach ( CatalogRubrics::getCatalogList($model) as $data ){
			$url .= $data->url.'/';
		}
		return $url;
	}



	protected function afterDelete() {
		//Удаляем связанные с категорией товары (1 запрос)
		CatalogElements::model()->deleteAll('parent_id = :parent_id', array(':parent_id' => $this->id));
		parent::afterDelete();
	}

}
