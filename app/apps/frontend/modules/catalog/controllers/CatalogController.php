<?php

class CatalogController extends Controller
{

    public $layout='//layouts/main';


	/*
		Функция для дыстрого заказа в 1 клик товара
	*/
	public function actionAjaxfastorder($id)
	{
		$ret = array();
		$ret['error'] = '';
		
		$id = intval($id);
		if (!$id)
		{
			$ret['error'] = 'Неверный ID товара';
			echo json_encode($ret); 
			exit;
		}
		
		$model_catalog_element = CatalogElements::model()->find("id=".$id);
		if (!$model_catalog_element)
		{
			$ret['error'] = 'Товар '.$id.' не существует';
			echo json_encode($ret); exit;
		}
		
		$_name = (isset($_POST['name'])?$_POST['name']:'');
		$_phone = (isset($_POST['phone'])?$_POST['phone']:'');
		$_email = (isset($_POST['email'])?$_POST['email']:'');
		
		if (strlen($_name)<3)
		{
			$ret['error'] = 'Имя не может быть короче 3 символов';
			echo json_encode($ret); exit;
		}
		
		if (strlen($_phone)<6)
		{
			$ret['error'] = 'Телефон не может быть короче 6 символов';
			echo json_encode($ret); exit;
		}
		
		if (strlen($_email)<6)
		{
			$ret['error'] = 'Email не может быть короче 6 символов';
			echo json_encode($ret); exit;
		}
		

		$message = "На сайте ".$_SERVER['HTTP_HOST']." сделан заказ с помощью формы быстрого заказа"."\r\n".
				      "Имя: ".$_name."\r\n".
				      "Email: ".$_email."\r\n".
				      "Телефон: ".$_phone."\r\n".
				      "Товар: ".$model_catalog_element->name."\r\n".
				      "Цена товара: ".$model_catalog_element->price."\r\n".
				      "Страница товара: http://".
				      $_SERVER['HTTP_HOST'].'/catalog/'.$model_catalog_element->id."\r\n".
				      "Свяжитесь с клиентом для уточнения деталей заказа.";
				  
		mail(ADMIN_EMAIL_NOTIFICATION, 'Cделан быстрый заказ на сайте '.$_SERVER['HTTP_HOST'], $message);
		$ret['confirm'] = 'OK';
		echo json_encode($ret); exit;
	}







	//ToDo Не забыть про 404 страницу
	public function actionIndex($param = null){
		if (SiteModuleSettings::model()->find('site_module_id = 4 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
		$data = array();
		$filters='';

		if ($_GET['id'] && count(explode("/", $_GET['id']))>1){
			$this->actionList(Yii::app()->request->getQuery('id'));
			exit();
		}


		//Титл и SEO
		$this->pageTitle =  'Каталог продукции - ' . $this->pageTitle;
		foreach ( explode("/", ( parse_url(Yii::app()->request->requestUri, PHP_URL_PATH ))) as $url  ){
			$this->setSEO($url);
		}


		$data = CatalogElements::fn__get_filters($data,0);


		$where = "status=1 AND `price`>=".$data['filters']['price_min']." AND `price`<=".$data['filters']['price_max']."";
		//$where = 'status=1';

//==============================================================================
		$checks_arr_str = array();
		$checks_arr_str_nofilter = array();
		if ((isset($data['filters']))&&(is_array($data['filters']))&&(count($data['filters'])))
		{
			foreach ($data['filters'] as $id_filter => $filter_values)
			{
				if (is_array($filter_values))
				{
					foreach ($filter_values as $_filter_charsname => $filter_values_array)
					{
						if (isset($filter_values_array['checkbox']))
						{
							foreach ($filter_values_array['checkbox'] as $checkbox_value)
							{
								$checks_arr_str[]="
								(
									`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
										AND 
									`scale` = '".CatalogElements::sql_valid($checkbox_value)."' 
										AND
									`type_parent` = 2
								)";
								$checks_arr_str[]="
								(
									`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
										AND 
									`scale` LIKE '%|".CatalogElements::sql_valid($checkbox_value)."' 
										AND
									`type_parent` = 2
								)";
								$checks_arr_str[]="
								(
									`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
										AND 
									`scale` LIKE '".CatalogElements::sql_valid($checkbox_value)."|%' 
										AND
									`type_parent` = 2
								)";
								$checks_arr_str[]="
								(
									`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
										AND 
									`scale` LIKE '%|".CatalogElements::sql_valid($checkbox_value)."|%' 
										AND
									`type_parent` = 2
								)";
							}
						}
					}
				}
			}
			
			if (count($checks_arr_str))
			{
				$_where = implode(' OR ',$checks_arr_str);
				$where.= "
					AND
						`id` IN (
							SELECT `parent_id` FROM `tbl_catalog_chars` WHERE ".$_where."
						)
					";
			}




			$checks_arr_str = array();
			foreach ($data['filters'] as $id_filter => $filter_values)
			{
				if (is_array($filter_values))
				{
					foreach ($filter_values as $_filter_charsname => $filter_values_array)
					{
						if (isset($filter_values_array['scroll']['usefilter']))
						{
							if (
									 (isset($filter_values_array['scroll'])) &&
									 (isset($filter_values_array['scroll']['min'])) &&
									 (isset($filter_values_array['scroll']['max'])) 
									)
							{
								$checks_arr_str[]="
									(
										`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
											AND 
										`scale` >= ".intval($filter_values_array['scroll']['min'])." 
											AND
										`type_parent` = 2
									)";
							
								$checks_arr_str[]="
									( 
											`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
										AND
											`scale` <= ".intval($filter_values_array['scroll']['max'])." 
										AND
											`type_parent` = 2
									)
									";
								if (isset($filter_values_array['scroll']['nofilter']))
								{
									$checks_arr_str_nofilter[]="
										OR `id` NOT IN (
													SELECT 
														`parent_id` 
													FROM 
														`tbl_catalog_chars` 
													WHERE 
														`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
													AND
														`type_parent` = 2
													)
										";
								}
							}
						}
					}
				}
			}
			
			if (count($checks_arr_str))
			{
				$_where = implode(' OR ',$checks_arr_str);
				$where.= "
					AND
					(
						`id` IN (
							SELECT `parent_id` FROM `tbl_catalog_chars` WHERE ".$_where."
						)
						".implode(' ',$checks_arr_str_nofilter)."
					)
					";
			}
		}
//==============================================================================




		
		$model = Yii::app()->db->createCommand()
			->select('count(id) as count')
			->from('{{catalog_elements}}')
			->where($where)
			->queryRow();
		$count = ((current($model))-1);   //Вычитаем из результата сам узел
		
		$criteria = new CDbCriteria();
    $pages=new CPagination($count);
    // элементов на страницу
    $pages->pageSize=12;
    $pages->applyLimit($criteria);
    $data['pages']=$pages;

    


		//==========================================================================
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
									
								)
								AND 
							status = 1
								AND
							id IN 
								(
									SELECT 
										id_filter
									FROM
										tbl_catalog_filters_in_category
									WHERE
										id_catalog_rubrics = 1
								)
								ORDER BY position DESC
								")
			->queryAll();
		$data['filters_actual'] =$filters_actual;




		$chars_actual = Yii::app()->db->createCommand()
			->select('*')
			->from('{{catalog_chars}}')
			->where("	parent_id IN 
									(SELECT `id` FROM `tbl_catalog_elements` WHERE status = 1) 
								AND
									(`type_scale` = 1 OR `type_scale` = 2)
								AND
									`type_parent` = 2
								AND 
									status = 1
								AND
								name IN 
									(SELECT `charsname` FROM `tbl_catalog_filters` WHERE `status` = 1)")
			->queryAll();
		$data['chars_actual'] =$chars_actual;
		$params['data']=$data;
		$filters=$this->widget('application.apps.frontend.components.Filters',array('params'=>$params), TRUE); 
		$data['filters'] = $filters;
		//==========================================================================


		$start = ((isset($_GET['page']))?intval($_GET['page']):0);
		$model_elements = CatalogElements::model()->findAll(array(
    'condition' => $where,
    'order' => 'order_id',
    'offset' => $start*12,
    'limit' => 12,
		));
		//
		$data['model_elements']=$model_elements;
		$this->render('index', $data);
	}


	public function actionElement($param){
		$this->actionList($param);
	}





	public function actionList($param)
	{
		if (SiteModuleSettings::model()->find('site_module_id = 4 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
		$filters='';
		$pages=false;
		

		//разбираем URL
		$paramArr = explode("/", $param);
		$url = array_pop($paramArr);

		//Ищем в каталогах


		if ( $modelRubric = CatalogRubrics::model()->find('url LIKE ("'.$url.'")') )
		{
			$this->setSEO(Yii::app()->request->requestUri, 'Каталог продукции', $modelRubric);
			$data = array();
			//$modelRubric =  CatalogRubrics::model()->find('url LIKE ("'.$url.'")');

			if (!$modelRubric)
			{

				//Ищем в товарах


				throw new CHttpException(404,'The page can not be found.'); 
			}
			
			$data  = CatalogElements::fn__get_filters($data,$modelRubric->id);
			$where = "
					parent_id IN 
						(
							SELECT 
								`id` 
							FROM 
								`tbl_catalog_rubrics`
							WHERE
								`left_key` >=".$modelRubric->left_key." 
								AND 
								`right_key` <= ".$modelRubric->right_key."
						)
					AND 
						status=1 
					AND 
						`price`>=".$data['filters']['price_min']." 
					AND 
						`price`<=".$data['filters']['price_max']."";








//==============================================================================
		$checks_arr_str = array();
		$checks_arr_str_nofilter = array();
		if ((isset($data['filters']))&&(is_array($data['filters']))&&(count($data['filters'])))
		{
			foreach ($data['filters'] as $id_filter => $filter_values)
			{
				if (is_array($filter_values))
				{
					foreach ($filter_values as $_filter_charsname => $filter_values_array)
					{
						if (isset($filter_values_array['checkbox']))
						{
							foreach ($filter_values_array['checkbox'] as $checkbox_value)
							{
								$checks_arr_str[]="
								(
									`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
										AND 
									`scale` = '".CatalogElements::sql_valid($checkbox_value)."' 
										AND
									`type_parent` = 2
								)";
								$checks_arr_str[]="
								(
									`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
										AND 
									`scale` LIKE '%|".CatalogElements::sql_valid($checkbox_value)."' 
										AND
									`type_parent` = 2
								)";
								$checks_arr_str[]="
								(
									`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
										AND 
									`scale` LIKE '".CatalogElements::sql_valid($checkbox_value)."|%' 
										AND
									`type_parent` = 2
								)";
								$checks_arr_str[]="
								(
									`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
										AND 
									`scale` LIKE '%|".CatalogElements::sql_valid($checkbox_value)."|%' 
										AND
									`type_parent` = 2
								)";
							}
						}
					}
				}
			}
			
			if (count($checks_arr_str))
			{
				$_where = implode(' OR ',$checks_arr_str);
				$where.= "
					AND
						`id` IN (
							SELECT `parent_id` FROM `tbl_catalog_chars` WHERE ".$_where."
						)
					";
			}





			foreach ($data['filters'] as $id_filter => $filter_values)
			{
				if (is_array($filter_values))
				{
					foreach ($filter_values as $_filter_charsname => $filter_values_array)
					{
						if (isset($filter_values_array['scroll']['usefilter']))
						{
							if (
									 (isset($filter_values_array['scroll'])) &&
									 (isset($filter_values_array['scroll']['min'])) &&
									 (isset($filter_values_array['scroll']['max'])) 
									)
							{
								$checks_arr_str[]="
									(
										`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
											AND 
										`scale` >= ".intval($filter_values_array['scroll']['min'])." 
											AND
										`type_parent` = 2
									)";
							
								$checks_arr_str[]="
									( 
											`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
										AND
											`scale` <= ".intval($filter_values_array['scroll']['max'])." 
										AND
											`type_parent` = 2
									)
									";
								if (isset($filter_values_array['scroll']['nofilter']))
								{
									$checks_arr_str_nofilter[]="
										OR `id` NOT IN (
													SELECT 
														`parent_id` 
													FROM 
														`tbl_catalog_chars` 
													WHERE 
														`name` = '".CatalogElements::sql_valid($_filter_charsname)."' 
													AND
														`type_parent` = 2
													)
										";
								}
							}
						}
					}
				}
			}
			
			if (count($checks_arr_str))
			{
				$_where = implode(' OR ',$checks_arr_str);
				$where.= "
					AND
					(
						`id` IN (
							SELECT `parent_id` FROM `tbl_catalog_chars` WHERE ".$_where."
						)
						".implode(' ',$checks_arr_str_nofilter)."
					)
					";
			}
		}
//==============================================================================

			

			
			$model = Yii::app()->db->createCommand()
				->select('count(id) as count')
				->from('{{catalog_elements}}')
				->where($where)
				->queryRow();
			$count = ((current($model))-1);   //вычитае из резуьтата сам узел
			$criteria = new CDbCriteria();
			$pages=new CPagination($count);
			// элементов на страницу
			$pages->pageSize=12;
			$pages->applyLimit($criteria);
			$data['pages']=$pages;
			$start = ((isset($_GET['page']))?intval($_GET['page']):0);
			
			
			//получаем товары

			$model = CatalogElements::model()->findAll(array(
				'condition' => $where,
				'order' => 'order_id',
				'offset' => $start*12,
				'limit' => 12,
				));
			$data['model'] = $model;
			$data['modelRubric'] = $modelRubric;
			$data['param'] = $param;
			

			$render = 'list';
			
			//==========================================================================
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
									)
									AND 
								status = 1
									AND
								id IN 
									(
										SELECT 
											id_filter
										FROM
											tbl_catalog_filters_in_category
										WHERE
											id_catalog_rubrics = ".$modelRubric->id."
									)
									
									ORDER BY position DESC
									")
				->queryAll();
			$data['filters_actual'] =$filters_actual;




			$chars_actual = Yii::app()->db->createCommand()
				->select('*')
				->from('{{catalog_chars}}')
				->where("	parent_id IN 
										(SELECT `id` FROM `tbl_catalog_elements` WHERE 
											parent_id IN 
												(
													SELECT 
														`id` 
													FROM 
														`tbl_catalog_rubrics`
													WHERE
														`left_key` >=".$modelRubric->left_key."
														AND 
														`right_key` <= ".$modelRubric->right_key."
												)
											AND 
												status=1 
										) 
									AND
										(`type_scale` = 1 OR `type_scale` = 2)
									AND
										`type_parent` = 2
									AND 
										status = 1
									AND
									name IN 
										(SELECT `charsname` FROM `tbl_catalog_filters` WHERE `status` = 1)")
				->queryAll();
			$data['chars_actual'] =$chars_actual;
			$params['data']=$data;
			$filters=$this->widget('application.apps.frontend.components.Filters',array('params'=>$params), TRUE); 
			$data['filters'] = $filters;
			//==========================================================================


		}
		//Ищем в товарах
		elseif ( $model = CatalogElements::model()->find('url LIKE "'.$url.'" OR id = '.(int)$url) )
		{
			$this->setSEO(Yii::app()->request->requestUri, 'Каталог продукции', $model);
			$modelRubric = null;
			//$model = CatalogElements::model()->findByPk((int)$url);
			if (!$model)
			{
				throw new CHttpException(404,'The page can not be found.'); 
			}
			$modelChars = CatalogChars::model()->findAll('parent_id='.$model->id.' AND status = 1');
			$render = 'show';
			$data['modelChars'] = $modelChars;
			$data['model'] = $model;
			$data['modelImages'] = CatalogElementsImages::model()->findAll('elements_id = '.$model->id);
		}
		//Ищем в URL как катаог
		elseif (Pages::model()->find('url LIKE "'.$url.'"')){
			$this->redirect('/'.$url);
		}
		//Ничего не нашли - на 404
		else {
			throw new CHttpException(404,'The page can not be found.');
		}


		//SEO
		if (isset($paramArr[0]) && !empty($paramArr[0])) 
		{
			if ( $modelRubricSEO =  CatalogRubrics::model()->find('url LIKE ("'.$paramArr[0].'")') )
			{
				if (isset($modelRubricSEO->meta_title) && !empty($modelRubricSEO->meta_title))
				{
					$this->pageMetaTitle = $modelRubricSEO->meta_title; 
				}
				if (isset($modelRubricSEO->meta_keywords) && !empty($modelRubricSEO->meta_keywords))
				{
					$this->pageKeywords = $modelRubricSEO->meta_keywords;
				}
				if (isset($modelRubricSEO->meta_description) && !empty($modelRubricSEO->meta_description))
				{
					$this->pageDescription = $modelRubricSEO->meta_description;
				}
			}
		}

		$this->render($render, $data);
/*
		$this->render($render, array('model'       =>$model, 
				                         'modelRubric' =>$modelRubric, 
				                         'modelChars'  =>$modelChars, 
				                         'filters'     =>$filters, 
				                         'param'       =>$param,
				                         'pages'       =>$pages));
*/
	}



}
