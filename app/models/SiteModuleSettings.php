<?php

/**
 * This is the model class for table "{{site_module_settings}}".
 *
 * The followings are the available columns in table '{{site_module_settings}}':
 * @property integer $id
 * @property integer $site_module_id
 * @property string $version
 * @property string $r_cover_small
 * @property string $r_cover_small_crop
 * @property string $r_cover_medium
 * @property string $r_cover_medium_crop
 * @property string $r_cover_medium2
 * @property string $r_cover_medium2_crop
 * @property integer $r_cover_quality
 * @property string $r_small_color
 * @property string $r_medium_color
 * @property string $r_medium2_color
 * @property integer $elements_page_admin
 * @property string $watermark
 * @property integer $watermark_pos
 * @property integer $watermark_type
 * @property integer $watermark_transp
 * @property string $watermark_color
 * @property integer $watermask_font
 * @property string $watermask_fontsize
 * @property integer $status
 * @property string $created_at
 */
class SiteModuleSettings extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
	public $image_watermark;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{site_module_settings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_module_id, r_cover_quality, r_cover_small_crop, r_cover_medium_crop, r_cover_medium2_crop, e_cover_quality, e_cover_small_crop, e_cover_medium_crop, e_cover_medium2_crop', 'required'),
			array('site_module_id, r_cover_quality, e_cover_quality, elements_page_admin, watermark_pos, watermark_type, watermark_transp, watermask_font, status', 'numerical', 'integerOnly'=>true),
			array('version, r_small_color, r_medium_color, r_medium2_color, e_small_color, e_medium_color, e_medium2_color', 'length', 'max'=>10),
			array('r_cover_small, r_cover_medium, r_cover_medium2, e_cover_small, e_cover_medium, e_cover_medium2', 'length', 'max'=>50),
			array('r_cover_small_crop, r_cover_medium_crop, r_cover_medium2_crop, e_cover_small_crop, e_cover_medium_crop, e_cover_medium2_crop', 'length', 'max'=>12),
			array('watermark', 'length', 'max'=>255),
			array('watermark_color', 'length', 'max'=>80),
			array('watermask_fontsize', 'length', 'max'=>20),
			array('image_watermark', 'file', 'types'=>'png', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site_module_id, version, r_cover_small, r_cover_small_crop, r_cover_medium, r_cover_medium_crop, r_cover_medium2, r_cover_medium2_crop, r_cover_quality, r_small_color, r_medium_color, r_medium2_color, e_cover_small, e_cover_small_crop, e_cover_medium, e_cover_medium_crop, e_cover_medium2, e_cover_medium2_crop, e_cover_quality, e_small_color, e_medium_color, e_medium2_color, elements_page_admin, watermark, watermark_pos, watermark_type, watermark_transp, watermark_color, watermask_font, watermask_fontsize, status, created_at, created_at_start, created_at_end,
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
			'siteModuleName' => array(self::BELONGS_TO, 'SiteModule', 'site_module_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site_module_id' => 'Модуль',
			'version' => 'Версия',
			'r_cover_small' => 'Размер превью картинки (префикс small)',
			'r_cover_small_crop' => 'Метод обрезки изображения (префикс small)',
			'r_cover_medium' => 'Размер картинки (префикс medium)',
			'r_cover_medium_crop' => 'Метод обрезки изображения (префикс medium)',
			'r_cover_medium2' => 'Размер картинки (префикс medium2)',
			'r_cover_medium2_crop' => 'Метод обрезки изображения (префикс medium2)',
			'r_cover_quality' => 'Качество картинок',
			'r_small_color' => 'Цвет заднего фона в 16-ричном формате (напр. 852a8b), для прозрачных полей - пустое значение',
			'r_medium_color' => 'Цвет заднего фона в 16-ричном формате (напр. 852a8b), для прозрачных полей - пустое значение',
			'r_medium2_color' => 'Цвет заднего фона в 16-ричном формате (напр. 852a8b), для прозрачных полей - пустое значение',
			'e_cover_small' => 'Размер превью картинки (префикс small)',
			'e_cover_small_crop' => 'Метод обрезки изображения (префикс small)',
			'e_cover_medium' => 'Размер картинки (префикс medium)',
			'e_cover_medium_crop' => 'Метод обрезки изображения (префикс medium)',
			'e_cover_medium2' => 'Размер картинки (префикс medium2)',
			'e_cover_medium2_crop' => 'Метод обрезки изображения (префикс medium2)',
			'e_cover_quality' => 'Качество картинок',
			'e_small_color' => 'Цвет заднего фона в 16-ричном формате (напр. 852a8b), для прозрачных полей - пустое значение',
			'e_medium_color' => 'Цвет заднего фона в 16-ричном формате (напр. 852a8b), для прозрачных полей - пустое значение',
			'e_medium2_color' => 'Цвет заднего фона в 16-ричном формате (напр. 852a8b), для прозрачных полей - пустое значение',
			'elements_page_admin' => 'Количество на страницу (админ)',
			'watermark' => 'Watermark',
			'watermark_pos' => 'Расположение водяного знака',
			'watermark_type' => 'Тип водяного знака',
			'watermark_transp' => 'Watermark Transp',
			'watermark_color' => 'Watermark Color',
			'watermask_font' => 'Watermask Font',
			'watermask_fontsize' => 'Watermask Fontsize',
			'status' => 'Статус',
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
		$criteria->compare('site_module_id',$this->site_module_id);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('r_cover_small',$this->r_cover_small,true);
		$criteria->compare('r_cover_small_crop',$this->r_cover_small_crop,true);
		$criteria->compare('r_cover_medium',$this->r_cover_medium,true);
		$criteria->compare('r_cover_medium_crop',$this->r_cover_medium_crop,true);
		$criteria->compare('r_cover_medium2',$this->r_cover_medium2,true);
		$criteria->compare('r_cover_medium2_crop',$this->r_cover_medium2_crop,true);
		$criteria->compare('r_cover_quality',$this->r_cover_quality);
		$criteria->compare('r_small_color',$this->r_small_color,true);
		$criteria->compare('r_medium_color',$this->r_medium_color,true);
		$criteria->compare('r_medium2_color',$this->r_medium2_color,true);
		$criteria->compare('e_cover_small',$this->e_cover_small,true);
		$criteria->compare('e_cover_small_crop',$this->e_cover_small_crop,true);
		$criteria->compare('e_cover_medium',$this->e_cover_medium,true);
		$criteria->compare('e_cover_medium_crop',$this->e_cover_medium_crop,true);
		$criteria->compare('e_cover_medium2',$this->e_cover_medium2,true);
		$criteria->compare('e_cover_medium2_crop',$this->e_cover_medium2_crop,true);
		$criteria->compare('e_cover_quality',$this->e_cover_quality);
		$criteria->compare('e_small_color',$this->e_small_color,true);
		$criteria->compare('e_medium_color',$this->e_medium_color,true);
		$criteria->compare('e_medium2_color',$this->e_medium2_color,true);
		$criteria->compare('elements_page_admin',$this->elements_page_admin);
		$criteria->compare('watermark',$this->watermark,true);
		$criteria->compare('watermark_pos',$this->watermark_pos);
		$criteria->compare('watermark_type',$this->watermark_type);
		$criteria->compare('watermark_transp',$this->watermark_transp);
		$criteria->compare('watermark_color',$this->watermark_color,true);
		$criteria->compare('watermask_font',$this->watermask_font);
		$criteria->compare('watermask_fontsize',$this->watermask_fontsize,true);
		$criteria->compare('status',$this->status);
		$this->compareDate($criteria, 'created_at');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'Pagination'=> array(
				'PageSize'=>300,
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SiteModuleSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * отдает массив папок для моделей
	 */
	public function getFolderModule(){
		$returnArray = array();
		foreach ( SiteModule::model()->findAll() as $data ){
			$nameArr = explode("/", $data->url_to_controller);
			$name =  array_pop($nameArr);
			$returnArray[$data->id] = $name;
		}
		//заменяем нужные
		$returnArray[4] = 'catalog'; //Каталог
		return $returnArray;
	}

	/**
	 * @param $id
	 * Возвращает название папки модуля (с загружаемыми файлами) по id модуля
	 */
	public function getFolderModelName($id){
		$returnArray = array();
		foreach ( SiteModule::model()->findAll() as $data ){
			$nameArr = explode("/", $data->url_to_controller);
			$name =  array_pop($nameArr);
			$returnArray[$data->id] = $name;
		}
		return $returnArray[$id];
	}

	/**
	 * @param $id
	 * Проверяет есть ли папки у модуля. Если есть - возрашает true, если нет - false
	 */
	public function chkFolder($id){
		$folder = SiteModuleSettings::model()->getFolderModule();
		$folder = $folder[$id];
		$patch = array();
		$patch[] = '/../uploads/filestorage/'.$folder;
		$patch[] = '/../uploads/filestorage/'.$folder.'/elements';
		$patch[] = '/../uploads/filestorage/'.$folder.'/photos';
		$patch[] = '/../uploads/filestorage/'.$folder.'/rubrics';
		foreach ($patch as $data){
			$patch_tmph = YiiBase::getPathOfAlias('webroot').$data;
			if (!file_exists($patch_tmph)){
				return false;
			}
		}
		return true;
	}

	/**
	 * @param null $id
	 * @param int $permission
	 * @return array
	 * Проверяет есть ли папка модуля. Если нет - создает ее с правами $permission
	 */
	public  function createFolders($id = null, $permission = 0777){
		foreach (SiteModuleSettings::model()->getFolderModule() as $key=>$val){
			if (!empty($id) && (int)$id!=$key){continue;}
			if (SiteModuleSettings::model()->chkFolder($key)){ continue; }
			$patch = array();
			$patch[] = '/../uploads/filestorage/'.$val;
			$patch[] = '/../uploads/filestorage/'.$val.'/elements';
			$patch[] = '/../uploads/filestorage/'.$val.'/photos';
			$patch[] = '/../uploads/filestorage/'.$val.'/rubrics';
			foreach ($patch as $data){
				$patch_tmph = YiiBase::getPathOfAlias('webroot').$data;
				if (file_exists($patch_tmph)) { continue; }
				mkdir($patch_tmph, $permission, true);
			}
		}
		return true;
	}

	/**
	 * Создает записи в таблице настроек модулей по умолчанию, если нет такой записи
	 */
	public function createDefaultModules(){
		foreach ( SiteModuleSettings::model()->getFolderModule() as $module_id => $module_name ){
			if (SiteModuleSettings::model()->find('site_module_id = '.$module_id)){ continue; }
			$model = new SiteModuleSettings();
			$model->site_module_id = $module_id;
			$model->version = '1.0';
			$model->r_cover_small_crop = 'Resize';
			$model->r_cover_medium_crop = 'Resize';
			$model->r_cover_medium2_crop = 'Resize';
			$model->e_cover_small_crop = 'Resize';
			$model->e_cover_medium_crop = 'Resize';
			$model->e_cover_medium2_crop = 'Resize';
			$model->watermark_type = 0;
			$model->watermark_pos = 1;
			$model->status = 1;
			$model->save();
		}
		return true;
	}

	/**
	 * @param null $key
	 * @return array
	 * Возвращает метод обрезки изображения
	 */
	public function getResizeMethod($key = null){
		$returnArray = array(
			'Resize'=>'Сохранять существующее отношение сторон',
			'horResize'=>'Фиксировать горизонтальный размер (только по первому числу из размерной пары)',
			'verResize'=>'Фиксировать вертикальный размер (только по второму числу из размерной пары)',
			'insertResize'=>'Дополнять фотографию до заданного отношения сторон полями',
			'exactResize'=>'Обрезать фотографию до заданного отношения сторон',
			);
		if (!empty($key)) $returnArray = $returnArray[$key];
		return $returnArray;
	}


	/**
	 * @param null $id
	 * @return array
	 * Возращает массив выбора накладывания водяного знака
	 */
	public function getWatermarkMethod($id = null){
		$returnArray = array(
			1 => 'Изображение замостить',
			2 => 'Изображение в нижнем левом углу',
			3 => 'Изображение внизу по центру',
			4 => 'Изображение в центре',
			5 => 'Изображение в левом верхнем углу',
			6 => 'Изображение в нижнем правом углу',
		);
		if (!empty($id)) $returnArray = $returnArray[$id];
		return $returnArray;
	}

	/**
	 * @param $site_module_id
	 * @param int $type
	 * Возвращает имя таблицы по alias модуля (таблица tbl_site_module_settings), тип указывает тип таблицы (1-рубрика, 2-элемент)
	 */
	public function getModelById($site_module_id, $type=1){
		switch ($site_module_id) {
			case 1:
				//Новости
				return (($type==1)?('{{news_rubrics}}'):('{{news_elements}}'));
				break;
			case 2:
				//Карта сайта
				return false;
				break;
			case 3:
				//Поиск на сайте
				return false;
				break;
			case 4:
				//Каталог
				return (($type==1)?('{{catalog_rubrics}}'):('{{catalog_elements}}'));
				break;
			case 5:
				//Корзина
				return (($type==1)?('{{basket_order}}'):('{{basket_items}}'));
				break;
			case 6:
				//Статьи
				return (($type==1)?('{{article_rubrics}}'):('{{article_elements}}'));
				break;
			case 7:
				//Вопросы-ответы
				return (($type==1)?('{{faq_rubrics}}'):('{{faq_elements}}'));
				break;
			case 8:
				//URL ссылка (пишите адрес ссылки в Url адрес )
				return false;
				break;
			case 9:
				//Акции
				return (($type==1)?('{{sale_group}}'):('{{sale}}'));
				break;
			case 10:
				//Врачи
				return (($type==1)?('{{doctor_rubrics}}'):('{{doctor_elements}}'));
				break;
			case 11:
				//Фотогалерея
				return (($type==1)?('{{photo_rubrics}}'):('{{photo_elements}}'));
				break;
			case 12:
				//До и После
				return (($type==1)?('{{before_after_rubrics}}'):('{{before_after_elements}}'));
				break;
			case 13:
				//Таблицы
				return (($type==1)?('{{main_tabel}}'):('{{main_tabel}}'));
				break;
			case 14:
				//Пресса
				return (($type==1)?('{{press_group}}'):('{{press}}'));
				break;
			case 15:
				//Банеры
				return (($type==1)?('{{baners_rubrics}}'):('{{baners_elements}}'));
				break;
			case 16:
				//Отзывы
				return (($type==1)?('{{review_rubrics}}'):('{{review_elements}}'));
				break;
		}
		return false;
	}

	/**
	 * Создает изображение для раздела
	 * @param string $driver - драйвер обработки изображения GD или Imagick
	 * @param $model - таблица tbl_site_module_settings
	 * @param int $type - указывает на обрабатываемые объекты =1- рубрика, 2-элементы
	 * @param $id_element_model - если указан id обрабатываемого элемента - работаем только с ним а не со всеми элементами таблицы
	 */
	public function chgImgModel($model, $driver='GD', $type = 1, $id_element_model = null){
		if ( !$tabel_name = SiteModuleSettings::model()->getModelById($model->site_module_id, $type) ){ return false; } //НЕ ЗАБЫВАТЬ ДОБАВЛЯТЬ ИМЯ ТАБЛИЦЫ В МЕТОД!!!!
		$folder = SiteModuleSettings::model()->getFolderModelName($model->site_module_id);
		$filepatch = '../uploads/filestorage/'.$folder.'/'.(($type==1)?('rubrics'):('elements')).'/';

		//Проверяем наличие поля image у таблицы
		if ( !Yii::app()->db->createCommand("show columns from ".$tabel_name." where `Field` = 'image'")->queryRow() ){return false;}

		set_time_limit(0);

		if (empty($id_element_model)){
			$modelCatalog = Yii::app()->db->createCommand()
				->select('id, image')
				->from($tabel_name)
				->queryAll();
		} else {
			$modelCatalog = Yii::app()->db->createCommand()
				->select('id, image')
				->from($tabel_name)
				->where('id=:id', array(':id'=>$id_element_model))
				->queryAll();
		}

		$param = array();
		if ($type==1){
			$param['small'] = array( 'coords'=>$model->r_cover_small, 'crop'=>$model->r_cover_small_crop, 'color'=>$model->r_small_color   );
			$param['medium'] = array( 'coords'=>$model->r_cover_medium, 'crop'=>$model->r_cover_medium_crop, 'color'=>$model->r_medium_color   );
			$param['medium2'] = array( 'coords'=>$model->r_cover_medium2, 'crop'=>$model->r_cover_medium2_crop, 'color'=>$model->r_medium2_color   );
			$param['admin'] = array( 'coords'=>'100x100', 'crop'=>'Resize', 'color'=>'ffffff'   );
		}
		if ($type==2){
			$param['small'] = array( 'coords'=>$model->e_cover_small, 'crop'=>$model->e_cover_small_crop, 'color'=>$model->e_small_color   );
			$param['medium'] = array( 'coords'=>$model->e_cover_medium, 'crop'=>$model->e_cover_medium_crop, 'color'=>$model->e_medium_color   );
			$param['medium2'] = array( 'coords'=>$model->e_cover_medium2, 'crop'=>$model->e_cover_medium2_crop, 'color'=>$model->e_medium2_color   );
			$param['admin'] = array( 'coords'=>'100x100', 'crop'=>'Resize', 'color'=>'ffffff'   );
		}


		foreach ($modelCatalog as $key=>$val){
			if (empty($val['image'])){continue;}
			$id_element = (int)$val['id'];
			$img_element = $val['image'];

			foreach ($param as $name => $data){

				if (!file_exists($filepatch.$id_element.'.'.$img_element)){continue;}

				$image = new EasyImage($filepatch.$id_element.'.'.$img_element, $driver); //$image = new EasyImage($fileOrigin, 'Imagick');  - для Imagic


				//Накладываем возяной знак
				$watermark = YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/'.$folder.'/watermark.png';

				if ( $model->watermark_type == 1 && file_exists($watermark) && $name != 'admin'  ){
					$opacity = 20;
					$watermark_pos = $model->watermark_pos;

					//Получаем размеры водяного знака
					$mark = new EasyImage($watermark);

					//Позиции водной марки
					$sizeWm = getimagesize($watermark);
					$size = getimagesize($filepatch.$id_element.'.'.$img_element);
					switch ($watermark_pos) {
							case 1: //Замостить
								for ($y_i=0; $y_i<$size[1]; $y_i = $y_i+$sizeWm[1]){
									for ($x_i=0; $x_i<$size[0]; $x_i = $x_i+$sizeWm[0]){
										$image->watermark($mark, $x_i, $y_i, $opacity);
									}
								}
								break;
							case 2: //Изображение в нижнем левом углу
								$x_i = 0;
								$y_i = $size[1] - $sizeWm[1];
								$image->watermark($mark, $x_i, $y_i, $opacity);
								break;
							case 3: //Изображение внизу по центру
								$x_i = ($size[0]/2)-($sizeWm[0]/2);
								$y_i = $size[1]-$sizeWm[1];
								$image->watermark($mark, $x_i, $y_i, $opacity);
								break;
							case 4: //Изображение в центре
								//$x_i =($x/2)-($sizeWm[0]/2);
								$x_i =($size[0]/2)-($sizeWm[0]/2);
								$y_i =($size[1]/2)-($sizeWm[1]/2);
								$image->watermark($mark, $x_i, $y_i, $opacity);
								break;
							case 5: //Изображение в левом верхнем углу
								$image->watermark($mark, 0, 0, $opacity);
								break;
							case 6:  //Изображение в нижнем правом углу
								$x_i = $size[0] - $sizeWm[0];
								$y_i = $size[1] - $sizeWm[1];
								$image->watermark($mark, $x_i, $y_i, $opacity);
								break;
							default:
								$image->watermark($mark, 0, 0, $opacity);
					}

				}

				$coords = explode("x", (strtolower($data['coords'])));
				$x = $coords[0];
				$y = $coords[1];
				switch ($data['crop']) {
					case 'Resize':
						$image->resize($x,$y, EasyImage::RESIZE_AUTO);
						break;
					case 'horResize':
						$image->resize($x,$y, EasyImage::RESIZE_WIDTH);
						break;
					case 'verResize':
						$image->resize($x,$y, EasyImage::RESIZE_HEIGHT);
						break;
					case 'insertResize':
						$image->resize($x,$y, EasyImage::RESIZE_AUTO);
						$image->background('#'.(str_replace("#", "", $data['color'])), 100);
						break;
					case 'exactResize':
						$image->crop($x,$y);
						break;
					default:
						$image->resize($x,$y, EasyImage::RESIZE_AUTO);
				}
				$image->save($filepatch.$name.'-'.$id_element.'.'.$img_element);
			}


		}

		return true;

	}

}
