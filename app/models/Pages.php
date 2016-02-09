<?php

/**
 * This is the model class for table "{{pages}}".
 *
 * The followings are the available columns in table '{{pages}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $level
 * @property integer $left_key
 * @property integer $right_key
 * @property string $url
 * @property string $title
 * @property string $image
 * @property integer $access_lvl
 * @property string $main_template
 * @property integer $type_module
 * @property string $content
 * @property integer $status
 * @property string $created_at
 */
class Pages extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
	public $imagefile;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, url, title, type_module', 'required'),
			array('parent_id, level, left_key, right_key, access_lvl, type_module, main_page, status', 'numerical', 'integerOnly'=>true),
			array('url, title, main_template, meta_title', 'length', 'max'=>250),
			array('image', 'length', 'max'=>350),

			array('url','unique',
				'caseSensitive'=>true,
				'allowEmpty'=>false,
			),

			array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			array('content, meta_keywords, meta_description, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, level, left_key, right_key, url, title, image, access_lvl, main_template, type_module, content, main_page, status, created_at, created_at_start, created_at_end,
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
			'parent_id' => 'Категория',
			'level' => 'Level',
			'left_key' => 'Left Key',
			'right_key' => 'Right Key',
			'url' => 'Url адрес',
			'title' => 'Заголовок',
			'image' => 'Изображение для ссылки',
			'access_lvl' => 'Минимальный уровень прав для доступа к странице',
			'main_template' => 'Имя основного шаблона',
			'type_module' => 'Модуль страницы',
			'content' => 'Содержимое',
			'status' => 'Статус',
			'main_page' => 'Главная страница',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('level',$this->level);
		$criteria->compare('left_key',$this->left_key);
		$criteria->compare('right_key',$this->right_key);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('access_lvl',$this->access_lvl);
		$criteria->compare('main_template',$this->main_template,true);
		$criteria->compare('type_module',$this->type_module);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('main_page',$this->main_page);
		$criteria->compare('created_at',$this->created_at);

		if (!empty($param)){
			$criteria->condition = $param;
		}


		return $criteria;

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function getTypeModule(){
		$name = array(0 => 'Текстовая страница');
		foreach (SiteModule::model()->findAll() as $data){
			//Проверяю, не отлючен ли модуль
			if (SiteModuleSettings::model()->find('site_module_id = '.$data->id.' AND `status`=0')){continue;}
			$name[$data->id] = $data->name;
		}
		return $name;
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

	public static function getRoot(Pages $model){
		$root = $model->roots()->find();
		if (! $root){
			$model->title = '/';
			$model->url = 'mainPageRootTree';
			$model->level = 1;
			$model->parent_id = 0;
			$model->status = 1;
			$model->type_module = 0;
			$model->saveNode();
			$root = $model->roots()->find();
		}
		return $root;
	}

	/**
	 * Возвращает массив содержащий структуру страницы сайта. В массиве children содержатся подчиненные страницы
	 */
	private function build_tree($cats,$parent_id){
		if(is_array($cats) and isset($cats[$parent_id])){
			$tree = array();
			foreach($cats[$parent_id] as $cat){
				$tree [$cat['id']]['title'] = $cat['title'];
				$tree [$cat['id']]['url'] = $cat['url'];
				$tree [$cat['id']]['access_lvl'] = $cat['access_lvl'];
				if ( $children =  $this->build_tree($cats,$cat['id']) ){
					$tree [$cat['id']]['children'] =  $children;
				}
			}
		}
		else return null;
		return $tree;
	}

	public function getPagesArray(){
		$root = Pages::getRoot(new Pages);
		$pagesArray = $root->descendants(null,1)->findAll($root->id);
		$cats = array();
		foreach ( $pagesArray as $data ){
			if ($data->main_page == 1){ continue; /* Главную страницу пропускаю */ }
			$cats_ID[$data->id][] = $data;
			$cats[$data->parent_id][$data->id] =  $data;
		}
		$result = $this->build_tree($cats,$root->id);

		return $result;
	}

	public static function getMenu(){
		return Pages::model()->getPagesArray();
	}



}
