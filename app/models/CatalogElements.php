<?php

/**
 * This is the model class for table "{{warehouse_elements}}".
 *
 * The followings are the available columns in table '{{warehouse_elements}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $order_id
 * @property string $name
 * @property string $brieftext
 * @property integer $status
 * @property integer $ansvtype
 * @property integer $hit
 * @property string $image
 * @property string $page_name
 * @property string $description
 * @property string $fkey
 * @property string $code
 * @property integer $shares
 * @property integer $primary
 * @property double $price
 * @property double $price_old
 * @property double $price_entering
 * @property integer $qty
 * @property double $code_3d
 */
class CatalogElements extends CActiveRecord
{

    public $serch_name_code;
	public $filterData; //ID родительской категории рубрик
    public $imagefile;
	public $imagefiles;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_elements}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, name,', 'required'),
			array('parent_id, order_id, status, ansvtype, hit, qty, shares, primary', 'numerical', 'integerOnly'=>true),
			array('price, price_old, price_entering, filterData', 'numerical'),
			array('name, page_name, fkey', 'length', 'max'=>250),
			array('image', 'length', 'max'=>5),
			array('code', 'length', 'max'=>100),
			array('description', 'length', 'min'=>50),
			array('brieftext, code_3d', 'length', 'max'=>1000),

            array('imagefile', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
			array('imagefiles', 'file', 'types'=>'jpg, gif, png, jpeg', 'maxFiles'=>10, 'allowEmpty' => true),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, order_id, name, brieftext, code_3d, status, ansvtype, qty, shares, primary, hit, image, page_name, description, fkey, code, serch_name_code, price, price_old, price_entering, filterData', 'safe', 'on'=>'search'),
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
			'parent_id' => 'Категория',
			'order_id' => 'Порядок',
			'name' => 'Название',
			'brieftext' => 'Анонс (короткий текст)',
			'status' => 'Статус',
			'ansvtype' => 'Ansvtype',
			'hit' => 'Hit',
			'image' => 'Изображение',
			'imagefile' => 'Основное (главное) изображение товара',
			'imagefiles' => 'Дополнительные изображения товара',
			'page_name' => 'Page Name',
			'description' => 'Описание',
			'fkey' => 'Fkey',
			'code' => 'Код',
			'price' => 'Цена',
			'shares' => 'Акция',
			'primary' => 'На главную',
			'price_old' => 'Старая цена',
			'price_entering' => 'Price Entering',
			'code_3d' => '3D',
		);
	}

	/**
	 *
	 * @param null $param
	 *
	 * @return CDbCriteria
	 */
	public function search($param = null) {
		$criteria=new CDbCriteria;

        if (!empty($param)){
            $criteria->condition=$param;
        }

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('brieftext',$this->brieftext,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('ansvtype',$this->ansvtype);
		$criteria->compare('hit',$this->hit);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('page_name',$this->page_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('fkey',$this->fkey,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('shares',$this->shares);
		$criteria->compare('primary',$this->primary);
		$criteria->compare('price',$this->price);
		$criteria->compare('price_old',$this->price_old);
        $criteria->compare('qty',$this->qty);
		$criteria->compare('price_entering',$this->price_entering);
		$criteria->compare('code_3d',$this->code_3d, true);

		//Если задан ID родительской категории, то нужно так же показывать товары дочерних категорий
		if (!empty($this->filterData)) {
			/** @var $catalog CatalogRubrics */
			$catalog = CatalogRubrics::model()->findByPk((int) $this->filterData);
			if (!empty($catalog)) {
				$branch = CatalogRubrics::getBranch($catalog->left_key, $catalog->right_key);
				foreach($branch as $branchRow) {
					$ids[] = $branchRow->id;
				}
				if (!empty($ids)) {
					$criteria->addInCondition('parent_id', $ids);
				}
			}
		}

        return $criteria;

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CatalogElements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getProductUrl($modelElements){

		$url = '';
		//Ссылка на товар
		$modelRubrics = CatalogRubrics::model()->findByPk($modelElements->parent_id);
		if ($modelRubrics){
			$i = $modelRubrics->id;
			$array = array();
			do {
				$model = CatalogRubrics::model()->findByPk((int)$i);
				if(isset($model->id))$array[] = $model->id;
			} while ($model->level!=1);

			$array = array_reverse($array);
			unset($array[0]);
			$base_patch = "";
			foreach ($array as $value){
				$base_patch .= '/'.(CatalogRubrics::model()->findByPk((int)$value)->url);
			}
			$url = $base_patch;
		}
		return $url.'/'.$modelElements->id;
    }

	public static function fn__get_filters($data,$id_category)
	{
		$id_category = intval($id_category);
		
		
		if ($id_category<0)
		{
			return $data;
		}
		elseif(!$id_category)
		{
			$model = Yii::app()->db->createCommand()
				->select('min(`price`) as min')
				->from('{{catalog_elements}}')
				->where("status=1")
				->queryRow();
			$data['price_min'] = intval($model['min']);

			$model = Yii::app()->db->createCommand()
				->select('max(`price`) as max')
				->from('{{catalog_elements}}')
				->where("status=1")
				->queryRow();
			$data['price_max'] = intval($model['max']);
			
			
		}
		else
		{
			$model_category =  CatalogRubrics::model()->find('id='.$id_category);
			$model = Yii::app()->db->createCommand()
				->select('min(`price`) as min')
				->from('{{catalog_elements}}')
				->where("
				status=1
					AND
				parent_id IN 
					(
						SELECT 
							`id` 
						FROM 
							`tbl_catalog_rubrics`
						WHERE
							`left_key` >=".$model_category->left_key." 
							AND 
							`right_key` <= ".$model_category->right_key."
					)
				")
				->queryRow();
			$data['price_min'] = intval($model['min']);

			$model = Yii::app()->db->createCommand()
				->select('max(`price`) as max')
				->from('{{catalog_elements}}')
				->where("
				status=1
					AND
				parent_id IN 
					(
						SELECT 
							`id` 
						FROM 
							`tbl_catalog_rubrics`
						WHERE
							`left_key` >=".$model_category->left_key." 
							AND 
							`right_key` <= ".$model_category->right_key."
					)
				")
				->queryRow();
			$data['price_max'] = intval($model['max']);
		}
		
		$data['price_cur_min'] = $data['price_min'];
		$data['price_cur_max'] = $data['price_max'];
		
		

		
		
		$data['filters']['price_min'] = $data['price_min'];
		$data['filters']['price_max'] = $data['price_max'];
		if (isset($_COOKIE['filters']))
		{
			$filters_array = unserialize($_COOKIE['filters']);
			
			if (is_array($filters_array))
			{
				if (isset($filters_array['price_min'])&&isset($filters_array['price_max']))
				{
					if (
							 ($filters_array['price_min']>=$data['price_min']) &&
							 ($filters_array['price_min']<=$data['price_max'])
						 )
					{
						$data['filters']['price_min'] = $filters_array['price_min'];
					}

					if (
							 ($filters_array['price_max']<=$data['price_max']) &&
							 ($filters_array['price_max']>=$data['price_min'])
						 )
					{
						$data['filters']['price_max'] = $filters_array['price_max'];
					}
				}
				
				$filters_actual = Yii::app()->db->createCommand()
					->selectDistinct('*')
					->from('{{catalog_filters}}')
					->where("charsname IN 
										(
											SELECT DISTINCT
												name 
											FROM 
												tbl_catalog_chars
											WHERE
												parent_id IN 
													(SELECT `id` FROM `tbl_catalog_elements` WHERE status = 1) 
												AND
													(`type_scale` = 1 OR `type_scale` = 2)
												AND
													`type_parent` = 2
												AND 
													status = 1
										)")
					->queryAll();
				//print_r($filters_array); exit;
				foreach ($filters_actual as $filters_actual_item)
				{
					if (isset($filters_array['filter_'.$filters_actual_item['id']]))
					{
						$data['filters'][$filters_actual_item['id']][$filters_actual_item['charsname']] = $filters_array['filter_'.$filters_actual_item['id']];
					}
				}
			}

		}
		return $data;
	}
	
	
	// Аналог функции mysql_real_escape_string(), но без подключения к MySQL
//******************************************************************************
	public function sql_valid($data) {
		$data = str_replace("\\", "\\\\", $data);
		$data = str_replace("'", "\'", $data);
		$data = str_replace('"', '\"', $data);
		$data = str_replace("\x00", "\\x00", $data);
		$data = str_replace("\x1a", "\\x1a", $data);
		$data = str_replace("\r", "\\r", $data);
		$data = str_replace("\n", "\\n", $data);
		return($data); 
    }
//******************************************************************************



	protected function beforeSave() {
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {

				//Увеличиваем order_id
				$model = new CatalogElements();
				$criteria = new CDbCriteria;
				$criteria->select='MAX(order_id) AS order_id';
				$criteria->condition = 'parent_id = '.(int)$this->parent_id;
				$order_id = 0;
				if( $order_id = $model->model()->find($criteria) ) { $order_id = $order_id['order_id'] + 1;  }
				$this->order_id = $order_id;

			}
		}
		return true;
	}

    /**
     * Получить количество элементов в узле
     */
    public static function getCount_by_rubric($id_category) {
        $model = Yii::app()->db->createCommand()
            ->select('count(id) as count')
            ->from('{{catalog_elements}}')
            ->where('parent_id='.(int)$id_category)
            ->queryRow();
        $result =current($model);   //вычитае из резуьтата сам узел
        return $result;
    }

	/**
	 * Получение количества записей в категории
	 *
	 * @param $category
	 * @return int|mixed
	 */
	public static function getTotalCountElement($category) {
		$total = 0;
		if (is_int($category)) {
			$category = CatalogRubrics::model()->findByPk($category);
		}

		if (!empty($category)) {
			$branch = CatalogRubrics::getBranch($category->left_key, $category->right_key);

			foreach($branch as $branchRow) {
				$ids[] = $branchRow->id;
			}

			if (!empty($ids)) {
				$total = Yii::app()->db->createCommand()
							->select('COUNT(*)')
							->from(CatalogElements::model()->tableName())
							->where(array('in', 'parent_id', $ids))
							->queryScalar();
			}
		}

		return $total;
	}
}
