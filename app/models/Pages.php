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
 * @property string $header
 * @property string $image
 * @property integer $access_lvl
 * @property string $main_template
 * @property integer $type_module
 * @property string $content
 * @property integer $status
 * @property string $created_at
 * @property integer $in_footer
 * @property integer $in_header
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
			array('parent_id, level, left_key, right_key, access_lvl, type_module, main_page, status, in_footer, in_header', 'numerical', 'integerOnly'=>true),
			array('url, title, main_template, meta_title', 'length', 'max'=>250),
			array('image, header', 'length', 'max'=>350),

			array('url','unique',
				'caseSensitive'=>true,
				'allowEmpty'=>false,
			),

			array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			array('content, meta_keywords, meta_description, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, level, left_key, right_key, url, title, image, access_lvl, header, main_template, type_module, content, main_page, status, created_at, created_at_start, created_at_end,
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
			'module' => array(self::BELONGS_TO, 'SiteModule', 'type_module'),
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
			'title' => 'Название',
			'image' => 'Изображение для ссылки',
			'access_lvl' => 'Минимальный уровень прав для доступа к странице',
			'main_template' => 'Имя основного шаблона',
			'type_module' => 'Модуль страницы',
			'content' => 'Содержимое',
			'status' => 'Статус',
			'header' => 'Заголовок',
			'main_page' => 'Главная страница',
			'meta_title' => 'Meta Title',
			'meta_keywords' => 'Meta Keywords',
			'meta_description' => 'Meta Description',
			'created_at' => 'Created At',
			'in_footer' => 'Нижнее меню',
			'in_header' => 'Верхнее меню',
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
		$criteria->compare('header',$this->header);
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


	/**
	 * @param Pages|null $model
	 * @return Pages
	 */
	public static function getRoot(Pages $model = null){
		if (is_null($model)) {
			$model = new self;
		}
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
			foreach($cats[$parent_id] as $cat) {
				$tree[$cat['id']]['title'] = $cat['title'];
				$tree[$cat['id']]['url'] = $cat->getPageUrl();
				$tree[$cat['id']]['access_lvl'] = $cat['access_lvl'];
				$tree[$cat['id']]['image'] = $cat['image'];
				$tree[$cat['id']]['in_header'] = $cat['in_header'];
				$tree[$cat['id']]['in_footer'] = $cat['in_footer'];
				if ( $children =  $this->build_tree($cats,$cat['id']) ){
					$tree [$cat['id']]['children'] =  $children;
				}
			}
		} else {
			return null;
		}
		return $tree;
	}

	public function getPagesArray($type){
		$root = Pages::getRoot(new Pages);
		$pagesArray = $root->descendants(null,1)->findAll($root->id);
		$cats = array();
		foreach ( $pagesArray as $data ){
			if (($type == 2 && $data->in_header != 1) || ($type == 3 && $data->in_footer != 1) ){ continue; }
			$cats_ID[$data->id][] = $data;
			$cats[$data->parent_id][$data->id] =  $data;
		}
		$result = $this->build_tree($cats,$root->id);

		return $result;
	}

	/**
	 * Тип возвращаемых данных
	 * 1 - все меню
	 * 2 - только с признаком in_header = 1
	 * 3 - только с признаком in_footer = 1
	 */
	public static function getMenu($type = 1){
		return Pages::model()->getPagesArray($type);
	}
	public static function getMenuTitle(){
		return Pages::getMenu(2);
	}
	public static function getMenuFooter(){
		return Pages::getMenu(3);
	}

	public static function getTitle($id_page = null){
		if (!empty($id_page) && $model = Pages::model()->findByPk((int)$id_page)){
			return ((!empty($model->header))?($model->header):($model->title));
		}
		$url = Yii::app()->request->requestUri;
		//ToDo кастыль из-за стандартной пагинации. Убрать после того как сделаем свой виджет пагинации
		preg_match_all('/\?id=(\d+)&page=(\d+)/', $url, $matches);
		if (isset($matches[0]) && !empty($matches[0])){
			$url = str_replace($matches[0], "/", $url);
		}
		foreach (explode("/", ($url.'/')) as $url){
			if ($model = Pages::model()->find('url LIKE "'.(trim($url)).'"')){
				return ((!empty($model->header))?($model->header):($model->title));
			}
		}
		return true;
	}


	//возвращает URL страницы на основе текущего URL
	public static function returnUrl($url){
		$urlArr = explode("/", (Yii::app()->request->requestUri.'/'.$url.'/'));
		$urlArr = array_diff($urlArr, array(''));

		$modelPages = Pages::model()->find('url LIKE "'.(array_shift($urlArr)).'"');
		//Не текстовая страницы - смотрю модуль
		$complite_url = $modelPages->url.'/'.$url;
		if ($modelPages->type_module != 0){
			//Число - ищем в таблице элементов
			if (is_numeric(end($urlArr))){
				if ( $tabel_name = SiteModuleSettings::model()->getModelById($modelPages->type_module, 2) ) {
					$parent_field_name = 'group_id';
					if (!Yii::app()->db->createCommand("show columns from " . $tabel_name . " where `Field` = '" . $parent_field_name . "'")->queryRow()) {
						$parent_field_name = 'parent_id';
					}
					$modelElemetn = Yii::app()->db->createCommand()
						->select('id, ' . $parent_field_name)
						->from($tabel_name)
						->where('id = ' . array_pop($urlArr))
						->queryRow();
					$complite_url = $modelPages->url;
					if ((int)$modelElemetn[$parent_field_name] > 0) {
						$tabel_name = SiteModuleSettings::model()->getModelById($modelPages->type_module, 1);
						$url_field_name = '';
						if (Yii::app()->db->createCommand("show columns from " . $tabel_name . " where `Field` = 'url'")->queryRow()) {
							$url_field_name = 'url';
						}
						$modelCatalog = Yii::app()->db->createCommand()
							->select('id, name' . ((!empty($url_field_name)) ? (', ' . $url_field_name) : ('')))
							->from($tabel_name)
							->where('id = ' . (int)$modelElemetn[$parent_field_name])
							->queryRow();
						if (isset($modelCatalog['url'])) {
							$complite_url .= '/' . $modelCatalog['url'];
						}
					}
					$complite_url .= '/' . $url;
				}

			}
			//Текст - ищем в таблице групп
			else {
				//Ссылка - таблица групп
				$tabel_name = SiteModuleSettings::model()->getModelById($modelPages->type_module, 1);
				if ( !empty($tabel_name) && Yii::app()->db->createCommand("show columns from ".$tabel_name." where `Field` = 'level'")->queryRow() ){

					$modelCatalog = Yii::app()->db->createCommand()
						->select('id, parent_id, level' )
						->from($tabel_name)
						->where('url LIKE "'.end($urlArr).'"')
						->queryRow();
					$model = SiteModuleSettings::model()->getModelById($modelPages->type_module, 1, 0);
					$category = $model::model()->findByPk((int)$modelCatalog['id']);
					if ( $category = $category->ancestors()->findAll() ){
						foreach ( $category as $data){
							if ($data->level <= 1){ continue; }
							$complite_url .= '/'.$data->url;
						}
					} else { $complite_url .= '/'.$url; }
				}
			}

		}

		return $complite_url;
	}

	/**
	 * @param $url
	 * Возвращает true если это активная страница
	 */
	public static function isActive(){
		foreach (explode("/", (Yii::app()->request->requestUri.'/')) as $url){
			if ($model = Pages::model()->find('url LIKE "'.(trim($url)).'"')){ return $model->id;}
		}
		return false;
	}

	public static function getBaseUrl($module_id){
		$base_url = null;
		foreach (explode("/", (Yii::app()->request->requestUri.'/')) as $url){
			if ($modelPages = Pages::model()->find('url LIKE "'.(trim($url)).'"')){
				$base_url = $modelPages->url;
				break;
			}
		}
		if (empty($base_url)){ $base_url = Pages::model()->find('type_module = '.$module_id.' AND `status` = 1')->url; }
		return $base_url;
	}


	public static function getModelByUrl() {
		$result = null;

		//Определение правила по URL
		$currentRule = Yii::app()->urlManager->parseUrl(Yii::app()->request);
		$currentMask = null; //Маска URL (ключ в Rules)
		foreach(Yii::app()->urlManager->rules as $ruleParam => $ruleRow) {
			if ($currentRule == trim($ruleRow, '/')) {
				$currentMask = $ruleParam;
				break;
			}
		}

		if (!empty($currentMask)) {
			//Если маска найдена, то формируем крошку для корня через модель Pages
			$currentMask = explode('/<', $currentMask);
			$currentMask = trim($currentMask[0], '/');
			$result = self::model()->find('url = :url', array(":url" => $currentMask));
		}

		return $result;
	}


	/**
	 * Получаем отформатированных потомков
	 *
	 * @param $rootId
	 * @return array
	 */
	public function getFormattedDescendants($rootId) {
		$result = array();
		$models = $this->descendants()->findAll($rootId);
		foreach ($models as $model) {
			$result[$model->id] = str_repeat('&nbsp;&nbsp;', ($model->level - 1) * 4) . $model->title;
		}
		return $result;
	}


	/**
	 * Получаем ссылку на текущую страницу
	 *
	 * @return string
	 */
	public function getPageUrl() {
		if ($this->main_page == 1) {
			$url = '/';
		} elseif (!empty($this->module)) {
			$url = Yii::app()->urlManager->createUrl($this->module->url_to_controller);
		} else {
			$url = Yii::app()->urlManager->createUrl('/content/pages/index/id/'.$this->id); //ID не очень правильно передается, но пока так
		}
		return $url;
	}
}
