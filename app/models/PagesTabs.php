<?php

/**
 * This is the model class for table "{{pages_tabs}}".
 *
 * The followings are the available columns in table '{{pages_tabs}}':
 * @property integer $id
 * @property integer $order_id
 * @property integer $pages_id
 * @property integer $site_module_id
 * @property integer $template_id
 * @property string $title
 * @property string $description
 * @property string $created_at
 */
class PagesTabs extends CActiveRecord
{
    public $created_at_start;
	public $created_at_end;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pages_tabs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pages_id, site_module_id, template_id, site_module_value', 'required'),
			array('order_id, pages_id, site_module_id, template_id', 'numerical', 'integerOnly'=>true),
			array('title, site_module_value', 'length', 'max'=>350),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, pages_id, site_module_id, template_id, title, site_module_value, description, created_at, created_at_start, created_at_end,
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
            'pages' => array(self::BELONGS_TO, 'Pages', 'pages_id'),
            'siteModule' => array(self::BELONGS_TO, 'SiteModule', 'site_module_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Порядок',
			'pages_id' => 'Страница',
			'site_module_id' => 'Модуль',
			'template_id' => 'Оформление',
			'title' => 'Заголовок',
            'site_module_value' => 'Массив значений',
			'description' => 'Текст',
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('pages_id',$this->pages_id);
		$criteria->compare('site_module_id',$this->site_module_id);
		$criteria->compare('template_id',$this->template_id);
		$criteria->compare('title',$this->title,true);
        $criteria->compare('site_module_value',$this->site_module_value,true);
		$criteria->compare('description',$this->description,true);
		$this->compareDate($criteria, 'created_at');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PagesTabs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    //Список модулей которые доступны для вкладок
    private $moduleID = array(
        1 =>'{{news_rubrics}}', //Новости
        6 => '{{article_rubrics}}', //статьи
        7 => '{{faq_rubrics}}', //Вопросы-ответы
        10 => '{{doctor_elements}}',  //Врачи
        11 => '{{photo_rubrics}}',  //Фотогалерея
        12 => '{{before_after_rubrics}}',  //До и После
        13 => '{{main_tabel}}',  //Таблицы
        16 => '{{review_rubrics}}',  //Таблицы
        17 => '{{html_code}}',  //HTML код
    );

    /**
     * @return array
     * Возвращает массив модулей
     */
    public function getModuleSelect(){
        $result = array();
        foreach ($this->moduleID as $key=>$val){
            if ( $data = SiteModule::model()->findByPk((int)$key) ){
                $result[$data->id] = $data->name;
            }
        }
        return $result;
    }

    /**
     * @param $id - id модуля
     * возвращает массив значений модулей
     */
    public function getModuleValue($id){
        $result = array();
        $tabel_name = $this->moduleID[$id];

        if ( !Yii::app()->db->createCommand("show columns from ".$tabel_name." where `Field` = 'level'")->queryRow() ){
            $i = 0;
            foreach ( Yii::app()->db->createCommand()
                          ->select('*')
                          ->from($tabel_name)
                          ->queryAll() as $data ){
                if ( (isset($data['level']) && $data['level']==1) || (isset($data['status']) && $data['status']==0) ){continue;}
                $result[$i]['id'] = $data['id'];
                $result[$i]['name'] = $data['name'];
                ++$i;
            }

        } else {
            $root =  Yii::app()->db->createCommand()->select('id, left_key, right_key')->from($tabel_name)->where('level = 1')->queryRow();
            $sql = 'SELECT `id`, `parent_id`, `name`, `level` FROM '.$tabel_name.' WHERE `level`>1 AND left_key >= '.((int)$root['left_key']).' AND right_key <= '.((int)$root['right_key']).' ORDER BY left_key';
            $i = 0;
            foreach ( Yii::app()->db->createCommand($sql)->queryAll() as $data) {
                $result[$i]['id'] = $data['id'];
                $result[$i]['name'] = ((((int)$data['level']>2))?(str_repeat('&nbsp;&nbsp;&nbsp;', (int)$data['level']).$data['name']):('<b>'.$data['name'].'</b>'));
                ++$i;
            }
        }


        return $result;
    }


    public function getTemplateSelect($id = null){
        $name = array(
            1 => 'Оформление блока на белом фоне',
            2 => 'Оформление блока на сером фоне',
        );
        return ((!empty($id))?$name[$id]:$name);
    }

    /**
     * @param $modelPage  - модель Pages
     * @param $arrayData  - массив значений с вкладками
     * Пишет в БД значения вкладок для страницы
     */
    public function addTabs($modelPage, $arrayData){

        //Удаляем все вкладки для этой страницы перед началом
        PagesTabs::model()->deleteAll('pages_id = '.$modelPage->id);

        if (!isset($arrayData['site_module_value']) || !isset($arrayData['site_module_id'])){
            return false;
        }

        $insertVal = array();

        foreach ($arrayData['title'] as $key=>$val){
            $insertVal[$key]['title'] = current($val);
        }
        foreach ($arrayData['description'] as $key=>$val){
            $insertVal[$key]['description'] = current($val);
        }
        foreach ($arrayData['order_id'] as $key=>$val){
            $insertVal[$key]['order_id'] = current($val);
        }
        foreach ($arrayData['template_id'] as $key=>$val){
            $insertVal[$key]['template_id'] = current($val);
        }
        foreach ($arrayData['site_module_id'] as $key=>$val){
            $insertVal[$key]['site_module_id'] = current($val);
        }
        foreach ($arrayData['site_module_value'] as $key=>$values){
            $insertVal[$key]['site_module_value'] = '';
            foreach ($values as $val){
                $insertVal[$key]['site_module_value'] .= $val.'|';
            }
        }

        //Пишем в БД
        foreach ($insertVal as $key=>$val){
            if (empty($val['site_module_id']) || empty($val['site_module_value'])){ continue; }
            $model = new PagesTabs();
            $model->order_id = (int)$val['order_id'];
            $model->pages_id = (int)$modelPage->id;
            $model->site_module_id = (int)$val['site_module_id'];
            $model->site_module_value = $val['site_module_value'];
            $model->template_id = (int)$val['template_id'];
            $model->title = $val['title'];
            $model->description = $val['description'];
            $model->save();
        }
        return true;
    }

    /**
     * @param $model - модель таблицы tbl_pages_tabs
     * Возращает HTML код блока вкладки
     */
    public function getTemplate($model){
        $resultHTML = '';

        //Шаблоны
        $template = array(
            //Белый фон
            1 => '
            <section>
                <main class="all" role="main">
                    <div class="container">
                        <h1 class="main-caption mg-bottom-24 caption-big">%title%</h1>
                    </div>
                    <div class="container">
                        <div class="top-text">
                            %description%
                        </div>
                    </div>
                    <div class="price">
                        <div class="container tred">
                            %module_value%
                        </div>
                    </div>
                </main>
            </section>
            ',
            //Серый фон
            2 => '
            <section>
                <main class="all" role="main">
                    <div class="container video-caption">
                        <h2 class="main-caption mg-bottom-24">%title%</h2>
                    </div>
                </main>
                <div class="container">
                    <div class="top-text">
                    %description%
                    </div>
                </div>
                <div class="news-block price">
                    <main class="all" role="main">
                        <div class="container">
                            %module_value%
                        </div>
                    </main>
                </div>
            </section>
            ',
        );

        //Общий шаблон
        switch ($model->site_module_id) {
            case 1:
                //Новости
                $template = array(
                    //Белый фон
                    1 => '
                        <div class="spisok">
                            <main class="all" role="main">
                                <div class="container">
                                    <h1 class="main-caption mg-bottom-24 caption-big">%title%</h1>
                                    %module_value%
                                </div>
                            </main>
                        </div>
                    ',
                    //Серый фон
                    2 => '
                        <main class="all" role="main">
                            <div class="container">
                                <h2 class="main-caption mg-bottom-24">%title%</h2>
                            </div>
                        </main>
                        <div class="spisok fogr gray-bg">
                            <main class="all" role="main" style="padding-top:20px;">
                                <div class="container">
                                    %module_value%
                                </div>
                            </main>
                        </div>
                        ',
                );
                break;
            case 6:
                //Статьи
                $template = array(
                    //Белый фон
                    1 => '
                        <div class="spisok">
                            <main class="all" role="main">
                                <div class="container">
                                    <h1 class="main-caption mg-bottom-24 caption-big">%title%</h1>
                                    %module_value%
                                </div>
                            </main>
                        </div>
                    ',
                    //Серый фон
                    2 => '
                        <main class="all" role="main">
                            <div class="container">
                                <h2 class="main-caption mg-bottom-24">%title%</h2>
                            </div>
                        </main>
                        <div class="spisok fogr gray-bg">
                            <main class="all" role="main" style="padding-top:20px;">
                                <div class="container">
                                    %module_value%
                                </div>
                            </main>
                        </div>
                        ',
                );
                break;
            case 16:
                //Отзывы
                $template = array(
                    //Белый фон
                    1 => '
                        <div class="spisok">
                            <main class="all" role="main">
                                <div class="container">
                                    <h1 class="main-caption mg-bottom-24 caption-big">%title%</h1>
                                    %module_value%
                                </div>
                            </main>
                        </div>
                    ',
                    //Серый фон
                    2 => '
                        <main class="all" role="main">
                            <div class="container">
                                <h2 class="main-caption mg-bottom-24">%title%</h2>
                            </div>
                        </main>
                        <div class="spisok fogr gray-bg">
                            <main class="all" role="main" style="padding-top:20px;">
                                <div class="container">
                                    %module_value%
                                </div>
                            </main>
                        </div>
                        ',
                    );
                break;
            case 7:
                //Вопросы-ответы
                $template = array(
                    //Белый фон
                    1 => '
                        <div class="spisok">
                            <main class="all" role="main">
                                <div class="container faq" style="background: #ffffff;">
                                    <h1 class="main-caption mg-bottom-24 caption-big">%title%</h1>
                                    %module_value%
                                </div>
                            </main>
                        </div>
                    ',
                    //Серый фон
                    2 => '
                        <main class="all" role="main">
                            <div class="container">
                                <h2 class="main-caption mg-bottom-24">%title%</h2>
                            </div>
                        </main>
                        <div class="spisok fogr gray-bg">
                            <main class="all" role="main" style="padding-top:20px;">
                                <div class="container faq">
                                    %module_value%
                                </div>
                            </main>
                        </div>
                        ',
                );
                break;
            case 10:
                //Врачи
                $template = array(
                    //Белый фон
                    1 => '
                        <style>
                            #carusel20 .carusel-left {background-color: #fff;}
                            #carusel20 .carusel-right {background-color: #fff;}
                        </style>
                        <div class="doctor-slide">
		                    <main role="main" class="all" style="background:#fff">
                                <div class="container">
                                    <h2 class="main-caption mg-bottom-24">%title%</h2>
                                </div>
                            </main>
                            <div  class="gray-bg">
                                <main role="main" class="all">
                                    <div class="container">
                                        %description%
                                        <div id="carusel20_doc" class="owl-carousel owl-theme slider pos-relative mg-top-15">
                                            %module_value%
                                        </div>
                                    </div>
                                </main>
                            </div>
                        </div>
                    ',
                    //Серый фон
                    2 => '
                        <div class="doctor-slide">
		                    <main role="main" class="all">
                                <div class="container">
                                    <h2 class="main-caption mg-bottom-24">%title%</h2>
                                </div>
                            </main>
                            <div  class="news-block gray-bg">
                                <main role="main" class="all">
                                    <div class="container">
                                        %description%
                                        <div id="carusel20_doc" class="owl-carousel owl-theme slider pos-relative mg-top-15">
                                            %module_value%
                                        </div>
                                    </div>
                                </main>
                            </div>
                        </div>
                    ',
                );
                break;

            case 11:
                //Фотогалерея
                $template = array(
                    //Белый фон
                    1 => '
                        <style>
                            #carusel20 .carusel-left {background-color: #fff;}
                            #carusel20 .carusel-right {background-color: #fff;}
                            #carusel20_photo .owl-prev {margin-top:-80px;}
                            #carusel20_photo .owl-next {margin-top:-80px;}
                        </style>
                        <div class="doctor-slide">
		                    <main role="main" class="all" style="background:#fff">
                                <div class="container">
                                    <h2 class="main-caption mg-bottom-24 caption-big">%title%</h2>
                                </div>
                            </main>
                            <div  class="gray-bg">
                                <main role="main" class="all">
                                    <div class="container">
                                        %description%
                                        <div id="carusel20_photo" class="owl-carousel owl-theme slider pos-relative mg-top-15">
                                            %module_value%
                                        </div>
                                    </div>
                                </main>
                            </div>
                        </div>
                    ',
                    //Серый фон
                    2 => '
                        <style>
                            #carusel20_photo .owl-prev {margin-top:-80px;}
                            #carusel20_photo .owl-next {margin-top:-80px;}
                        </style>
                        <div class="doctor-slide">
		                    <main role="main" class="all">
                                <div class="container">
                                    <h2 class="main-caption mg-bottom-24">%title%</h2>
                                </div>
                            </main>
                            <div  class="news-block gray-bg">
                                <main role="main" class="all">
                                    <div class="container">
                                        %description%
                                        <div id="carusel20_photo" class="owl-carousel owl-theme slider pos-relative mg-top-15">
                                            %module_value%
                                        </div>
                                    </div>
                                </main>
                            </div>
                        </div>
                    ',
                );
                break;

            case 12:
                //До и После
                $template = array(
                    //Белый фон
                    1 => '
		                <main role="main" class="all" style="background:#fff">
                            <div class="container">
                                <h2 class="main-caption mg-bottom-24 caption-big">%title%</h2>
                            </div>
                        </main>
                        <div class="slide-after mg-bottom-20 mg-top-15">
                            <main class="all" role="main">
                                    %module_value%
                            </main>
                        </div>
                    ',
                    //Серый фон
                    2 => '
                    <div  class="news-block gray-bg">
                    		                <main role="main" class="all">
                            <div class="container">
                                <h2 class="main-caption mg-bottom-24">%title%</h2>
                            </div>
                        </main>
                        <div class="slide-after mg-bottom-20 mg-top-15">
                            <main class="all" role="main">
                                %module_value%
                            </main>
                        </div>
                    </div>
                    ',
                );
                break;
        }


        //Получаю темплейт для модуля
        $template_tmp = $template[$model->template_id];

        //Для врачей %module_value% - это карусель, для других вариантов - повторяем темплейт для каждого элемента
        $module_value_array = array();
        $module_count_elements = 0;
        foreach ( (explode("|", $model->site_module_value)) as $data ){
            if (empty($data)){ continue; }
            ++$module_count_elements;
            $module_value_array[$data] = $data;
        }


        //Шаблоны элемента %module_value%
        switch ($model->site_module_id) {
            case 1:
                //Новости
                $tmp_module_value = '';
                foreach ($module_value_array as $value){
                    if ($modelData = NewsRubrics::model()->find('id in ('.$value.') AND `status` = 1') ){
                        $i = 0;
                        $count = 5;
                        foreach (NewsElements::model()->findAll('parent_id='.$modelData->id.' AND `status` = 1') as $modelElements ) {
                            ++$i;
                            if ($i > $count) {continue;}
                            $tmp_module_value .= '
                            <div class="ot">
                                <span href="#">'.$modelData->name.' - '.
                                    (date("d.m.Y", strtotime($modelElements->maindate))).'</span></span><BR>
                                '.$modelElements->name.'
                            ';
                            if (!empty($modelElements->brieftext)){
                                $tmp_module_value .= '<BR>'.$modelElements->brieftext;
                            }
                            $tmp_module_value .= '</div>';
                        }
                        if ($i>0) { $tmp_module_value .= '<a class="all-otv" href="/news/'.$modelData->url.'">Все новости</a>'; }
                    }
                }

                $resultHTML = $template_tmp;
                $title = $model->title;
                $resultHTML = str_replace("%module_value%", $tmp_module_value, $resultHTML);
                break;
            case 6:
                //Статьи
                $tmp_module_value = '';
                foreach ($module_value_array as $value){
                    if ($modelData = ArticleRubrics::model()->find('id in ('.$value.') AND `status` = 1') ){
                        $i = 0;
                        $count = 5;
                        foreach (ArticleElements::model()->findAll('parent_id='.$modelData->id.' AND `status` = 1') as $modelElements ){
                            ++$i;
                            if ($i>$count){continue;}
                            $tmp_module_value .= '
                            <div class="review_block">
                                <span>'.$modelElements->name.' - '.(date("d.m.Y", strtotime($modelElements->maindate))).'</span><BR>
                                <p>'.$modelElements->brieftext.'</p>
                            </div>';
                        }
                        if ($i>0) { $tmp_module_value .= '<a class="all-otv" style="margin-bottom:20px;" href="'.Yii::app()->request->requestUri.'/'.(($module_count_elements>1)?($modelData->url.'/'):('')).'article">Все статьи</a>'; }
                    }
                }
                $resultHTML = $template_tmp;
                $title = $model->title;
                $resultHTML = str_replace("%module_value%", $tmp_module_value, $resultHTML);
                break;
            case 7:
                //Вопрос-ответ
                $tmp_module_value = '';
                foreach ($module_value_array as $value){
                    if ($modelData = FaqRubrics::model()->find('id in ('.$value.') AND `status` = 1') ){
                        $i = 0;
                        $count = 5;
                        foreach (FaqElements::model()->findAll('parent_id='.$modelData->id.' AND `status` = 1') as $modelElements ){
                            ++$i;
                            if ($i>$count){continue;}
                            $modelAuthor = FaqAuthor::model()->findByPk($modelElements->author_id);
                            $tmp_module_value .= '
                                <article>
                                    <div class="question">
                                            <span href="#" style="color:#ed174f; font-size: 16px; font-weight: bold; margin-left: 20px;">'.$modelAuthor->name.'<span> / '.$modelData->name.' - '.(date("d.m.Y", strtotime($modelElements->question_data))).'</span></span>
                                            <div class="q_data">
                                                '.$modelElements->question.'
                                            </div>
                                    </div>
                                ';
                            if (!empty($modelElements->answer)){
                                $tmp_module_value .= '<div class="unswer"><div class="u_data">'.$modelElements->answer.'</div></div>';
                            }
                            $tmp_module_value .= '</article>';
                        }
                        if ($i>0) { $tmp_module_value .= '<a class="all-otv" href="'.Yii::app()->request->requestUri.'/'.(($module_count_elements>1)?($modelData->url.'/'):('')).'question" style="position:relative; z-index:99999; margin-bottom:20px;">Все ответы</a>'; }
                    }
                }

                $resultHTML = $template_tmp;
                $title = $model->title;
                $resultHTML = str_replace("%module_value%", $tmp_module_value, $resultHTML);
                break;
            case 16:
                //Отзывы
                $tmp_module_value = '';
                foreach ($module_value_array as $value){
                    if ($modelData = ReviewRubrics::model()->find('id in ('.$value.') AND `status` = 1') ){
                        $i = 0;
                        $count = 5;
                        foreach (ReviewElements::model()->findAll('parent_id='.$modelData->id.' AND `status` = 1') as $modelElements ) {
                            ++$i;
                            if ($i > $count) {continue;}
                            $modelAuthor = ReviewAuthor::model()->findByPk($modelElements->author_id);
                            $tmp_module_value .= '
                            <div class="review_block" style="padding: 10px; margin-bottom: 10px; margin-top:20px;">
                                <span href="#">'.$modelAuthor->name.'<span> / '.$modelData->name.' - '.(date("d.m.Y", strtotime($modelElements->review_data))).'</span></span><BR>
                                <p>'.$modelElements->review.'</p>
                            </div>';

                        }
                        if ($i>0) { $tmp_module_value .= '<a class="all-otv" href="'.Yii::app()->request->requestUri.'/'.(($module_count_elements>1)?($modelData->url.'/'):('')).'review" style="position:relative; z-index:99999; margin-bottom:20px;">Все отзывы</a>'; }
                    }
                }
                $resultHTML = $template_tmp;
                $title = $model->title;
                $resultHTML = str_replace("%module_value%", $tmp_module_value, $resultHTML);
                break;
            case 10:
                //Врачи
                $tmp_module_value = '';
                foreach ( DoctorElements::model()->findAll('id in ('.(implode(",", $module_value_array)).')') as $data ){
                    $tmp_module_value .= '
                    <div class="item">
                            <div class="doctor">
                                <figure>
                                    '.( (!empty($data->image))?('<img src="/uploads/filestorage/doctor/elements/medium-'.$data->id.'.'.$data->image.'">'):'' ).'
                                </figure>
                                <h1>'.$data->name.'</h1>
                                <article style="margin-top:10px;" class="text-center">
                                    '.$data->anonse.'
                                </article>
                            </div>
                    </div>
                ';
                }

                $resultHTML = $template_tmp;
                $title = $model->title;
                $resultHTML = str_replace("%module_value%", $tmp_module_value, $resultHTML);
                break;
            case 11:
                //Фотогалерея

                $tmp_module_value = '';

                foreach ( PhotoElements::model()->findAll('parent_id in ('.(implode(",", $module_value_array)).')') as $data ){
                    $tmp_module_value .= '
                    <div class="item">
                            <div class="doctor">
                                <figure>
                                    '.( (!empty($data->image))?('<a href="/photo/'.$data->parent->url.'"><img src="/uploads/filestorage/photo/elements/medium-'.$data->id.'.'.$data->image.'"></a>'):'' ).'
                                </figure>
                            </div>
                    </div>
                ';
                }
                $resultHTML = $template_tmp;
                $title = $model->title;
                $resultHTML = str_replace("%module_value%", $tmp_module_value, $resultHTML);
                break;
            case 12:
                //До и После
                $tmp_module_value = '';

                foreach ( BeforeAfterRubrics::model()->findAll('id in ('.(implode(",", $module_value_array)).')') as $data ) {
                    if ($modelImage = BeforeAfterElements::model()->find('parent_id=' . $data->id . ' ORDER BY on_main DESC')) {
                        //URL
                        $parent_url = array();
                        if (!empty($data)){
                            $modelTop = BeforeAfterRubrics::model()->findByPk($data->id);
                            foreach ($modelTop->ancestors()->findAll('level>1') as $dataTop){
                                $parent_url[] = $dataTop->url;
                            }
                        }
                        $tmp_module_value .= '
                        <div class="container">
                            <a href="/before-after/'.(!empty($parent_url)?(implode("/", $parent_url)):'').'"><h4>'.$data->name.'</h4></a>
                            <div class="spisok af-line">
                                <a href="/before-after/'.(!empty($parent_url)?(implode("/", $parent_url)):'').'">
                                <div class="after">
                                    <figure>
                                        <img src="/uploads/filestorage/beforeafter/elements/medium2-before_' . $modelImage->id . '.' . $modelImage->before_photo . '">
                                        <figcaption> ДО </figcaption>
                                    </figure>
                                    <figure>
                                        <img src="/uploads/filestorage/beforeafter/elements/medium2-after_' . $modelImage->id . '.' . $modelImage->before_photo . '">
                                        <figcaption> ПОСЛЕ </figcaption>
                                    </figure>
                                </div>
                                </a>
                            </div>
                        </div>
                        ';
                    }
                }

                $resultHTML = $template_tmp;
                $title = $model->title;
                $resultHTML = str_replace("%module_value%", $tmp_module_value, $resultHTML);
                break;
            case 17:
                //HTML код
                $tmp_module_value = '';
                foreach ( HtmlCode::model()->findAll('id in ('.(implode(",", $module_value_array)).') AND `status`=1') as $data ) {
                    $tmp_module_value .= $data->code;
                }
                $resultHTML = $template_tmp;
                $title = '';
                $resultHTML = str_replace("%module_value%", $tmp_module_value, $resultHTML);
                break;
            default:
                $tmp_module_value = '';
                $tabel_name = $this->moduleID[$model->site_module_id];
                foreach (Yii::app()->db->createCommand()->select('*')->from($tabel_name)->queryAll() as $data){
                    if (!isset($data['description']) || empty($data['description'])){;continue;}
                    $tmp_module_value .= $data['description'];
                }
                $resultHTML .= $template_tmp;
                $title = $model->title;
                $resultHTML = str_replace("%module_value%", $tmp_module_value, $resultHTML);
                break;

        }

        $resultHTML = str_replace("%title%", $title, $resultHTML);
        $resultHTML = str_replace("%description%", $model->description, $resultHTML);

        return $resultHTML;
    }


    /**
     * @param $page_id - ID страницы для которой будем получать ыкоадки
     * Возращает HTML контент вкладок
     */
    public function getTabsContent($page_id){
        $return = '';
        foreach ( PagesTabs::model()->findAll('pages_id = '.$page_id.' ORDER BY order_id ASC') as $data ){

            $return .= PagesTabs::model()->getTemplate($data);
        }
        return $return;
    }


}
