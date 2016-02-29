<?php

class CatalogController extends Controller
{









	public function actionFilters($id=null){

		
		$action = (isset($_GET['action'])?$_GET['action']:'list');
		if (!in_array($action,array('list','create','update','delete','chpos')))
		{
			$action = 'list';
		}
		$data['action'] = $action;
		
		
		
		
		if ($action=='list')
		{
			$this->breadcrumbs = array('Фильтры'=>array('/catalog/catalog/filters','Список фильтров'));
			
			if ((isset($_GET['catid']))&&(intval($_GET['catid'])))
			{
				$model_filters = CatalogFIlters::model()->findAll(array(
				"select"=>"t.*, tbl_catalog_filters_in_category.position as position",
				'join' => "LEFT JOIN tbl_catalog_filters_in_category ON 
									 (
									 	tbl_catalog_filters_in_category.id_filter = t.id AND
									 	tbl_catalog_filters_in_category.id_catalog_rubrics = ".intval($_GET['catid'])."
									 )", 
				'condition' =>"
				t.id IN (
					SELECT id_filter
					FROM tbl_catalog_filters_in_category 
					WHERE id_catalog_rubrics = ".intval($_GET['catid'])."
					)
				ORDER BY tbl_catalog_filters_in_category.position DESC "));
			}
			else
			{
				$model_filters = CatalogFIlters::model()->findAll(array(
				'condition' =>"1 ORDER BY position DESC"));
			}
			$data['model_filters'] = $model_filters;
			
			//print_r($model_filters);
			
			$catalog_chars_names = Yii::app()->db->createCommand()
				->selectDistinct('name')
				->from('{{catalog_chars}}')
				->where("name NOT IN (SELECT charsname FROM {{catalog_filters}})")
				->queryAll();
			$data['allow_add'] = count($catalog_chars_names);
			
			
			$model_CatalogRubrics = CatalogRubrics::model()->findAll();
			$categs_array = array();
			$categs_array[0] = array('name'=>'Все фильтры','parent_id'=>0);
			foreach ($model_CatalogRubrics as $model_CatalogRubrics_item)
			{
				$categs_array[$model_CatalogRubrics_item->id] =array(
					'parent_id'=>$model_CatalogRubrics_item->parent_id,
					'name'=>$model_CatalogRubrics_item->name,
				); 
			}
			$data['categs_array'] = $categs_array;
		}






		if ($action=='chpos')
		{
			$do = (isset($_GET['do'])?$_GET['do']:'inc');
			$catid = (isset($_GET['catid'])?intval($_GET['catid']):0);
			if (!in_array($do,array('inc','dec')))
			{
				$do = 'inc';
			}
			$id = (isset($_GET['id'])?$_GET['id']:0);
			if (!$catid)
			{
				$model = CatalogFIlters::model()->find('id = '.intval($id));
				if ($model)
				{
					if ($do == 'inc')
					{
						$model->position = $model->position+1;
					}
					else
					{
						if (($model->position-1)>=0)
						{
							$model->position = $model->position-1;
						}
					}
					$model->save();
					$this->redirect(array('filters'));
				}
			}
			else
			{
				$model = CatalogFIltersInCategory::model()->find('id_filter = '.intval($id).' AND id_catalog_rubrics = '.$catid);
				if ($model)
				{
					if ($do == 'inc')
					{
						$model->position = $model->position+1;
					}
					else
					{
						if (($model->position-1)>=0)
						{
							$model->position = $model->position-1;
						}
					}
					$model->save();
					$this->redirect(array('filters?catid='.$catid));
				}
			}
		}









		if ($action=='create')
		{
			$this->breadcrumbs = array('Фильтры'=>array('/catalog/catalog/filters'),'Новая запись');
			
			$catalog_chars_names = Yii::app()->db->createCommand()
				->selectDistinct('name')
				->from('{{catalog_chars}}')
				->where('name NOT IN (SELECT charsname FROM {{catalog_filters}})')
				->queryAll();
			$names_chars = array();
			foreach ($catalog_chars_names as $item)
			{
				$names_chars[$item['name']] = $item['name'];
			}
			$data['names_chars'] = $names_chars;
			
			
			
			$model_CatalogRubrics = CatalogRubrics::model()->findAll();
			$categs_array = array();
			foreach ($model_CatalogRubrics as $model_CatalogRubrics_item)
			{
				$categs_array[$model_CatalogRubrics_item->id] =array(
					'parent_id'=>$model_CatalogRubrics_item->parent_id,
					'name'=>$model_CatalogRubrics_item->name,
				); 
			}
			$data['categs_array'] = $categs_array;
			
			
			
			$model_filters_in_category = new CatalogFIltersInCategory;
			$data['model_filters_in_category'] = $model_filters_in_category;
			
			
			
			$model = new CatalogFIlters;
			$data['model'] = $model;
			if(isset($_POST['CatalogFIlters']))
			{
				$model->attributes = $_POST['CatalogFIlters'];
				if ($model->validate())
				{
					$model->save();
					if (
					     (isset($_POST['CatalogFIltersInCategory']['id_catalog_rubrics']))&&
					     (is_array($_POST['CatalogFIltersInCategory']))
					   )
					{
						foreach ($_POST['CatalogFIltersInCategory']['id_catalog_rubrics'] as $id_category)
						{
							
							$model_filters_in_category = new CatalogFIltersInCategory;
							$model_filters_in_category->id_catalog_rubrics = intval($id_category);
							$model_filters_in_category->id_filter = $model->id;
							if ($model_filters_in_category->validate())
							{
								$model_filters_in_category->save();
							}
						}
					}
					$this->redirect(array('filters'));
				}
			}
		}








		if ($action=='update')
		{
			$id = (isset($_GET['id'])?$_GET['id']:0);
			$this->breadcrumbs = array('Фильтры'=>array('/catalog/catalog/filters'),'Редактировать запись');
			$model = CatalogFIlters::model()->find('id = '.intval($id));
			if ($model)
			{
				$catalog_chars_names = Yii::app()->db->createCommand()
					->selectDistinct('name')
					->from('{{catalog_chars}}')
					->where("name NOT IN (SELECT charsname FROM {{catalog_filters}}) 
					         OR 
					         name IN (SELECT charsname FROM {{catalog_filters}} WHERE id =  '".$model->id."')")
					->queryAll();
				$names_chars = array();
				foreach ($catalog_chars_names as $item)
				{
					$names_chars[$item['name']] = $item['name'];
				}
				$data['names_chars'] = $names_chars;
				$data['model'] = $model;
				
				
				$model_CatalogRubrics = CatalogRubrics::model()->findAll();
				$categs_array = array();
				foreach ($model_CatalogRubrics as $model_CatalogRubrics_item)
				{
					$categs_array[$model_CatalogRubrics_item->id] =array(
						'parent_id'=>$model_CatalogRubrics_item->parent_id,
						'name'=>$model_CatalogRubrics_item->name,
					); 
				}
				$data['categs_array'] = $categs_array;
				
				
				$model_filters_in_category = CatalogFIltersInCategory::model()->findAll('id_filter = '.intval($id));
				$categs_array_selected = array();
				$categs_array_selected_items = array();
				if (($model_filters_in_category)&&(is_array($model_filters_in_category)))
				{
					foreach ($model_filters_in_category as $model_filters_in_category_item)
					{
						$categs_array_selected[$model_filters_in_category_item->id_catalog_rubrics] = array('selected'=>'selected'); 
						$categs_array_selected_items[]=$model_filters_in_category_item->id_catalog_rubrics;
					}
				}
				$data['categs_array_selected'] = $categs_array_selected;
				$data['model_filters_in_category'] = new CatalogFIltersInCategory;
				
				if(isset($_POST['CatalogFIlters']))
				{
					$model->attributes = $_POST['CatalogFIlters'];
					if ($model->validate())
					{
						$model->save();
						$new_selected_items = array();
						if (
							   (isset($_POST['CatalogFIltersInCategory']['id_catalog_rubrics']))&&
							   (is_array($_POST['CatalogFIltersInCategory']))
							 )
						{
							
							// Добавляем отсутствующие элементы
							//----------------------------------------------------------------
							foreach ($_POST['CatalogFIltersInCategory']['id_catalog_rubrics'] as $id_category)
							{
								if (in_array(intval($id_category),$categs_array_selected_items))
								{
									
								}
								else
								{
									$model_finc = new CatalogFIltersInCategory;
									$model_finc->id_catalog_rubrics = intval($id_category);
									$model_finc->id_filter = $model->id;
									if ($model_finc->validate())
									{
										$model_finc->save();
									}
								}
								$new_selected_items[]=$id_category;
							}
							//----------------------------------------------------------------
						}
						
						
						// Удаляем отсутствующие ривязки к категориям
						foreach ($categs_array_selected_items as $value1)
						{
							if (!in_array($value1,$new_selected_items))
							{
								$model1 = CatalogFIltersInCategory::model()->find('id_catalog_rubrics = '.intval($value1).' AND id_filter = '.$model->id);
								if ($model1)
								{
									$model1->delete();
								}
							}
						}
						
						//$this->redirect(array('filters?action=update&id='.$model->id));
						
						$catid = (isset($_GET['catid'])?intval($_GET['catid']):0);
						if ($catid)
						{
							$this->redirect(array('filters?catid='.$catid));
						}
						else
						{
							$this->redirect(array('filters'));
						}
					}
				}
			}
		}
		
		
		
		
		if ($action=='delete')
		{
			$id = (isset($_GET['id'])?$_GET['id']:0);
			$model = CatalogFIlters::model()->find('id = '.intval($id));
			if ($model)
			{
				$model->delete();
			}
			$this->redirect(array('filters'));
		}

		$this->render('filters',$data);
	}

















































    public function actionListgroup($id=null){

        $this->breadcrumbs = array(
            'Каталоги'=>array('/catalog/catalog/listgroup'),
        );

        set_time_limit(0);
        //получаем URL
        $base_patch = SITE_NAME_FULL.'/catalog';
        if ( !empty($id) ){
            $model = CatalogRubrics::model()->findByPk((int)$id);
            if ($model){
                $i = (int)$id;
                $array = array();
                do {
                    $model = CatalogRubrics::model()->findByPk((int)$i);
                    if(isset($model->id))$array[] = $model->id;
                    $i = (int)$model->parent_id;
                } while ($i != 0);
                $array = array_reverse($array);
                //Убираем level=1 раздел
                unset($array[0]);
                foreach ($array as $value){
                    $base_patch .= '/'.(CatalogRubrics::model()->findByPk((int)$value)->url);
                }
            }
        }



        if (!empty($id)){

            $model = CatalogRubrics::model()->findByPk((int)$id);
            $root = CatalogRubrics::getRoot($model);
            $category = CatalogRubrics::model()->findByPk((int)$id); //Получаем нужный узел
            $descendants = $category->descendants(1)->findAll();

        }
        else {
            $model = new CatalogRubrics;
            $category = CatalogRubrics::getRoot($model);
            $category = CatalogRubrics::model()->findByPk($category->id);
            $descendants = $category->descendants(1)->findAll();
            $root = "";
        }

        $this->render('listgroup',array(
            'root' => $root,
            'categories' => $descendants,
            'base_patch' => $base_patch,
        ));
    }


    public function actionCreate($id = null)
    {
        $this->breadcrumbs = array(
            'Каталоги'=>array('/catalog/catalog/listgroup'),
            'Новая запись'
        );

        $model = new CatalogRubrics;
        $root = CatalogRubrics::getRoot($model);
        $descendants = $root->descendants()->findAll($root->id);


        if(isset($_POST['CatalogRubrics']))
        {

            $model = new CatalogRubrics;
            $parent_id = (int)$_POST['CatalogRubrics']['parent_id'];
            $root = CatalogRubrics::model()->findByPk($parent_id);
            $model->attributes = $_POST['CatalogRubrics'];

            $model->meta_title = $_POST['CatalogRubrics']['meta_title'];
            $model->meta_keywords = $_POST['CatalogRubrics']['meta_keywords'];
            $model->meta_description = $_POST['CatalogRubrics']['meta_description'];

            $model->imagefile = CUploadedFile::getInstance($model,'imagefile');
            if (isset($model->imagefile)){$ext=pathinfo($model->imagefile);$model->image = $ext['extension'];}

            if (!$root){
                //Создаю родительскую категорию
                $result = CatalogRubrics::getRoot(new CatalogRubrics);
                $model->id = (int)$result->id;
            }
            else {
                $model->appendTo($root);
            }

            if(!empty($model->id)){

                if (isset($model->imagefile) && $modelSettings = SiteModuleSettings::model()->find('site_module_id = 4')){
                    $filename = $model->id.'.'.$model->image;
                    $filepatch = '/../uploads/filestorage/catalog/rubrics/';
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );

                    //Обработка изображения
                    SiteModuleSettings::model()->chgImgModel($modelSettings, 'GD', 1,$model->id);
                }
                
                $this->redirect(array('listgroup'));
            }
        }

        $this->render('form',array(
            'model'=>$model,
            'root' => $root,
            'categories' => $descendants,
            'id' => null,
        ));
    }

    public function actionUpdate($id)
    {

        $this->breadcrumbs = array(
            'Каталоги'=>array('/catalog/catalog/listgroup'),
            'Редактирование'
        );

        $model = new CatalogRubrics;
        $root = CatalogRubrics::getRoot($model);
        $descendants = $root->descendants()->findAll($root->id);

        $model = $this->loadModel($id);

        if(isset($_POST['CatalogRubrics']))
        {

            $parent_id = (int)$_POST['CatalogRubrics']['parent_id'];
            $root = CatalogRubrics::model()->findByPk($parent_id);
            $model->attributes = $_POST['CatalogRubrics'];
            $model->parent_id = ($root->id == $parent_id)?$root->parent_id:$parent_id;

            $model->meta_title = $_POST['CatalogRubrics']['meta_title'];
            $model->meta_keywords = $_POST['CatalogRubrics']['meta_keywords'];
            $model->meta_description = $_POST['CatalogRubrics']['meta_description'];

            $model->imagefile = CUploadedFile::getInstance($model,'imagefile');
            if (isset($model->imagefile)){$ext=pathinfo($model->imagefile);$model->image = $ext['extension'];}


            $model->saveNode();

            if(!empty($model->id)){
                if (isset($model->imagefile) && $modelSettings = SiteModuleSettings::model()->find('site_module_id = 4') ){
                    $filename = $model->id.'.'.$model->image;
                    $filepatch = '/../uploads/filestorage/catalog/rubrics/';
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                    //Обработка изображения
                    SiteModuleSettings::model()->chgImgModel($modelSettings, 'GD', 1,$model->id);

                }
                // $this->redirect(array('listgroup','id'=>$model->id));

                //Возращаемся в каталог где были
                $this->redirect(array('update','id'=>$model->id));
                //$this->redirect(array('listgroup?id='.$model->parent_id));
            }


        }

        $this->render('form',array(
            'model'=> $model,
            'root' => $root,
            'categories' => $descendants,
            'id' => $id,
        ));
    }


    /** Товары: Список товаров  */
    public function actionListelement($filterData = null){

        $this->breadcrumbs = array(
            'Товары'=>array('/catalog/catalog/listelement'),
        );

        $model=new CatalogElements('search');
        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['CatalogElements'])){
            $model->attributes=$_GET['CatalogElements'];
        }

        $param = null;
        if ($model->serch_name_code){
            $param = 'name LIKE ("%'.$model->serch_name_code.'%") OR code LIKE ("'.(trim($model->serch_name_code)).'")';
        }

        if (!empty($filterData) && (int)$filterData>0){
            $param = ((!empty($param))?$param.' AND ':'').' parent_id in ('.(int)$filterData.') ';
        }

        //echo $param; die();
        $data['sort'] = array(
            'defaultOrder'=>'id DESC',
        );

        $data['Pagination'] = array(
            'PageSize'=>100,
        );
        if ($settingsModel = SiteModuleSettings::model()->find('site_module_id = 4')){
            $data['Pagination'] = array(
                'PageSize'=>(((int)$settingsModel->elements_page_admin>0)?$settingsModel->elements_page_admin:100),
            );
        }


        $provider=new CActiveDataProvider('CatalogElements', $data);

        $provider->criteria = $model->search($param);

        $root = CatalogRubrics::getRoot(new CatalogRubrics);
        $catalog = $root->descendants()->findAll($root->id);

        $this->render('listproduct',array(
            'model'=>$model,
            'provider'=>$provider,
            'catalog'=>$catalog,
        ));

    }


    /** Товары: Создание нового товара */
    public function actionCreateproduct()
    {
        $this->breadcrumbs = array(
            'Товары'=>array('/catalog/catalog/listelement'),
            'Новая запись'
        );

        $model = new CatalogElements;
        $root = CatalogRubrics::getRoot(new CatalogRubrics);
        $catalog = $root->descendants()->findAll($root->id);

        if(isset($_POST['CatalogElements']))
        {
            $model->attributes = $_POST['CatalogElements'];
            $model->page_name = $model->name;
            $model->imagefile = CUploadedFile::getInstance($model,'imagefile');
            if (isset($model->imagefile)){$ext=pathinfo($model->imagefile);$model->image = $ext['extension'];}
            if ($model->save()){

				$filepatch = '/../uploads/filestorage/catalog/elements/';
				
                if (isset($model->imagefile) && $modelSettings = SiteModuleSettings::model()->find('site_module_id = 4')){
                    $filename = $model->id.'.'.$model->image;
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                    //Обработка изображения
                    SiteModuleSettings::model()->chgImgModel($modelSettings, 'GD', 2,$model->id);
                }

				//загрузка дополнительных картинок
				$files = CUploadedFile::getInstances($model, 'imagefiles');
				if (!empty($files)){
					foreach($files as $file)
					{
						$modelImages = new CatalogElementsImages();
						$modelImages->elements_id = $model->id;
						$modelImages->image_name = $model->id.'_'.(md5((date('Y-m-d H:i:s')).'-'.rand()));
						$ext = pathinfo($file->getName());
						$modelImages->image = $ext['extension'];
						$modelImages->save();
						$uplod_file_url = YiiBase::getPathOfAlias('webroot').$filepatch.'/'.$modelImages->image_name.'.'.$modelImages->image;
						$uplod_file_url = $file->saveAs($uplod_file_url);
					}
					SiteModuleSettings::model()->chgImgagesCatalogModel($model->id, 'GD');
				}

               $this->redirect(array('updateproduct','id'=>$model->id));
            }
        }
        $this->render('formproduct',array(
            'model'=>$model,
            'root'=>$root,
            'catalog' => $catalog,
        ));

    }

    /** Товары: Редактирование товара */
    public function actionUpdateproduct($id)
    {
        $this->breadcrumbs = array(
            'Товары'=>array('/catalog/catalog/listelement'),
            'Редактирование'
        );

        $model = $this->loadModelProduct($id);
        $root = CatalogRubrics::getRoot(new CatalogRubrics);
        $catalog = $root->descendants()->findAll($root->id);
        if(isset($_POST['CatalogElements']))
        {
            $model->attributes = $_POST['CatalogElements'];
            $model->page_name = $model->name;
            $model->imagefile = CUploadedFile::getInstance($model,'imagefile');
            if (isset($model->imagefile)){$ext=pathinfo($model->imagefile);$model->image = $ext['extension'];}
            if ($model->save()){
				$filepatch = '/../uploads/filestorage/catalog/elements/';

                if (isset($model->imagefile) && $modelSettings = SiteModuleSettings::model()->find('site_module_id = 4')){
                    $filename = $model->id.'.'.$model->image;
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                    //Обработка изображения
                    SiteModuleSettings::model()->chgImgModel($modelSettings, 'GD', 2,$model->id);

                }

				//загрузка дополнительных картинок
				$files = CUploadedFile::getInstances($model, 'imagefiles');
				if (!empty($files)){
					foreach($files as $file)
					{
						$modelImages = new CatalogElementsImages();
						$modelImages->elements_id = $model->id;
						$modelImages->image_name = $model->id.'_'.(md5((date('Y-m-d H:i:s')).'-'.rand()));
						$ext = pathinfo($file->getName());
						$modelImages->image = $ext['extension'];
						$modelImages->save();
                        $uplod_file_url = YiiBase::getPathOfAlias('webroot').$filepatch.'/'.$modelImages->image_name.'.'.$modelImages->image;
						$uplod_file_url = $file->saveAs($uplod_file_url);
					}
					SiteModuleSettings::model()->chgImgagesCatalogModel($model->id, 'GD');
				}


                $this->redirect(array('updateproduct','id'=>$model->id));
            }
        }
        $this->render('formproduct',array(
            'model'=>$model,
            'root'=>$root,
            'catalog' => $catalog,
        ));

    }


	//Удаляет изображения  загруженные группой
	public function actionDeleteimages($id){
		if($model = CatalogElementsImages::model()->findByPk((int)$id)){
			$id = $model->elements_id;
			foreach (array('admin','small','medium','large') as $name){
				$url_to_file = YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/catalog/elements/'.$name.'-'.$model->image_name.'.'.$model->image;
				if (file_exists( $url_to_file )){
					unlink($url_to_file);
				}
			}
			$model->delete();
		}
		$this->redirect(array('updateproduct','id'=>$id));
	}







    
    public function actionDelete($id){
        $this->loadModel($id)->deleteNode();
        $this->redirect('listgroup');
    }

    /**  Удалить товар */
    public function actionDeleteproduct($id){
        $this->loadModelProduct($id)->delete();
        $this->redirect('listelement');
    }
    

    public function actionMove($id, $move){

        $model = $this->loadModel((int)$id);

        if ((int)$move == 1){
            //переместить вверх  - надо получить узел идущий выше $moveModel = $model->prev()->find();
            $moveModel = $model->prev()->find();
            $model->moveBefore($moveModel);
        } elseif ((int)$move == 2){
            //переместить ниже - получаем нижний узел  $nextSibling = $model->next()->find();
            $moveModel = $model->next()->find();
            $model->moveAfter($moveModel);
        }
        $this->redirect($_SERVER['HTTP_REFERER']);

    }


    public function actionAjax(){
        if (isset($_POST)){
        
					
						if (
							   (isset($_POST['arrscaleval'])) &&
							   (isset($_POST['arrscaleid'])) &&
							   (is_array($_POST['arrscaleval'])) &&
							   (is_array($_POST['arrscaleid'])) &&
							   (count($_POST['arrscaleval'])==count($_POST['arrscaleid']))
							 )
						{
					
							for ($i = 0; $i < count($_POST['arrscaleid']); $i++)
							{
								if (strlen(trim($_POST['arrscaleval'][$i])))
								{
									$model = $this->loadModelChars((int)$_POST['arrscaleid'][$i]);
									if ($model)
									{
										$model->scale = trim($_POST['arrscaleval'][$i]);
										$model->save();
									}
								}
							}
						}
        
        
            switch ((int)$_POST['type']) {
                case 1:
                    //Смена статуса (ДЛЯ КАТАЛОГА)
                    $model = $this->loadModel((int)$_POST['id']);
                    $model->status = (($model->status==1)?0:1);
                    $model->saveNode();
                    break;
                case 2:
                    //Удаление
                    foreach ($_POST['id'] as $id){
                        $this->loadModel((int)$id)->deleteNode();
                    }
                    echo CJavaScript::jsonEncode('ok');
                    break;
                case 3:
                    //Смена статуса (ДЛЯ ТОВАРА)
                    $model = $this->loadModelProduct((int)$_POST['id']);
                    $model->status = (($model->status==1)?0:1);
                    $model->save();
                    break;
                case 4:
                    //Удаление (ДЛЯ ТОВАРА)
                    foreach ($_POST['id'] as $id){
                        $this->loadModelProduct((int)$id)->delete();
                    }
                    echo CJavaScript::jsonEncode('ok');
                    break;
                case 5:
                    //Сохранение данных списка ( ДЛЯ ТОВАРА )
                    foreach ($_POST['price'] as $price){
                        $priceArr = explode("|", $price);
                        if ( count($priceArr)!=0 ){
                            $model = $this->loadModelProduct((int)$priceArr[0]);
                            if ($model){
                                $model->price = $priceArr[1];
                                $model->save();
                            }
                        }
                    }
                    foreach ($_POST['order'] as $order){
                        $orderArr = explode("|", $order);
                        if ( count($orderArr)!=0 ){
                            $model = $this->loadModelProduct((int)$orderArr[0]);
                            if ($model){
                                $model->order_id = $orderArr[1];
                                $model->save();
                            }
                        }
                    }
                    echo CJavaScript::jsonEncode('ok');
                    break;
                case 6:
                    //Смена статуса (ДЛЯ свойства объекта)
                    $model = $this->loadModelChars((int)$_POST['id']);
                    $model->status = (($model->status==1)?0:1);
                    $model->save();
                    echo CJavaScript::jsonEncode('ok');
                    break;
                case 7:
                    //Сохранение данных списка ( ДЛЯ СВОЙСТВ )
                    foreach ($_POST['order'] as $order){
                        $orderArr = explode("|", $order);
                        if ( count($orderArr)!=0 ){
                            $model = $this->loadModelChars((int)$orderArr[0]);
                            if ($model){
                                $model->order_id = $orderArr[1];
                                $model->save();
                            }
                        }
                    }
                    echo CJavaScript::jsonEncode('ok');
                    break;
            }

					
					
					
					//print_r($_POST);
					//exit;

					
					
        }


        Yii::app()->end();
    }


    public function loadModel($id)
    {
        $model=CatalogRubrics::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }


    public function loadModelProduct($id)
    {
        $model=CatalogElements::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }




    /** Свойства каталога */
    /**
     * @param null $id - id элемента
     * @param null $type_parent - тип элемента: 1-категория, 2-товар
     */
    public function actionListchars($id = null, $type_parent = 1){

        $this->breadcrumbs = array(
            (($type_parent==1)?'Каталоги':'Товары')=>array('/catalog/catalog/listgroup'),
            'Свойства '=>array('/catalog/catalog/listchars?id='.(int)$id),
        );

        $model=new CatalogChars('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['CatalogChars'])){
            $model->attributes = $_GET['CatalogChars'];
        }

        $object_name = '';
        if(!empty($id)){
            switch ($type_parent) {
                case 1:
                    $object_name = CatalogRubrics::model()->findByPk($id)->name;
                    break;
                case 2:
                    $object_name = CatalogElements::model()->findByPk($id);
                    //Применяем к выбраному товару все характеристики которые есть у родительского каталога
                    $modelCharsAppend = CatalogChars::model()->findAll('parent_id = '.$object_name->parent_id);
                    foreach ( $modelCharsAppend as $tmp_model_chrs ){
                        CatalogChars::model()->applyCategoryChars($id, $type_parent, $tmp_model_chrs);
                    }

                    $object_name = $object_name->name;

                    break;
            }
        }

        $param[] = 'is_deleted = 0';
        if (!empty($id)){
            $param[] = 'parent_id = '.$id;
        }
        $param[] = 'type_parent = '.$type_parent;
        $data['sort'] = array(
            'defaultOrder'=>'id DESC',
        );


        $data['Pagination'] = array(
            'PageSize'=>100,
        );
        if ($settingsModel = SiteModuleSettings::model()->find('site_module_id = 4')){
            $data['Pagination'] = array(
                'PageSize'=>(((int)$settingsModel->elements_page_admin>0)?$settingsModel->elements_page_admin:100),
            );
        }

        $provider=new CActiveDataProvider('CatalogChars', $data);
        $param = implode(" AND ", $param);
        $provider->criteria = $model->search($param);


        $this->render('listchars',array(
            'model'=>$model,
            'provider'=>$provider,
            'object_name'=>$object_name,
            'type_parent'=>$type_parent,
        ));
    }

    /** Создать новое свойство каталога */
    public function actionCreatechars($id){

        $this->breadcrumbs = array(
            'Каталоги'=>array('/catalog/catalog/listgroup'),
            'Свойства '=>array('/catalog/catalog/listchars?id='.(int)$id),
            'Новая запись'
        );


        $model=new CatalogChars;
        if(isset($_POST['CatalogChars'])){
            $model->attributes = $_POST['CatalogChars'];
            $model->parent_id = $id;
			$model->type_parent = (int)$_GET['type_parent'];
            if ($model->save()) {
                //Если указано наследование - создаем это свойство для остальных элементов в этом объекте
                if ($model->inherits == 1) {
                    CatalogChars::model()->addInherits($model, $_POST['CatalogChars']);
                }
                $this->redirect(array('updatechars', 'id' => $model->id));
            }
        }
        $this->render('formchars',array(
            'model'=>$model,
            'scale_val'=>array(),
        ));
    }

    /** Редактировать  свойство каталога */
    public function actionUpdatechars($id){


				

        $model = $this->loadModelChars($id);
        if(isset($_POST['CatalogChars'])){
            $model->attributes = $_POST['CatalogChars'];
            if ($model->save()) {
											//	echo 111111111;
										//		print_r($_POST); exit;

//echo 'Start1<br>';
//print_r($_POST);

//==============================================================================
								if (
								     (isset($_POST['set_childrens'])) &&
								     ($_POST['set_childrens']==1)
								   )
								{
									//echo 'Start<br>';
									// Если редактируется свойство категории
									if ($model->type_parent==1)
									{
										$model__rubric = CatalogRubrics::model()->find('id = '.$model->parent_id);
										$model__rubric_childs = CatalogRubrics::model()->findAll('
										left_key  >= '.$model__rubric->left_key.'
										AND
										right_key <= '.$model__rubric->right_key.'
										');
										foreach ($model__rubric_childs as $model__rubric_childs_item)
										{
											
											$model__catalog_chars_item = CatalogChars::model()->find('
											parent_id = '.$model__rubric_childs_item->id.'
											AND
											type_parent = 1
											AND
											name = \''.CatalogElements::sql_valid($model->name).'\'
											');
											if ($model__catalog_chars_item)
											{
												//echo 'rubric_chars ='.$model__catalog_chars_item->id.'<br>';
												$model__catalog_chars_item->filter_range = $model->filter_range;
												$model__catalog_chars_item->filter_use = $model->filter_use;
												$model__catalog_chars_item->type_scale = $model->type_scale;
												$model__catalog_chars_item->save();
											}
										}
										
										
										$model_elements = CatalogChars::model()->findAll('
											parent_id IN 
											(
												SELECT 
													id 
												FROM  
													tbl_catalog_elements 
												WHERE
													parent_id IN 
													(
														SELECT 
															id 
														FROM 
															tbl_catalog_rubrics 
														WHERE
															(
																left_key  >= '.$model__rubric->left_key.'
																AND
																right_key <= '.$model__rubric->right_key.'
															)
															OR
															(
																id = '.$model__rubric->id.'
															)
													)
											)
											AND
											type_parent = 2
											AND
											name = \''.CatalogElements::sql_valid($model->name).'\'
										');
										foreach ($model_elements as $model_elements_item)
										{
											//echo 'item_chars ='.$model__catalog_chars_item->id.'<br>';
											$model__catalog_chars_item->filter_range = $model->filter_range;
											$model__catalog_chars_item->filter_use = $model->filter_use;
											$model__catalog_chars_item->type_scale = $model->type_scale;
											$model__catalog_chars_item->save();
										}
										
									}
								}
//==============================================================================




                //Если указано наследование - создаем это свойство для остальных элементов в этом объекте
                if ($model->inherits == 1) {
                    CatalogChars::model()->addInherits($model, $_POST['CatalogChars']);
                }
                $this->redirect(array('updatechars','id'=>$model->id));
            }

        }

        $scale_val = array();
        //разбираем значение в scale если type_scale == 2 или 3
        $tmp_scale_val = explode("|", $model->scale);
        if (is_array($tmp_scale_val)){
            $scale_val = array_filter($tmp_scale_val);
        }


        $this->breadcrumbs = array(
            'Каталоги'=>array('/catalog/catalog/listgroup'),
            'Свойства '=>array('/catalog/catalog/listchars?id='.(int)$model->parent_id),
            'Редактирование'
        );


        $this->render('formchars',array(
            'model'=>$model,
            'scale_val'=>$scale_val,
        ));
    }

    /**  Удалить свойство каталога  */
    public function actionDeletechars($id){
        $model = $this->loadModelChars($id);
        //$this->loadModelChars($id)->delete();
        $model->is_deleted = 1;
		$model->save();


        $type_parent = intval($_GET['type_parent']);
        if ($type_parent)
        {
	        $this->redirect('listchars?id='.$model->parent_id.'&type_parent='.$type_parent);
        }
    }


    public function actionSharechars($type_parent = 3){

        $this->breadcrumbs = array(
            'Каталоги'=>array('/catalog/catalog/listgroup'),
            'Настройки'=>array('/catalog/catalog/settings'),
            'Список предопределенных характеристик'=>array('/catalog/catalog/sharechars'),
        );

        $model=new CatalogChars('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['CatalogChars'])){
            $model->attributes = $_GET['CatalogChars'];
        }

        if (isset($_POST['CatalogChars'])){
            //Добавляем новую предопределенную характеристику
            $model->attributes = $_POST['CatalogChars'];
            $model->type_parent = $type_parent;

            if ($model->save()) {
                //Если указано наследование - создаем это свойство для остальных элементов в этом объекте
                if ($model->inherits == 1) {
                    CatalogChars::model()->addInherits($model, $_POST['CatalogChars']);
                } else {
                    //Иначе - создаем только для указаного каталога это свойство
                    $model = new  CatalogChars();
                    $model->attributes = $_POST['CatalogChars'];
                    $model->type_parent = 1;
                    $model->save();
                }
            }
            $model=new CatalogChars('search');
            $model->unsetAttributes();  // clear any default values
        }


        $param = null;
        $param[] = 'type_parent = '.$type_parent;
        $data['sort'] = array(
            'defaultOrder'=>'id DESC',
        );
        $data['Pagination'] = array(
            'PageSize'=>100,
        );
        $provider=new CActiveDataProvider('CatalogChars', $data);
        $param = implode(" AND ", $param);
        $provider->criteria = $model->search($param);

        $root = CatalogRubrics::getRoot(new CatalogRubrics);
        $catalog = $root->descendants()->findAll($root->id);

        $this->render('sharechars',array(
            'model'=>$model,
            'provider'=>$provider,
            'categories'=>$catalog,
            'root' => $root,
        ));
    }


    public function loadModelChars($id)
    {
        $model=CatalogChars::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }


}
