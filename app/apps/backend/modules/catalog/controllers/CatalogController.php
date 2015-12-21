<?php

class CatalogController extends Controller
{


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
                if (isset($model->imagefile) && $modelSettings = SiteModuleSettings::model()->find('site_module_id = 4')){
                    $filename = $model->id.'.'.$model->image;
                    $filepatch = '/../uploads/filestorage/catalog/elements/';
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                    //Обработка изображения
                    SiteModuleSettings::model()->chgImgModel($modelSettings, 'GD', 2,$model->id);
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
                if (isset($model->imagefile) && $modelSettings = SiteModuleSettings::model()->find('site_module_id = 4')){
                    $filename = $model->id.'.'.$model->image;
                    $filepatch = '/../uploads/filestorage/catalog/elements/';
                    $model->imagefile->saveAs( YiiBase::getPathOfAlias('webroot').$filepatch.$filename );
                    //Обработка изображения
                    SiteModuleSettings::model()->chgImgModel($modelSettings, 'GD', 2,$model->id);

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

        $param = null;
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
        $this->loadModelChars($id)->delete();
        $this->redirect('listchars?id='.$model->parent_id);
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
