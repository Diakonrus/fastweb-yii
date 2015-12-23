<?php

class LoadxmlController extends Controller
{

    public function init(){
        ini_set('memory_limit', '512M');
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'update' page.
	 */
    public function actionCreate()
    {

        $this->breadcrumbs = array(
            'Загрузки XML '=>array('/loadxml/loadxml/index'),
            'Конструктор профиля'=>array('/loadxml/loadxml/create'),
        );

        $model = new LoadxmlRubrics;


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        // set attributes from get
        if(isset($_GET['LoadxmlRubrics'])){
            $model->attributes=$_GET['LoadxmlRubrics'];
        }

        if(isset($_POST['LoadxmlRubrics']))
        {

            $model->attributes = $_POST['LoadxmlRubrics'];
            $filepatch = YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/loadxml/';

            //1ый шаг
            if (empty($model->ext)){
                $model->testedfile = CUploadedFile::getInstance($model,'testedfile');
                if (!empty($model->testedfile)){
                    $ext = pathinfo($model->testedfile);
                    $ext = $ext['extension'];
                    if(preg_match("/xml/i",$ext) || preg_match("/xls/i",$ext) || preg_match("/xlsx/i",$ext) || preg_match("/csv/i",$ext)){
                        $model->ext = $ext;
                    }
                }
                if ($model->validate()){
                    //Закачиваем файл
                    $filename = $model->testedfile->getName();
                    $model->testedfile->saveAs( $filepatch.$filename );
                    $model->url_to_file = $filename;

                    //xml
                    if(preg_match("/.xml/i",$filename)){
                        $xml = new Parsfile();
                        $xml->pars_xml_one($filepatch.$filename);
                        $output = $xml->OutArr;
                        $model->tags = implode("|", $xml->XmlMask);
                    }
                    //xls и xlsx
                    if(preg_match("/.xls/i",$filename) || preg_match("/.xlsx/i",$filename)){
                        $exel = new Parsfile();
                        $exel->pars_exel($filepatch.$filename);
                        $output = $exel->OutArr;
                    }
                    //csv
                    if (preg_match("/.csv/i",$filename)){
                        $csv = new Parsfile();
                        $_POST['LoadxmlRubrics']['splitter'] = (((int)$_POST['LoadxmlRubrics']['splitter']==0)?1:$_POST['LoadxmlRubrics']['splitter']); /* По умолчанию разделитель в CSV  = ; */
                        $splitter = LoadxmlRubrics::model()->getSplitter((int)$_POST['LoadxmlRubrics']['splitter']);
                        $csv->pars_csv($filepatch.$filename,$splitter);
                        $output = $csv->OutArr;
                    }
                }
            } else {
                //2ой шаг
                $filename = $_POST['LoadxmlRubrics']['url_to_file'];
                //Разбираем файл

                //xml
                if(preg_match("/.xml/i",$filename)){
                    $xml = new Parsfile();
                    $xml->pars_xml($filepatch.$filename, $model->tag);
                    $output = $xml->XmlFieldsHash;

                }
                //xls, xlsx
                if(preg_match("/.xls/i",$filename) || preg_match("/.xlsx/i",$filename)){
                    $exel = new Parsfile();
                    $exel->pars_exel($filepatch.$filename);
                    $output = $exel->OutArr;
                }

                //csv
                if (preg_match("/.csv/i",$filename)){
                    $csv = new Parsfile();
                    $_POST['LoadxmlRubrics']['splitter'] = (((int)$_POST['LoadxmlRubrics']['splitter']==0)?1:$_POST['LoadxmlRubrics']['splitter']); /* По умолчанию разделитель в CSV  = ; */
                    $splitter = LoadxmlRubrics::model()->getSplitter((int)$_POST['LoadxmlRubrics']['splitter']);
                    $csv->pars_csv($filepatch.$filename,$splitter);
                    $output = $csv->OutArr;
                }


                $str = '';
                foreach ( $output as $FieldsHash ){
                    $str .= '$fld[] = array(';
                    foreach ( $FieldsHash as $key=>$val){
                        $str .= "'".$key."' => '".$val."',";
                    }
                    $str = substr($str, 0, -1);
                    $str .= ');';
                }
                $model->content1 = $str;


                if ($model->save()){
                    $url = $this->itemUrl('update', $model->id);;
                    $this->redirect( $url );
                }
            }


        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'update' page.
	 * @param integer $id the ID of the model to be updated
	 */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        // set attributes from get
        if(isset($_GET['LoadxmlRubrics'])){
            $model->attributes=$_GET['LoadxmlRubrics'];
        }

        if(isset($_POST['LoadxmlRubrics']))
        {
            $model->attributes=$_POST['LoadxmlRubrics'];
            //записываем поля
            $content2 = array_diff($_POST['LoadxmlRubrics']['Field'], array(''));
            $content2_str = '';
            if (!empty($content2)){
                foreach ($content2 as $key=>$val){
                    $content2_str .= $key.'%'.$val.'%1%|';
                }
            }
            $model->content2 = $content2_str;

            if ($model->save()){
                $this->redirect('index');
            }

        }

        //разбираем content2
        $content2 = array();
        foreach ( (explode("|", $model->content2)) as $key=>$val1 ){
            $res = explode("%", $val1);
            if (!isset($res[1]) || !isset($res[2])){continue;}
            $k = $res[0];
            $content2[$k][] = $res[1];
            $content2[$k][] = $res[2];
        }

        $this->render('update',array(
            'model'=>$model,
            'content2'=>$content2,
        ));
    }

    public function actionUploaddata($id){
        set_time_limit(0);

        $model=$this->loadModel($id);

        $catalog = null;

        //Для модуля Каталог, Двигатели, Трансмисия
        if ($model->module==1){
            $catalog = CatalogRubrics::model()->getRootIdAndName();
        }
        if ($model->module==2){
            $catalog = CatalogengineRubrics::model()->getRootIdAndName();
        }
        if ($model->module==3){
            $catalog = CatalogtransmissionRubrics::model()->getRootIdAndName();
        }

        if(isset($_POST['LoadxmlRubrics'])) {

            $err = 0;
            //$model->attributes = $_POST['LoadxmlRubrics'];
            $filepatch = YiiBase::getPathOfAlias('webroot') . '/../uploads/filestorage/loadxml/';
            $model->testedfile = CUploadedFile::getInstance($model,'testedfile');
            if (!empty($model->testedfile)){
                $ext = pathinfo($model->testedfile);
                $ext = $ext['extension'];
                if ($model->ext != $ext  ){
                    if ( ($model->ext == 'xls' || $model->ext == 'xlsx') && ($ext=='xls' || $ext=='xlsx') ){
                        $err = 0;
                    } else {
                        $err = 1;
                        Yii::app()->user->setFlash('error', "Файл должен быть в формате: ".$model->ext);
                    }
                }
            }
            else {
                $err = 1;
                Yii::app()->user->setFlash('error', "Вы не выбрали файл");
            }

            if ($err == 0){
                //Загружаем файл
                $filename = $model->testedfile->getName();
                $model->testedfile->saveAs( $filepatch.$filename );
                //xls и xlsx
                if(preg_match("/.xls/i",$filename) || preg_match("/.xlsx/i",$filename)){
                    $exel = new Parsfile();
                    $exel->pars_exel($filepatch.$filename);
                    $output = $exel->OutArr;
                }
                //xml
                if(preg_match("/.xml/i",$filename)){
                    $xml = new Parsfile();
                    $xml->pars_xml($filepatch.$filename, $model->tag);
                    $output = $xml->XmlFieldsHash;
                }
                //csv
                if(preg_match("/.csv/i",$filename)){
                    $csv = new Parsfile();
                    $splitter = LoadxmlRubrics::model()->getSplitter((int)$model->splitter);
                    $csv->pars_csv($filepatch.$filename,$splitter);
                    $output = $csv->OutArr;
                }


                //модуль каталог
                if ($model->module == 1 || $model->module == 2 || $model->module == 3){

                    $table_pref = "tbl_";

                    if ($model->module == 1){$table = "catalog_elements";} //Для модуля Каталог
                    if ($model->module == 2){$table = "catalogengine_elements";} //Для модуля Двигатели
                    if ($model->module == 3){$table = "catalogtransmission_elements";} //Для модуля Трансмисия

                    // Вычисляем, какие столбцы нужно обходить циклом для группировки значений
                    $groups_need = array();
                    if ( !empty($model->groups) ) {
                        $list_groups = unserialize($model->groups);
                        $cnt_list = count($list_groups);
                        $group_i = 0;
                        for ( $i = 1; $i <= $cnt_list; ++$i ) {
                            if ( $list_groups[$i] ) {
                                $groups_need[$group_i] = $i; // создаем массив с номерами нужных столбцов
                                ++$group_i;
                            }
                        }
                    }


                    $count_need = count($groups_need); // кол-во нужных столбов
                    $count_table = count($output); // кол-во строк в таблице
                    $val_arr_group = array(); // массив значений для группировки
                    $val_arr_cnt = array(); // массив для хранения кол-ва записей группировки
                    $val_arr_group_r = array(); // массив значений для группировки

                    if ( $count_need > 0 ) {
                        for ( $j = 1; $j <= $count_table; ++$j ) {
                            for ( $i = 0; $i <= $count_need; ++$i ) {
                                $group_id = $groups_need[$i];
                                $group_cnt = intval($val_arr_cnt[$group_id]);
                                $read_vars = trim($output[$j][$group_id]);
                                $read_vars_alt = $this->totranslit($read_vars);
                                if ( !in_array ($read_vars_alt, $val_arr_group[$group_id] ) and $read_vars_alt ) {

                                    $val_arr_group[$group_id][$group_cnt] = $read_vars_alt; // записываем в массив значение
                                    $val_arr_group_r[$group_id][$group_cnt]['name'] = $read_vars;
                                    $val_arr_group_r[$group_id][$group_cnt]['alt_name'] = $read_vars_alt;

                                    ++$group_cnt;
                                    $val_arr_cnt[$group_id] = $group_cnt; // записываем в массив кол-во записей

                                }

                            }
                        }

                    }

                    //надо очищать каталог перед импортом - сдеать вызов тут
                    if(isset($_POST['LoadxmlRubrics']['clearsect']) && (int)$_POST['LoadxmlRubrics']['clearsect']==1 && (int)$_POST['LoadxmlRubrics']['parent_id']>0){
                        if ($model->module == 1){CatalogElements::model()->deleteAll("`parent_id` = :parent_id",array(':parent_id' => (int)$_POST['LoadxmlRubrics']['parent_id']));}
                        if ($model->module == 2){CatalogengineElements::model()->deleteAll("`parent_id` = :parent_id",array(':parent_id' => (int)$_POST['LoadxmlRubrics']['parent_id']));}
                        if ($model->module == 3){CatalogtransmissionElements::model()->deleteAll("`parent_id` = :parent_id",array(':parent_id' => (int)$_POST['LoadxmlRubrics']['parent_id']));}
                    }

                    /*
                    foreach ($val_arr_group_r as $keys_in ) {
                        foreach ( $keys_in as $test ) {
                            $nde = array();
                            $nde['name'] = trim($test['name']);
                            $nde['page_name'] = $test['name'];
                            $nde['url'] = strtolower($test['alt_name']);
                            if ((int)$_POST['LoadxmlRubrics']['parent_id']>0){
                                $category = new CatalogRubrics;
                                $category->name = $nde['name'];
                                $category->page_name = $nde['page_name'];
                                $category->url = $nde['url'];
                                $category->parent_id = (int)$_POST['LoadxmlRubrics']['parent_id'];
                                $root = CatalogRubrics::model()->findByPk($category->parent_id);
                                $category->appendTo($root);
                            }
                        }
                    }
                    */

                    $MainFields = null;
                    $fields = explode('|',$model->content2);
                    $FieldCount = 0;
                    foreach($fields as $k => $v){
                        if(isset($v[0]) && !empty($v[0])){
                            $subfields = explode('%',$v);
                            $MainFields2[$k] = $subfields;
                            if($model->ext == 'xml'){$subfields[1] = $xml->XmlAntiMap[$subfields[1]];}
                            $MainFields[$k] = $subfields;
                            $FieldCount++;
                        }
                    }
                    $uniqKey = '';
                    foreach($MainFields as $mk => $mv){
                        if($mv[0] == $model->unique && $model->unique != ''){
                            $uniqKey = $model->unique;
                        }
                    }
                    //Пишем данные в таблицы
                    foreach($output as $k => $v){
                        $sett = '';
                        $setv = '';
                        $UniqField = '';
                        $WriteFlag = 1;
                        foreach($MainFields as $K => $V){
                            $val = '';
                            if($model->ext == 'xml'){
                                $xml_field = $MainFields2[$K][1];
                                $val = $xml->XmlFieldsHash[$k][$xml_field];
                                if($V[1] == 3){$val = preg_replace("/[^1234567890.,]/",'',$val);$vall = preg_replace("/\,]/",'.',$val);}
                                if($V[1] == 2){if(trim($xml->XmlFieldsHash[$k][$xml_field]) == ''){$val = '';}else{$val = 1;}}
                            }
                            else{
                                $val = $v[$V[1]];
                                if($V[2] == 3){$val = preg_replace("/[^1234567890.,]/",'',$val);$vall = preg_replace("/\,]/",'.',$val);}
                                if($V[2] == 2){if(trim($v[$V[2]-1]) == ''){$val = '';}else{$val = 1;}}
                            }
                            //print $val."||||<br/>";
                            if($sett == ''){$sett .= " `$V[0]` ";}else{$sett .= ", `$V[0]` ";}
                            if($setv == ''){$setv .= " '".$val."' ";}else{$setv .= ", '".(addslashes($val))."' ";}
                            if($V[0] == $uniqKey && $V[0] != ''){
                                $UniqField = $uniqKey;

                                $resultU = Yii::app()->db->createCommand()
                                    ->select('*')
                                    ->from('{{'.$table.'}}')
                                    ->where(" `".$UniqField."` = '".$val."'")
                                    ->queryAll();
                                foreach ($resultU as $rowU){
                                    if($rowU['id'] != ''){
                                        Yii::app()->db->createCommand()->delete("`".$table."`", 'id=:id', array(':id'=>$rowU['id']));
                                    }
                                }
                            }
                            if($V[3] != ''){
                                //if($val == ''){$WriteFlag = 0;}
                            }
                        }
                        $sett .= ',`parent_id` ';
                        $setv .= ", '".(int)$_POST['LoadxmlRubrics']['parent_id']."' ";
                        if($WriteFlag != '0'){
                            $sql = "INSERT INTO ".$table_pref.$table." ($sett) VALUES ($setv)";

                            Yii::app()->db->createCommand($sql)->execute();
                        }else print "0 <br/>";
                    }


                }

                Yii::app()->user->setFlash('success', "Данные загружены");
            }

        }

        $this->render('uploaddata',array(
            'model'=>$model,
            'catalog'=>$catalog,
        ));
    }

    /**
     * File uploader controller
     */
	public function actionUpload(){

        $webFolder = '/uploads/pages/';
        $tempFolder = Yii::app()->basePath . '/../'.SITE_PUBLIC_NAME . $webFolder;

        @mkdir($tempFolder, 0777, TRUE);
        @mkdir($tempFolder.'chunks', 0777, TRUE);

        Yii::import("ext.EFineUploader.qqFileUploader");

        $uploader = new qqFileUploader();
        $uploader->allowedExtensions = array('jpg','jpeg', 'png', 'gif');
        $uploader->sizeLimit = 2 * 1024 * 1024;//maximum file size in bytes
        $uploader->chunksFolder = $tempFolder.'chunks';

        $result = $uploader->handleUpload($tempFolder);
        $result['filename'] = $uploader->getUploadName();
        $result['folder'] = $webFolder;

        $uploadedFile=$tempFolder.$result['filename'];

        header("Content-Type: text/plain");
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;
        Yii::app()->end();
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
            $id = Yii::app()->request->getParam('id', array());
            $list = is_array($id) ? $id : array($id);
            foreach($list as $id){
                $this->loadModel($id)->delete();
            }
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 *
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Pages');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	*/

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $this->breadcrumbs = array(
            'Загрузки XML - Профиль'=>array('/loadxml/loadxml/index'),
        );

		$model=new LoadxmlRubrics('search');
        $model->attachBehavior('dateComparator', array(
            'class' => 'DateComparator',
        ));
		$model->unsetAttributes();  // clear any default values

		// set attributes from get
		if(isset($_GET['LoadxmlRubrics'])){
			$model->attributes=$_GET['LoadxmlRubrics'];
        }

		$this->render('list',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=LoadxmlRubrics::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionImageUpload() {

        $webFolder = '/uploads/news/';
        $tempFolder = Yii::app()->basePath . '/../'.SITE_PUBLIC_NAME . $webFolder;

        @mkdir($tempFolder, 0777, TRUE);
        @mkdir($tempFolder.'chunks', 0777, TRUE);

        Yii::import("ext.image.CImageComponent");

        $image=CUploadedFile::getInstanceByName('file');
        $filename = 'a_'.date('YmdHis').'_'.substr(md5(time()), 0, rand(7, 13)).'.'.$image->extensionName;
        $path = $tempFolder.$filename;
        $image->saveAs($tempFolder.$filename);

        if ( $result = $this->widget('application.extensions.kyimages.KYImages',array('patch'=>$webFolder, 'file'=>$filename)) ){
            //ToDo Вернет данные о ресайзеном изображении (патч и имя файла). Если надо использовать - то тут
        }

        /*
        $image_open = Yii::app()->image->load($tempFolder.$filename);
        if (isset($image_open)) { if ($image_open->width > $image_open->height) $dim = Image::HEIGHT;
        else $dim = Image::WIDTH; $image_open->resize(100, 100, $dim)->crop(100, 100);
            $image_open->save($tempFolder.$filename); }
        */
        $array = array( 'filelink' => Yii::app()->request->hostInfo.$webFolder.$filename, 'filename' => $filename );
        echo stripslashes(json_encode($array));
    }


    private function totranslit($var, $lower = true, $punkt = true) {
        global $langtranslit;

        if ( is_array($var) ) return "";

        if (!is_array ( $langtranslit ) or !count( $langtranslit ) ) {

            $langtranslit = array(
                'а' => 'a', 'б' => 'b', 'в' => 'v',
                'г' => 'g', 'д' => 'd', 'е' => 'e',
                'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
                'и' => 'i', 'й' => 'y', 'к' => 'k',
                'л' => 'l', 'м' => 'm', 'н' => 'n',
                'о' => 'o', 'п' => 'p', 'р' => 'r',
                'с' => 's', 'т' => 't', 'у' => 'u',
                'ф' => 'f', 'х' => 'h', 'ц' => 'c',
                'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
                'ь' => '', 'ы' => 'y', 'ъ' => '',
                'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
                "ї" => "yi", "є" => "ye",

                'А' => 'A', 'Б' => 'B', 'В' => 'V',
                'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
                'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
                'И' => 'I', 'Й' => 'Y', 'К' => 'K',
                'Л' => 'L', 'М' => 'M', 'Н' => 'N',
                'О' => 'O', 'П' => 'P', 'Р' => 'R',
                'С' => 'S', 'Т' => 'T', 'У' => 'U',
                'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
                'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
                'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
                'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
                "Ї" => "yi", "Є" => "ye",
            );

        }

        $var = str_replace( ".php", "", $var );
        $var = trim( strip_tags( $var ) );
        $var = preg_replace( "/\s+/ms", "-", $var );

        $var = strtr($var, $langtranslit);

        if ( $punkt ) $var = preg_replace( "/[^a-z0-9\_\-.]+/mi", "", $var );
        else $var = preg_replace( "/[^a-z0-9\_\-]+/mi", "", $var );

        $var = preg_replace( '#[\-]+#i', '-', $var );

        if ( $lower ) $var = strtolower( $var );

        if( strlen( $var ) > 200 ) {

            $var = substr( $var, 0, 200 );

            if( ($temp_max = strrpos( $var, '-' )) ) $var = substr( $var, 0, $temp_max );

        }

        return $var;
    }

}
